<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesaController extends Controller
{
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $data = Desa::when($katakunci, function ($q) use ($katakunci) {
                $q->where('nama_desa', 'like', "%{$katakunci}%")
                  ->orWhere('id_desa',  'like', "%{$katakunci}%");
            })
            ->latest('updated_at')->paginate(10)->withQueryString();
        return view('desa.index', compact('data'));
    }

    public function create()
    {
        return view('desa.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama_desa' => 'required']);

        Desa::create([
            'nama_desa' => $request->nama_desa,
            'status' => $request->status ?? 1,
            'create_by' => Auth::user()->name,
        ]);

        return redirect()->route('desa.index')->with('success', 'Desa berhasil ditambah!');
    }

    public function edit($id)
    {
        $desa = Desa::findOrFail($id);
        return view('desa.edit', compact('desa'));
    }

    public function update(Request $request, $id)
    {
        $desa = Desa::findOrFail($id);
        $desa->update([
            'nama_desa' => $request->nama_desa,
            'status' => $request->status,
            'update_by' => Auth::user()->name,
        ]);

        return redirect()->route('desa.index')->with('success', 'Desa berhasil diupdate!');
    }

    public function destroy($id)
    {
        $desa = Desa::findOrFail($id);
        
        $newStatus = $desa->status == 1 ? 0 : 1;
        $desa->update([
            'status' => $newStatus
        ]);

        $pesan = $newStatus == 1 ? 'Data Desa berhasil diaktifkan!' : 'Data Desa berhasil dinonaktifkan!';
        return redirect()->route('desa.index')->with('success', $pesan);
    }
}