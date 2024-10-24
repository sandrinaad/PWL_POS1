<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\LevelModel;
use App\Models\UserModel;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class ProfileController extends Controller
{
    public function index()
    {
        $id = session('user_id');
        $breadcrumb = (object) [
            'title' => 'Profil User',
            'list' => ['Home', 'User'],
        ];
        $page = (object) [
            'title' => 'Profil',
        ];
        $activeMenu = 'profil'; //set menu yang sedang active
        // Ambil ID user yang sedang login
        $id = Auth::user()->user_id; // Atau Anda bisa menggunakan Auth::user()->id
        $user = UserModel::with('level')->find($id);
        return view('profil.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'activeMenu' => $activeMenu]);
    }
    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }
    // Menyimpan perubahan data user dengan AJAX termasuk file gambar
    public function update_ajax(Request $request, $id)
    {
        // Periksa jika request berasal dari AJAX atau JSON
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'nama' => 'required|max:100',
                'password' => 'nullable|min:5|max:20',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Avatar tidak wajib
            ];
            // Validator untuk validasi data yang dikirim
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // Respon JSON, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(), // Menunjukkan field mana yang error
                ]);
            }
            // Cari user berdasarkan ID
            $user = UserModel::find($id);
            if ($user) {
                // Jika password tidak diisi, hapus dari request agar tidak di-update
                if (!$request->filled('password')) {
                    $request->request->remove('password');
                }
                // if (!$request->filled('avatar')) {
                //     $request->request->remove('avatar');
                // }
                if ($request->hasFile('avatar')) {
                    $fileName = 'profile_' . Auth::user()->user_id . '.' . $request->avatar->getClientOriginalExtension();

                    // Check if an existing profile picture exists and delete it
                    $oldFile = public_path('gambar/'. $fileName);
                    if (Storage::disk('public')->exists($oldFile)) {
                        Storage::disk('public')->delete($oldFile);
                    }

                    $request->avatar->move(public_path('gambar'), $fileName);
                } else {
                    $fileName = 'profil-pic.png'; // default avatar
                }
                UserModel::find($id)->update([
                    'username' => $request->username,
                    'nama' => $request->nama,
                    'password' => $request->password ? bcrypt($request->password) : UserModel::find($id)->password,
                    'level_id' => $request->level_id,
                    'avatar' => $fileName
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ]);
            }
        }
        return redirect('/');
    }
}
