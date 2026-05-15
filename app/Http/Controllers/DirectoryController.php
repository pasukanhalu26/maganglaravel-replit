<?php

namespace App\Http\Controllers;

use App\Models\Number;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    public function index()
    {
        return view('directory.index');
    }

    public function search(Request $request)
    {
        // Validasi Anti SQLi & XSS: Hanya mengizinkan angka, spasi, plus, dan strip
        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:20', 'regex:/^[\d\+\-\s]+$/']
        ]);

        // Sanitasi: Menghapus spasi atau karakter aneh sebelum query ke database
        $cleanPhone = preg_replace('/[^\d\+]/', '', $validated['phone']);

        // Query Ringan: Memanggil scope visible() dan memuat tags sekaligus (Eager Loading)
        $number = Number::with('tags')
                        ->visible() 
                        ->where('phone_number', $cleanPhone)
                        ->first();

        return view('directory.results', compact('number', 'cleanPhone'));
    }

    public function togglePrivacy(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'phone_number' => 'required|string',
            'is_hidden' => 'required|boolean'
        ]);

        // Di dunia nyata, Anda harus memastikan Auth::user() adalah pemilik nomor ini
        $number = Number::where('phone_number', $validated['phone_number'])->firstOrFail();
        
        $number->update([
            'is_hidden' => $validated['is_hidden']
        ]);

        return back()->with('success', 'Status privasi berhasil diperbarui.');
    }
}
