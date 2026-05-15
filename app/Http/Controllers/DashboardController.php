<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Klaster;
use App\Models\Desa;
use App\Models\Program;
use App\Models\Indikator;
use App\Models\Capaian;
use App\Models\Target;
// Tambah ini buat ngambil data gabungan dari database
use Illuminate\Support\Facades\DB; 

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // === FILTER PERIODE (TAHUN) ===
        $availableYears = Target::select('periode')->distinct()->orderBy('periode', 'desc')->pluck('periode')->toArray();
        if (empty($availableYears)) {
            $availableYears = [date('Y')];
        }
        $selectedYear = $request->get('periode', $availableYears[0] ?? date('Y'));

        // === 1. TOTAL COUNTS ===
        $total_klaster = Klaster::where('status', 1)->count();
        $total_desa = Desa::where('status', 1)->count();
        $total_program = Program::where('status', 1)->count();
        $total_indikator = Indikator::where('status', 1)->count();
        $total_target = Target::where('periode', $selectedYear)->where('status', 1)->count();

        // === 2. TARGET vs CAPAIAN OVERVIEW ===
        $targets_year = Target::with(['klaster', 'program', 'indikator'])
            ->where('periode', $selectedYear)
            ->where('status', 1)
            ->get();

        $target_ids = $targets_year->pluck('id_target')->toArray();

        // Total target tahunan (sum of all target_tahunan for the year)
        $sum_target_tahunan = $targets_year->sum('target_tahunan');

        // Total capaian kumulatif (sum of all capaian_bulan for targets in this year)
        $sum_capaian_kumulatif = Capaian::whereIn('id_target', $target_ids)
            ->where('status', 1)
            ->sum('capaian_bulan');

        // Overall progress percentage
        $overall_progress = $sum_target_tahunan > 0 
            ? round(($sum_capaian_kumulatif / $sum_target_tahunan) * 100, 1) 
            : 0;

        // Current month for expected progress
        $current_month = (int) date('n');
        $expected_progress = round(($current_month / 12) * 100, 1);

        // === 3. MONTHLY TARGET vs ACHIEVEMENT (Bar Chart) ===
        $bulan_names = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        
        // Monthly target = target_tahunan / 12 for each target, summed
        $monthly_target_value = $sum_target_tahunan > 0 ? round($sum_target_tahunan / 12) : 0;
        
        $monthly_capaian = [];
        $monthly_cumulative = [];
        $running_cumulative = 0;
        
        for ($m = 1; $m <= 12; $m++) {
            $cap = Capaian::whereIn('id_target', $target_ids)
                ->where('status', 1)
                ->where('bulan', $m)
                ->sum('capaian_bulan');
            $monthly_capaian[] = $cap;
            $running_cumulative += $cap;
            $monthly_cumulative[] = $running_cumulative;
        }

        // Monthly target line (cumulative expected)
        $monthly_target_cumulative = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthly_target_cumulative[] = round($sum_target_tahunan * ($m / 12));
        }

        // === 4. PER KLASTER BREAKDOWN ===
        $klaster_data = [];
        $klasters = Klaster::where('status', 1)->get();
        
        foreach ($klasters as $klaster) {
            $klaster_targets = $targets_year->where('id_klaster', $klaster->id_klaster);
            $klaster_target_ids = $klaster_targets->pluck('id_target')->toArray();
            $klaster_target_sum = $klaster_targets->sum('target_tahunan');
            
            $klaster_capaian_sum = Capaian::whereIn('id_target', $klaster_target_ids)
                ->where('status', 1)
                ->sum('capaian_bulan');
            
            $klaster_progress = $klaster_target_sum > 0 
                ? round(($klaster_capaian_sum / $klaster_target_sum) * 100, 1) 
                : 0;

            $klaster_data[] = [
                'nama' => $klaster->nama_klaster,
                'target' => $klaster_target_sum,
                'capaian' => $klaster_capaian_sum,
                'progress' => $klaster_progress,
                'jumlah_indikator' => $klaster_targets->count(),
            ];
        }

        // === 5. DETAIL TABLE: PER INDIKATOR WITH MONTHLY BREAKDOWN ===
        $indikator_detail = [];
        foreach ($targets_year as $target) {
            $monthly_detail = [];
            $cumulative = 0;
            
            for ($m = 1; $m <= 12; $m++) {
                $cap = Capaian::where('id_target', $target->id_target)
                    ->where('status', 1)
                    ->where('bulan', $m)
                    ->sum('capaian_bulan');
                $cumulative += $cap;
                $monthly_detail[$m] = [
                    'capaian' => $cap,
                    'kumulatif' => $cumulative,
                ];
            }

            $persen = $target->target_tahunan > 0 
                ? round(($cumulative / $target->target_tahunan) * 100, 1) 
                : 0;

            $status_label = 'belum';
            if ($persen >= 100) {
                $status_label = 'tercapai';
            } elseif ($persen >= ($current_month / 12 * 100)) {
                $status_label = 'on-track';
            } else {
                $status_label = 'behind';
            }

            $indikator_detail[] = [
                'klaster' => $target->klaster->nama_klaster ?? '-',
                'program' => $target->program->nama_program ?? '-',
                'indikator' => $target->indikator->nama_indikator ?? '-',
                'target_tahunan' => $target->target_tahunan,
                'capaian_kumulatif' => $cumulative,
                'persen' => $persen,
                'status' => $status_label,
                'monthly' => $monthly_detail,
            ];
        }

        // === 6. TOP ACHIEVERS & BEHIND SCHEDULE ===
        $achieved_count = collect($indikator_detail)->where('status', 'tercapai')->count();
        $ontrack_count = collect($indikator_detail)->where('status', 'on-track')->count();
        $behind_count = collect($indikator_detail)->where('status', 'behind')->count();
        $belum_count = collect($indikator_detail)->where('status', 'belum')->count();

        // === 7. PROGRAM PER KLASTER (legacy doughnut) ===
        $program_per_klaster = DB::table('programs')
            ->join('klasters', 'programs.id_klaster', '=', 'klasters.id_klaster')
            ->where('programs.status', 1)
            ->select('klasters.nama_klaster', DB::raw('COUNT(programs.id_program) as jumlah'))
            ->groupBy('klasters.id_klaster', 'klasters.nama_klaster')
            ->get();
        $label_klaster = $program_per_klaster->pluck('nama_klaster');
        $data_klaster = $program_per_klaster->pluck('jumlah');

        // === 8. PER-DESA PER-INDIKATOR ACHIEVEMENT ===
        $desas = Desa::where('status', 1)->get();
        $total_desa_count = $desas->count() ?: 1;

        // Ambil semua capaian tahun ini untuk optimasi (mencegah N+1)
        $all_capaians = Capaian::whereIn('id_target', $target_ids)
            ->where('status', 1)
            ->get();

        $desa_indikator_data = [];
        foreach ($desas as $desa) {
            $indikators_desa = [];
            $terpenuhi = 0;
            $belum_terpenuhi = 0;

            foreach ($targets_year as $target) {
                $target_per_desa_ind = round($target->target_tahunan / $total_desa_count);
                // Menghindari pembagian target yang ganjil agar per bulan presisi jika mungkin
                $target_per_bulan_ind = ceil($target_per_desa_ind / 12);

                $monthly_desa_capaian = [];
                $capaian_ind = 0;

                // Loop bulan 1-12
                for ($m = 1; $m <= 12; $m++) {
                    $cap_bulan = $all_capaians
                        ->where('id_target', $target->id_target)
                        ->where('id_desa', $desa->id_desa)
                        ->where('bulan', $m)
                        ->sum('capaian_bulan');
                    
                    $monthly_desa_capaian[$m] = $cap_bulan;
                    $capaian_ind += $cap_bulan;
                }

                $sisa = $target_per_desa_ind - $capaian_ind;
                $progress = $target_per_desa_ind > 0 ? round(($capaian_ind / $target_per_desa_ind) * 100, 1) : 0;
                $is_tercapai = $progress >= 100;

                if ($is_tercapai) $terpenuhi++;
                else $belum_terpenuhi++;

                $indikators_desa[] = [
                    'indikator' => $target->indikator->nama_indikator ?? '-',
                    'klaster' => $target->klaster->nama_klaster ?? '-',
                    'target_desa' => $target_per_desa_ind,
                    'target_bulan' => $target_per_bulan_ind,
                    'capaian' => $capaian_ind,
                    'monthly' => $monthly_desa_capaian,
                    'sisa' => $sisa,
                    'progress' => $progress,
                    'tercapai' => $is_tercapai,
                ];
            }

            $desa_indikator_data[] = [
                'nama' => $desa->nama_desa,
                'terpenuhi' => $terpenuhi,
                'belum' => $belum_terpenuhi,
                'total' => count($indikators_desa),
                'indikators' => $indikators_desa,
                'score' => count($indikators_desa) > 0 ? round(($terpenuhi / count($indikators_desa)) * 100) : 0,
            ];
        }

        // Actionable Insights: Top 3 and Bottom 3 Villages
        $sorted_desa = collect($desa_indikator_data)->sortByDesc('score');
        $top_villages = $sorted_desa->take(3)->values()->all();
        $bottom_villages = $sorted_desa->reverse()->take(3)->values()->all();

        return view('dashboard', compact(
            'availableYears', 'selectedYear',
            'total_klaster', 'total_desa', 'total_program', 'total_indikator', 'total_target',
            'sum_target_tahunan', 'sum_capaian_kumulatif', 'overall_progress',
            'current_month', 'expected_progress',
            'bulan_names', 'monthly_target_value', 'monthly_capaian', 'monthly_cumulative',
            'monthly_target_cumulative',
            'klaster_data',
            'indikator_detail',
            'achieved_count', 'ontrack_count', 'behind_count', 'belum_count',
            'label_klaster', 'data_klaster',
            'desa_indikator_data', 'total_desa_count',
            'top_villages', 'bottom_villages'
        ));
    }

    /**
     * AJAX: Tren Program (monthly line chart data)
     */
    public function trendProgram(Request $request)
    {
        $year = $request->get('periode', date('Y'));
        $id_klaster = $request->get('id_klaster');
        $id_program = $request->get('id_program');
        $id_indikator = $request->get('id_indikator');

        $query = Target::where('periode', $year)->where('status', 1);
        if ($id_klaster) $query->where('id_klaster', $id_klaster);
        if ($id_program) $query->where('id_program', $id_program);
        if ($id_indikator) $query->where('id_indikator', $id_indikator);

        $targets = $query->get();
        $target_ids = $targets->pluck('id_target')->toArray();
        $sum_target = $targets->sum('target_tahunan');
        $monthly_target = $sum_target > 0 ? round($sum_target / 12) : 0;

        $capaian_data = [];
        $target_data = [];
        for ($m = 1; $m <= 12; $m++) {
            $cap = Capaian::whereIn('id_target', $target_ids)
                ->where('status', 1)->where('bulan', $m)
                ->sum('capaian_bulan');
            $capaian_data[] = $cap;
            $target_data[] = $monthly_target;
        }

        return response()->json([
            'capaian' => $capaian_data,
            'target' => $target_data,
            'sum_target' => $sum_target,
        ]);
    }

    /**
     * AJAX: Tren Desa (bar chart per desa)
     */
    public function trendDesa(Request $request)
    {
        $year = $request->get('periode', date('Y'));
        $id_klaster = $request->get('id_klaster');
        $id_program = $request->get('id_program');
        $id_indikator = $request->get('id_indikator');

        $query = Target::where('periode', $year)->where('status', 1);
        if ($id_klaster) $query->where('id_klaster', $id_klaster);
        if ($id_program) $query->where('id_program', $id_program);
        if ($id_indikator) $query->where('id_indikator', $id_indikator);

        $targets = $query->get();
        $target_ids = $targets->pluck('id_target')->toArray();
        $sum_target = $targets->sum('target_tahunan');

        $desas = Desa::where('status', 1)->get();
        $totalDesa = $desas->count() ?: 1;
        $targetPerDesa = round($sum_target / $totalDesa);
        $labels = [];
        $capaian_vals = [];
        $target_vals = [];

        foreach ($desas as $desa) {
            $labels[] = $desa->nama_desa;
            $capaian_vals[] = Capaian::whereIn('id_target', $target_ids)
                ->where('id_desa', $desa->id_desa)
                ->where('status', 1)
                ->sum('capaian_bulan');
            $target_vals[] = $targetPerDesa; // target dibagi rata per desa
        }

        return response()->json([
            'labels' => $labels,
            'capaian' => $capaian_vals,
            'target' => $target_vals,
        ]);
    }
}