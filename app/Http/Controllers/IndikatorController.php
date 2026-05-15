<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\Program;
use App\Models\Klaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndikatorController extends Controller
{
    public function index(Request $request)
    {
        // Self-healing: Fix data indikator yang id_klaster-nya masih 0 atau null
        $brokenData = Indikator::whereNull('id_klaster')->orWhere('id_klaster', 0)->get();
        foreach ($brokenData as $i) {
            $p = Program::find($i->id_program);
            if ($p) {
                $i->update(['id_klaster' => $p->id_klaster]);
            }
        }

        $data = Indikator::with(['program', 'klaster'])
            ->when($request->katakunci, function ($q) use ($request) {
                $k = $request->katakunci;
                $q->where('nama_indikator', 'like', "%{$k}%")
                  ->orWhere('id_indikator', 'like', "%{$k}%")
                  ->orWhere('id_program',   'like', "%{$k}%")
                  ->orWhere('id_klaster',   'like', "%{$k}%")
                  ->orWhereHas('program', function ($p) use ($k) {
                      $p->where('nama_program', 'like', "%{$k}%");
                  })
                  ->orWhereHas('klaster', function ($kl) use ($k) {
                      $kl->where('nama_klaster', 'like', "%{$k}%");
                  });
            })
            ->latest('updated_at')->paginate(10)->withQueryString();
        return view('indikator.index', compact('data'));
    }

    public function create()
    {
        $klasters = Klaster::where('status', 1)->get();
        $programs = Program::where('status', 1)->get();
        return view('indikator.create', compact('klasters', 'programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_klaster'     => 'required',
            'id_program'     => 'required',
            'nama_indikator' => 'required',
        ]);

        $id_klaster = $request->id_klaster;
        if (!$id_klaster && $request->id_program) {
            $program = Program::find($request->id_program);
            $id_klaster = $program ? $program->id_klaster : null;
        }

        Indikator::create([
            'id_klaster'     => $id_klaster,
            'id_program'     => $request->id_program,
            'nama_indikator' => $request->nama_indikator,
            'status'         => $request->status ?? 1,
            'create_by'      => Auth::user()->name,
        ]);

        return redirect()->route('indikator.index')->with('success', 'Data Indikator berhasil disimpan!');
    }

    public function edit($id)
    {
        $indikator = Indikator::findOrFail($id);
        $klasters  = Klaster::where('status', 1)->get();
        $programs  = Program::where('status', 1)->get();
        return view('indikator.edit', compact('indikator', 'klasters', 'programs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_klaster'     => 'required',
            'id_program'     => 'required',
            'nama_indikator' => 'required',
        ]);

        $id_klaster = $request->id_klaster;
        if (!$id_klaster && $request->id_program) {
            $program = Program::find($request->id_program);
            $id_klaster = $program ? $program->id_klaster : null;
        }

        $indikator = Indikator::findOrFail($id);
        $indikator->update([
            'id_klaster'     => $id_klaster,
            'id_program'     => $request->id_program,
            'nama_indikator' => $request->nama_indikator,
            'status'         => $request->status,
            'update_by'      => Auth::user()->name,
        ]);

        return redirect()->route('indikator.index')->with('success', 'Data Indikator berhasil diupdate!');
    }

    public function destroy($id)
    {
        $indikator = Indikator::findOrFail($id);
        $newStatus = $indikator->status == 1 ? 0 : 1;
        $indikator->update(['status' => $newStatus, 'update_by' => Auth::user()->name]);

        $pesan = $newStatus == 1 ? 'Data Indikator berhasil diaktifkan!' : 'Data Indikator berhasil dinonaktifkan!';
        return redirect()->route('indikator.index')->with('success', $pesan);
    }

    public function cetakPdf()
    {
        $data = Indikator::with(['program', 'klaster'])->where('status', 1)->orderBy('id_indikator', 'asc')->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('indikator.pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan-Master-Indikator.pdf');
    }
}