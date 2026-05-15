<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Indikator;
use App\Models\Target;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    // Mengambil program berdasarkan id_klaster
    public function getPrograms($id_klaster)
    {
        $programs = Program::where('id_klaster', $id_klaster)->where('status', 1)->get();
        return response()->json($programs);
    }

    // Mengambil indikator berdasarkan id_program
    public function getIndikators($id_program)
    {
        $indikators = Indikator::where('id_program', $id_program)->where('status', 1)->get();
        return response()->json($indikators);
    }

    // Mengambil target berdasarkan id_indikator
    public function getTargets($id_indikator)
    {
        $totalDesa = \App\Models\Desa::where('status', 1)->count() ?: 1;

        $targets = Target::with('indikator')
                    ->where('id_indikator', $id_indikator)
                    ->where('status', 1)
                    ->get()
                    ->map(function ($target) use ($totalDesa) {
                        $perDesa = round($target->target_tahunan / $totalDesa);
                        $perBulan = round($perDesa / 12);
                        return [
                            'id_target' => $target->id_target,
                            'periode' => $target->periode,
                            'target_tahunan' => $target->target_tahunan,
                            'target_per_desa' => $perDesa,
                            'target_per_bulan' => $perBulan,
                            'total_desa' => $totalDesa,
                            'nama_indikator' => \Illuminate\Support\Str::limit($target->indikator->nama_indikator ?? '', 60),
                        ];
                    });
        return response()->json($targets);
    }

    public function getSisaTarget($id_target, $id_desa, $current_capaian_id = null)
    {
        $target = Target::find($id_target);
        if (!$target) return response()->json(['sisa' => 0, 'kumulatif' => 0, 'target' => 0, 'target_per_desa' => 0, 'target_per_bulan' => 0]);

        $totalDesa = \App\Models\Desa::where('status', 1)->count() ?: 1;
        $targetPerDesa = round($target->target_tahunan / $totalDesa);
        $targetPerBulan = round($targetPerDesa / 12);

        $query = \App\Models\Capaian::where('id_target', $id_target)
                    ->where('id_desa', $id_desa)
                    ->where('status', 1);

        if ($current_capaian_id) {
            $query->where('id_capaian', '!=', $current_capaian_id);
        }

        $kumulatif = $query->sum('capaian_bulan');
        $sisaDesa = $targetPerDesa - $kumulatif;

        return response()->json([
            'target' => $target->target_tahunan,
            'target_per_desa' => $targetPerDesa,
            'target_per_bulan' => $targetPerBulan,
            'total_desa' => $totalDesa,
            'kumulatif' => $kumulatif,
            'sisa' => $sisaDesa
        ]);
    }
}
