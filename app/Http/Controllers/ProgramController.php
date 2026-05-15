<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Klaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $data = Program::with('klaster')
            ->when($katakunci, function ($q) use ($katakunci) {
                $q->where('nama_program', 'like', "%{$katakunci}%")
                  ->orWhere('id_program', 'like', "%{$katakunci}%")
                  ->orWhere('id_klaster', 'like', "%{$katakunci}%")
                  ->orWhereHas('klaster', function ($k) use ($katakunci) {
                      $k->where('nama_klaster', 'like', "%{$katakunci}%");
                  });
            })
            ->latest('updated_at')->paginate(10)->withQueryString();
        return view('program.index', compact('data'));
    }

    public function create()
    {
        $klasters = Klaster::where('status', 1)->get(); // Hanya tampilkan klaster yang aktif
        return view('program.create', compact('klasters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_klaster' => 'required',
            'nama_program' => 'required',
        ]);

        Program::create([
            'id_klaster' => $request->id_klaster,
            'nama_program' => $request->nama_program,
            'status' => $request->status ?? 1,
            'create_by' => Auth::user()->name,
        ]);

        return redirect()->route('program.index')->with('success', 'Program berhasil ditambah!');
    }

    public function edit($id)
    {
        $program = Program::findOrFail($id);
        $klasters = Klaster::all();
        return view('program.edit', compact('program', 'klasters'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_klaster' => 'required',
            'nama_program' => 'required',
        ]);

        $program = Program::findOrFail($id);
        $program->update([
            'id_klaster' => $request->id_klaster,
            'nama_program' => $request->nama_program,
            'status' => $request->status,
            'update_by' => Auth::user()->name,
        ]);

        return redirect()->route('program.index')->with('success', 'Program berhasil diupdate!');
    }

    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        
        // Proteksi Hard Delete
        if($program->indikators()->count() > 0 && $program->status == 1) {
            return redirect()->route('program.index')->with('error', 'Gagal menonaktifkan! Masih ada Indikator di dalam Program ini.');
        }

        $newStatus = $program->status == 1 ? 0 : 1;
        $program->update([
            'status' => $newStatus
        ]);

        $pesan = $newStatus == 1 ? 'Data Program berhasil diaktifkan!' : 'Data Program berhasil dinonaktifkan!';
        return redirect()->route('program.index')->with('success', $pesan);
    }
}