<?php

namespace App\Http\Controllers;

use App\Models\{Capaian, Target, Desa};
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Exports\CapaianExport;
use App\Exports\CapaianTemplateExport;
use App\Imports\CapaianImport;
use Maatwebsite\Excel\Facades\Excel;

class CapaianController extends Controller
{
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        
        $data = Capaian::with(['target.indikator', 'target.program', 'target.klaster', 'desa'])
            ->when($katakunci, function ($query, $katakunci) {
                return $query->whereHas('desa', function ($q) use ($katakunci) {
                    $q->where('nama_desa', 'like', "%{$katakunci}%");
                })->orWhereHas('target.indikator', function ($q) use ($katakunci) {
                    $q->where('nama_indikator', 'like', "%{$katakunci}%");
                })->orWhereHas('target.program', function ($q) use ($katakunci) {
                    $q->where('nama_program', 'like', "%{$katakunci}%");
                })->orWhereHas('target.klaster', function ($q) use ($katakunci) {
                    $q->where('nama_klaster', 'like', "%{$katakunci}%");
                })->orWhere('bulan', 'like', "%{$katakunci}%")
                  ->orWhere('id_capaian', 'like', "%{$katakunci}%")
                  ->orWhere('id_target', 'like', "%{$katakunci}%");
            })
            ->latest('updated_at')
            ->paginate(10)
            ->withQueryString();

        return view('capaian.index', compact('data'));
    }

    public function create()
    {
        $klasters = \App\Models\Klaster::where('status', 1)->get();
        // Hanya ambil target yang aktif
        $targets = Target::with(['indikator', 'program', 'klaster'])->where('status', 1)->get();
        $desas = Desa::where('status', 1)->get();
        $userDesaId = Auth::user()->id_desa;
        return view('capaian.create', compact('klasters', 'targets', 'desas', 'userDesaId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_target' => 'required',
            'id_desa' => 'required',
            'bulan' => 'required|integer|between:1,12',
            'capaian_bulan' => 'required|numeric|min:0',
        ]);

        Capaian::create([
            'id_target' => $request->id_target,
            'id_desa' => $request->id_desa,
            'bulan' => $request->bulan,
            'capaian_bulan' => $request->capaian_bulan,
            'analisa_masalah' => $request->analisa_masalah,
            'rtl' => $request->rtl,
            'status' => 1,
            'create_by' => Auth::user()->name,
        ]);

        return redirect()->route('capaian.index')->with('success', 'Data Capaian Berhasil Disimpan!');
    }

    public function edit($id)
    {
        $capaian = Capaian::findOrFail($id);
        $klasters = \App\Models\Klaster::where('status', 1)->get();
        $targets = Target::with(['indikator', 'program', 'klaster'])->where('status', 1)->get();
        $desas = Desa::where('status', 1)->get();
        return view('capaian.edit', compact('capaian', 'klasters', 'targets', 'desas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_target' => 'required',
            'id_desa' => 'required',
            'bulan' => 'required|integer|between:1,12',
            'capaian_bulan' => 'required|numeric|min:0',
        ]);

        $capaian = Capaian::findOrFail($id);
        $capaian->update([
            'id_target' => $request->id_target,
            'id_desa' => $request->id_desa,
            'bulan' => $request->bulan,
            'capaian_bulan' => $request->capaian_bulan,
            'analisa_masalah' => $request->analisa_masalah,
            'rtl' => $request->rtl,
            'status' => $request->status ?? $capaian->status,
            'update_by' => Auth::user()->name,
        ]);

        return redirect()->route('capaian.index')->with('success', 'Data Capaian Berhasil Diupdate!');
    }

    public function destroy($id)
    {
        $capaian = Capaian::findOrFail($id);
        $newStatus = $capaian->status == 1 ? 0 : 1;
        $capaian->update(['status' => $newStatus, 'update_by' => Auth::user()->name]); 
        
        $pesan = $newStatus == 1 ? 'Capaian Berhasil Diaktifkan!' : 'Capaian Berhasil Dinonaktifkan!';
        return redirect()->route('capaian.index')->with('success', $pesan);
    }

    public function formImport()
    {
        $desas = Desa::where('status', 1)->get();
        return view('capaian.import', compact('desas'));
    }

    public function downloadTemplate()
    {
        return Excel::download(new CapaianTemplateExport, 'Template_Input_Capaian.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'id_desa' => 'required',
            'bulan' => 'required|integer|between:1,12',
            'file_excel' => 'required|mimes:xlsx,xls'
        ], [
            'file_excel.mimes' => 'File harus berupa Excel (.xlsx atau .xls)',
        ]);

        try {
            Excel::import(new CapaianImport($request->id_desa, $request->bulan), $request->file('file_excel'));
            return redirect()->route('capaian.index')->with('success', 'Data Capaian berhasil diimport!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    public function cetakExcel()
    {
        $tahun = date('Y');
        $bulans = [1=>'JANUARI',2=>'FEBRUARI',3=>'MARET',4=>'APRIL',5=>'MEI',6=>'JUNI',
                   7=>'JULI',8=>'AGUSTUS',9=>'SEPTEMBER',10=>'OKTOBER',11=>'NOVEMBER',12=>'DESEMBER'];

        $capaians = Capaian::with(['target.indikator', 'target.program', 'target.klaster', 'desa'])
            ->where('status', 1)
            ->get();

        $dataPerBulan = [];
        $namaProgram = 'KESEHATAN IBU DAN ANAK'; // Default

        foreach ($capaians->groupBy('bulan') as $bulanInt => $items) {
            $nama_bulan = $bulans[$bulanInt] ?? 'BULAN ' . $bulanInt;
            
            $totalTarget = $items->sum(function($item) { return $item->target->target_tahunan ?? 0; });
            $totalCapaian = $items->sum('capaian_bulan'); 
            $persenProgram = $totalTarget > 0 ? ($totalCapaian / $totalTarget) : 0;
            
            $namaProgram = $items->first()->target->program->nama_program ?? $namaProgram;

            $formattedItems = [];
            foreach ($items as $index => $item) {
                $target = $item->target->target_tahunan ?? 0;
                $capaian_bulanan = $item->capaian_bulan;
                
                $kumulatif = Capaian::where('id_target', $item->id_target)
                                ->where('id_desa', $item->id_desa)
                                ->where('bulan', '<=', $item->bulan)
                                ->sum('capaian_bulan');
                                
                $persenKumulatif = $target > 0 ? ($kumulatif / $target) : 0;
                
                $isAchieved = ($persenKumulatif * 100) >= ($item->bulan / 12 * 100); 
                $analisaMasalah = $item->analisa_masalah ?: ($isAchieved ? 'tercapai' : 'belum tercapai , masih ada kendala di lapangan');
                $rtl = $item->rtl ?: ($isAchieved ? '' : 'dilaksanakan evaluasi dan perbaikan bulan depan');

                $formattedItems[] = [
                    $index + 1,
                    $item->target->indikator->nama_indikator ?? '-',
                    $target,
                    $capaian_bulanan,
                    $kumulatif,
                    $persenKumulatif,
                    null,
                    $analisaMasalah,
                    $rtl
                ];
            }

            $dataPerBulan[$nama_bulan] = [
                'persentase_program' => $persenProgram,
                'items' => $formattedItems
            ];
        }
        $filename = "Laporan_Capaian_Kinerja_{$tahun}.xlsx";
        return Excel::download(new CapaianExport($dataPerBulan, $tahun, $namaProgram), $filename);
    }

    public function laporan(Request $request)
    {
        $katakunci = $request->katakunci;
        $id_desa = $request->id_desa;
        $bulan = $request->bulan;

        $desas = Desa::where('status', 1)->get();
        
        $data = Capaian::with(['target.indikator', 'target.program', 'target.klaster', 'desa'])
            ->where('status', 1)
            ->when($id_desa, function ($query, $id_desa) {
                return $query->where('id_desa', $id_desa);
            })
            ->when($bulan, function ($query, $bulan) {
                return $query->where('bulan', $bulan);
            })
            ->when($katakunci, function ($query, $katakunci) {
                return $query->whereHas('target.indikator', function ($q) use ($katakunci) {
                    $q->where('nama_indikator', 'like', "%{$katakunci}%");
                });
            })
            ->orderBy('bulan', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('capaian.laporan', compact('data', 'desas'));
    }
}