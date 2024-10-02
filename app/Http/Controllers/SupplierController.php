<?php

namespace App\Http\Controllers;

use App\Models\StokModel;
use App\Models\SupplierModel; // Pastikan ini sesuai dengan nama model yang kamu gunakan
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller
{
    // Menampilkan halaman daftar supplier
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Supplier',
            'list' => ['Home', 'Supplier']
        ];
        $page = (object) [
            'title' => 'Daftar supplier yang terdaftar dalam sistem'
        ];
        $activeMenu = 'supplier'; // set menu yang sedang aktif

        $supplier = StokModel::all(); // ambil data supplier untuk filter

        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'activeMenu' => $activeMenu]);
    }

    // Ambil data supplier dalam bentuk JSON untuk datatables
    public function list(Request $request)
    {
        $suppliers = StokModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat');

        // Filter data supplier berdasarkan supplier_id
        if ($request->supplier_id) {
            $suppliers->where('supplier_id', $request->supplier_id);
        }

        return DataTables::of($suppliers)
            ->addIndexColumn()
            ->addColumn('aksi', function ($supplier) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/stok/' . $supplier->supplier_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/stok/' . $supplier->supplier_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' .
                    url('/stok/' . $supplier->supplier_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah HTML
            ->make(true);
    }

    // Menampilkan halaman form tambah supplier
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Supplier',
            'list' => ['Home', 'Supplier', 'Tambah']
        ];
        $page = (object) [
            'title' => 'Tambah supplier baru'
        ];

        $activeMenu = 'supplier'; // set menu yang sedang aktif
        return view('stok.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan data supplier baru
    public function store(Request $request)
    {
        $request->validate([
            'supplier_kode' => 'required|string|unique:m_supplier,supplier_kode', // supplier_kode harus unik
            'supplier_nama' => 'required|string|max:100', // supplier_nama harus diisi dan maksimal 100 karakter
            'supplier_alamat' => 'nullable|string|max:255' // supplier_alamat opsional
        ]);

        StokModel::create([
            'supplier_kode' => $request->supplier_kode,
            'supplier_nama' => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat,
        ]);

        return redirect('/stok')->with('success', 'Data supplier berhasil disimpan');
    }

    // Menampilkan detail supplier
    public function show(string $id)
    {
        $supplier = StokModel::find($id);

        if (!$supplier) {
            return redirect('/stok')->with('error', 'Data supplier tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Detail Supplier',
            'list' => ['Home', 'Supplier', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail supplier'
        ];
        $activeMenu = 'stok'; // set menu yang sedang aktif
        return view('stok.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'activeMenu' => $activeMenu]);
    }

    // Menampilkan halaman form edit supplier
    public function edit(string $id)
    {
        $supplier = StokModel::find($id);

        if (!$supplier) {
            return redirect('/stok')->with('error', 'Data supplier tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Edit Supplier',
            'list' => ['Home', 'Supplier', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit supplier'
        ];

        $activeMenu = 'supplier'; // set menu yang sedang aktif
        return view('stok.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'supplier' => $supplier, 'activeMenu' => $activeMenu]);
    }

    // Menyimpan perubahan data supplier
    public function update(Request $request, string $id)
    {
        $request->validate([
            'supplier_kode' => 'required|string|unique:m_supplier,supplier_kode,' . $id . ',supplier_id',
            'supplier_nama' => 'required|string|max:100',
            'supplier_alamat' => 'nullable|string|max:255'
        ]);

        $supplier = StokModel::find($id);

        if (!$supplier) {
            return redirect('/stok')->with('error', 'Data supplier tidak ditemukan');
        }

        $supplier->update([
            'supplier_kode' => $request->supplier_kode,
            'supplier_nama' => $request->supplier_nama,
            'supplier_alamat' => $request->supplier_alamat
        ]);

        return redirect('/stok')->with('success', 'Data supplier berhasil diubah');
    }

    // Menghapus data supplier
    public function destroy(string $id)
    {
        $supplier = StokModel::find($id);

        if (!$supplier) {
            return redirect('/stok')->with('error', 'Data supplier tidak ditemukan');
        }

        try {
            $supplier->delete(); // Hapus data supplier
            return redirect('/stok')->with('success', 'Data supplier berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/stok')->with('error', 'Data supplier gagal dihapus karena masih terkait dengan data lain');
        }
    }
}