<?php

namespace App\Http\Controllers;

use App\Models\Target;
use App\Models\Klaster;
use App\Models\Program;
use App\Models\Indikator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TargetController extends Controller
{
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $data = Target::with(['klaster', 'program', 'indikator'])
            ->when($katakunci, function ($q) use ($katakunci) {
                $q->where('id_target',   'like', "%{$katakunci}%")
                  ->orWhere('id_klaster', 'like', "%{$katakunci}%")
                  ->orWhere('id_program', 'like', "%{$katakunci}%")
                  ->orWhere('id_indikator', 'like', "%{$katakunci}%")
                  ->orWhere('periode',    'like', "%{$katakunci}%")
                  ->orWhereHas('klaster', function ($k) use ($katakunci) {
                      $k->where('nama_klaster', 'like', "%{$katakunci}%");
                  })
                  ->orWhereHas('program', function ($p) use ($katakunci) {
                      $p->where('nama_program', 'like', "%{$katakunci}%");
                  })
                  ->orWhereHas('indikator', function ($i) use ($katakunci) {
                      $i->where('nama_indikator', 'like', "%{$katakunci}%");
                  });
            })
            ->latest('updated_at')->paginate(10)->withQueryString();
        return view('target.index', compact('data'));
    }

    public function create()
    {
        $klasters  = Klaster::where('status', 1)->get();
        $programs  = Program::where('status', 1)->get();
        $indikators = Indikator::where('status', 1)->get();
        return view('target.create', compact('klasters', 'programs', 'indikators'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_klaster'    => 'required',
            'id_program'    => 'required',
            'id_indikator'  => 'required',
            'periode'       => 'required|integer|min:2000|max:2100',
            'target_tahunan'=> 'required|integer|min:0',
        ], [
            'periode.min'           => 'Periode minimal tahun 2000.',
            'target_tahunan.min'    => 'Target tahunan tidak boleh negatif.',
        ]);

        Target::create([
            'id_klaster'    => $request->id_klaster,
            'id_program'    => $request->id_program,
            'id_indikator'  => $request->id_indikator,
            'periode'       => $request->periode,
            'target_tahunan'=> $request->target_tahunan,
            'status'        => $request->status ?? 1,
            'create_by'     => Auth::user()->name,
        ]);

        return redirect()->route('target.index')->with('success', 'Data Target berhasil disimpan!');
    }

    public function edit($id)
    {
        $target    = Target::findOrFail($id);
        $klasters  = Klaster::where('status', 1)->get();
        $programs  = Program::where('status', 1)->get();
        $indikators = Indikator::where('status', 1)->get();
        return view('target.edit', compact('target', 'klasters', 'programs', 'indikators'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_klaster'    => 'required',
            'id_program'    => 'required',
            'id_indikator'  => 'required',
            'periode'       => 'required|integer|min:2000|max:2100',
            'target_tahunan'=> 'required|integer|min:0',
        ]);

        $target = Target::findOrFail($id);
        $target->update([
            'id_klaster'    => $request->id_klaster,
            'id_program'    => $request->id_program,
            'id_indikator'  => $request->id_indikator,
            'periode'       => $request->periode,
            'target_tahunan'=> $request->target_tahunan,
            'status'        => $request->status,
            'update_by'     => Auth::user()->name,
        ]);

        return redirect()->route('target.index')->with('success', 'Data Target berhasil diupdate!');
    }

    public function destroy($id)
    {
        $target = Target::findOrFail($id);
        $newStatus = $target->status == 1 ? 0 : 1;
        $target->update(['status' => $newStatus, 'update_by' => Auth::user()->name]);

        $pesan = $newStatus == 1 ? 'Target berhasil diaktifkan!' : 'Target berhasil dinonaktifkan!';
        return redirect()->route('target.index')->with('success', $pesan);
    }
}
