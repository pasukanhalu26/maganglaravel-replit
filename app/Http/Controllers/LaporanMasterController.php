<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Klaster, Program, Indikator, Desa, Capaian, Target};
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanMasterExport;

class LaporanMasterController extends Controller
{
    public function index()
    {
        $klasters = Klaster::where('status', 1)->get();
        $desas = Desa::where('status', 1)->get();
        $tahuns = [date('Y'), date('Y')-1, date('Y')-2]; 
        return view('capaian.laporan_baru', compact('klasters', 'desas', 'tahuns'));
    }

    public function getData(Request $request)
    {
        $query = Capaian::with(['target.indikator', 'target.program', 'target.klaster', 'desa'])
            ->where('status', 1);

        if ($request->id_klaster) {
            $query->whereHas('target', function($q) use ($request) {
                $q->where('id_klaster', $request->id_klaster);
            });
        }
        if ($request->id_program) {
            $query->whereHas('target', function($q) use ($request) {
                $q->where('id_program', $request->id_program);
            });
        }
        if ($request->id_indikator) {
            $query->whereHas('target', function($q) use ($request) {
                $q->where('id_indikator', $request->id_indikator);
            });
        }
        if ($request->tahun) {
            $query->whereHas('target', function($q) use ($request) {
                $q->where('periode', $request->tahun);
            });
        }
        if ($request->bulan_dari && $request->bulan_sampai) {
            $query->whereBetween('bulan', [$request->bulan_dari, $request->bulan_sampai]);
        }
        if ($request->id_desa) {
            $query->where('id_desa', $request->id_desa);
        }

        $data = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function getPrograms($id_klaster)
    {
        $programs = Program::where('id_klaster', $id_klaster)->where('status', 1)->get();
        return response()->json($programs);
    }

    public function getIndikators($id_program)
    {
        // Actually usually Indikators are linked via targets or directly
        $indikators = Indikator::where('id_program', $id_program)->where('status', 1)->get();
        return response()->json($indikators);
    }

    public function exportPdf(Request $request)
    {
        $data = $this->getAggregatedData($request);
        $pdf = Pdf::loadView('capaian.pdf_baru', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->download('laporan_capaian.pdf');
    }

    public function exportExcel(Request $request)
    {
        $data = $this->getAggregatedData($request);
        return Excel::download(new LaporanMasterExport($data), 'laporan_capaian_' . date('Ymd_His') . '.xlsx');
    }

    private function getAggregatedData($request)
    {
        $raw = $this->getFilteredData($request);
        $aggregated = collect();

        foreach ($raw->groupBy('bulan') as $bulan => $itemsBulan) {
            foreach ($itemsBulan->groupBy('id_target') as $id_target => $itemsTarget) {
                $firstItem = $itemsTarget->first();
                $sumCapaianBulanan = $itemsTarget->sum('capaian_bulan');
                
                $kumulatifQuery = \App\Models\Capaian::where('id_target', $id_target)
                    ->where('bulan', '<=', $bulan)
                    ->where('status', 1);
                    
                if ($request->id_desa) {
                    $kumulatifQuery->where('id_desa', $request->id_desa);
                }
                
                $sumKumulatif = $kumulatifQuery->sum('capaian_bulan');
                $targetTahunan = $firstItem->target->target_tahunan ?? 0;
                
                $persenKumulatif = $targetTahunan > 0 ? ($sumKumulatif / $targetTahunan * 100) : 0;
                $isAchieved = $persenKumulatif >= ($bulan / 12 * 100);
                              
                $analisa = $isAchieved ? 'tercapai' : 'belum tercapai , masih ada kendala di lapangan';
                $rtl = $isAchieved ? '' : 'dilaksanakan evaluasi dan perbaikan bulan depan';

                if ($request->id_desa && count($itemsTarget) == 1) {
                    $analisa = $firstItem->analisa_masalah ?: $analisa;
                    $rtl = $firstItem->rtl ?: $rtl;
                }

                $aggregated->push((object)[
                    'id_target' => $id_target,
                    'bulan' => $bulan,
                    'target' => $firstItem->target,
                    'capaian_bulan' => $sumCapaianBulanan,
                    'capaian_kumulatif' => $sumKumulatif,
                    'persen_kumulatif' => $persenKumulatif,
                    'analisa_masalah' => $analisa,
                    'rtl' => $rtl
                ]);
            }
        }
        
        // Sort by bulan then by id_target to keep order consistent
        return $aggregated->sortBy(['bulan', 'id_target'])->values();
    }

    private function getFilteredData($request)
    {
        $query = Capaian::with(['target.indikator', 'target.program', 'target.klaster', 'desa'])
            ->where('status', 1);

        if ($request->id_klaster) $query->whereHas('target', fn($q) => $q->where('id_klaster', $request->id_klaster));
        if ($request->id_program) $query->whereHas('target', fn($q) => $q->where('id_program', $request->id_program));
        if ($request->id_indikator) $query->whereHas('target', fn($q) => $q->where('id_indikator', $request->id_indikator));
        if ($request->id_desa) $query->where('id_desa', $request->id_desa);
        if ($request->tahun) {
            $query->whereHas('target', function($q) use ($request) {
                $q->where('periode', $request->tahun);
            });
        }
        if ($request->bulan_dari && $request->bulan_sampai) $query->whereBetween('bulan', [$request->bulan_dari, $request->bulan_sampai]);
        
        return $query->get();
    }
}
