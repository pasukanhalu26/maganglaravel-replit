<?php

namespace App\Http\Controllers;

use App\Models\Klaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KlasterController extends Controller
{
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $data = Klaster::when($katakunci, function ($q) use ($katakunci) {
                $q->where('nama_klaster', 'like', "%{$katakunci}%")
                  ->orWhere('id_klaster', 'like', "%{$katakunci}%");
            })
            ->latest('updated_at')->paginate(10)->withQueryString();
        return view('klaster.index', compact('data'));
    }

    public function create()
    {
        return view('klaster.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama_klaster' => 'required']);

        Klaster::create([
            'nama_klaster' => $request->nama_klaster,
            'status' => $request->status ?? 1,
            'create_by' => Auth::user()->name,
        ]);

        return redirect()->route('klaster.index')->with('success', 'Klaster berhasil ditambah!');
    }

    public function edit($id)
    {
        $klaster = Klaster::findOrFail($id);
        return view('klaster.edit', compact('klaster'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama_klaster' => 'required']);
        
        $klaster = Klaster::findOrFail($id);
        $klaster->update([
            'nama_klaster' => $request->nama_klaster,
            'status' => $request->status,
            'update_by' => Auth::user()->name,
        ]);

        return redirect()->route('klaster.index')->with('success', 'Klaster berhasil diupdate!');
    }

    public function destroy($id)
    {
        $klaster = Klaster::findOrFail($id);
        
        $newStatus = $klaster->status == 1 ? 0 : 1;
        $klaster->update([
            'status' => $newStatus
        ]);

        $pesan = $newStatus == 1 ? 'Data Klaster berhasil diaktifkan!' : 'Data Klaster berhasil dinonaktifkan!';
        return redirect()->route('klaster.index')->with('success', $pesan);
    }
}