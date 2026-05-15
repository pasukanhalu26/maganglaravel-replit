<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    /**
     * Generate Kode ID keren berdasarkan ID user.
     * Format: SIP-XXXXXX (hex dari ID, uppercase)
     * Contoh: SIP-000001, SIP-00002A, SIP-0000FF
     */
    private function generateKodeId(int $userId): string
    {
        $hex = strtoupper(base_convert($userId, 10, 36)); // base36 encoding
        return 'SIP-' . str_pad($hex, 6, '0', STR_PAD_LEFT);
    }

    public function index() {
        // Self-healing: Berikan Kode ID ke user yang belum punya
        $missingIds = User::whereNull('username')
                        ->orWhere('username', 'not like', 'SIP-%')
                        ->get();
        
        foreach ($missingIds as $u) {
            $hex = strtoupper(base_convert($u->id, 10, 36));
            $kodeId = 'SIP-' . str_pad($hex, 6, '0', STR_PAD_LEFT);
            $u->update(['username' => $kodeId]);
        }

        $katakunci = request('katakunci');
        $data = User::when($katakunci, function ($q) use ($katakunci) {
                $q->where('name',     'like', "%{$katakunci}%")
                  ->orWhere('username','like', "%{$katakunci}%")
                  ->orWhere('email',   'like', "%{$katakunci}%")
                  ->orWhere('role',    'like', "%{$katakunci}%");
            })
            ->latest('updated_at')->paginate(10)->withQueryString();
        $desas = \App\Models\Desa::all();
        return view('user.index', compact('data', 'desas'));
    }

    public function store(Request $request) {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'nullable|string|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:4',
            'role'     => 'required|in:admin,pj_program,staff_desa',
            'id_desa'  => 'nullable|exists:desas,id_desa',
        ], [
            'name.required'    => 'Nama wajib diisi.',
            'email.required'   => 'Email wajib diisi.',
            'email.unique'     => 'Email sudah terdaftar.',
            'password.required'=> 'Password wajib diisi.',
            'password.min'     => 'Password minimal 4 karakter.',
            'role.required'    => 'Role wajib dipilih.',
        ]);

        // Simpan user
        $user = User::create([
            'name'      => $request->name,
            'username'  => $request->username, // Bisa diisi manual atau dibiarkan null buat auto
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => $request->role,
            'id_desa'   => $request->id_desa,
            'status'    => 1,
            'create_by' => Auth::user()->name,
        ]);

        // Refresh user untuk mendapatkan username yang digenerate oleh Trackable Trait (jika tadi null)
        $user->refresh();
        $kodeId = $user->username;

        return redirect()->route('user.index')
            ->with('success', "User <strong>{$request->name}</strong> berhasil ditambahkan!<br>Kode ID Login: <code style='font-size:1.1em;letter-spacing:2px;'>{$kodeId}</code>");
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,'.$id,
            'role'    => 'required|in:admin,pj_program,staff_desa',
            'id_desa' => 'nullable|exists:desas,id_desa',
        ]);

        $user = User::findOrFail($id);
        $data = [
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'id_desa'   => $request->id_desa,
            'update_by' => Auth::user()->name,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:4'], ['password.min' => 'Password minimal 4 karakter.']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('user.index')->with('success', "Data User <strong>{$user->name}</strong> berhasil diupdate!");
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        $newStatus = $user->status == 1 ? 0 : 1;
        $user->update([
            'status'    => $newStatus,
            'update_by' => Auth::user()->name,
        ]);
        $pesan = $newStatus == 1 ? "User <strong>{$user->name}</strong> berhasil diaktifkan!" : "User <strong>{$user->name}</strong> berhasil dinonaktifkan!";
        return redirect()->route('user.index')->with('success', $pesan);
    }
}