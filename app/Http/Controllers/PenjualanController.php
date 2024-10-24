<?php
namespace App\Http\Controllers;
use App\Models\BarangModel;
use App\Models\DetailModel;
use App\Models\PenjualanModel;
use App\Models\UserModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yajra\DataTables\Facades\DataTables;
class PenjualanController extends Controller
{
    public function index()
    {
        $activeMenu = 'penjualan';
        $breadcrumb = (object) [
            'title' => 'Data Penjualan',
            'list' => ['Home', 'Penjualan']
        ];
        $page = (object) [
            'title' => 'Daftar Penjualan yang terdaftar dalam sistem'
        ];
        $penjualan = PenjualanModel::all();
        $barang = BarangModel::all();
        $user = UserModel::all();
        return view('penjualan.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'penjualan' => $penjualan,
            'barang' => $barang,
            'user' => $user,
            'page' => $page
        ]);
    }
    public function list(Request $request)
    {
        $penjualan = PenjualanModel::select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal')
            ->with('user');
        if ($request->user_id) {
            $penjualan->where('user_id', $request->user_id);
        }
        return DataTables::of($penjualan)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($penjualan) { // menambahkan kolom aksi
                // $btn = '<a href="' . url('/penjualan/' . $penjualan->penjualan_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn = '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button>';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
    public function show(string $id)
    {
        $penjualan = PenjualanModel::with(['detail'])->find($id); // Memastikan relasi diambil

        if (!$penjualan) {
            return response()->json([
                'status' => false,
                'message' => 'Data penjualan tidak ditemukan'
            ]);
        }

        return view('penjualan.show', ['penjualan' => $penjualan]);
        // $penjualan = PenjualanModel::with('user')->find($id);
        // $breadcrumb = (object) ['title' => 'Detail Penjualan', 'list' => ['Home', 'Penjualan', 'Detail']];
        // $page = (object) ['title' => 'Detail Penjualan'];
        // $activeMenu = 'penjualan'; // set menu yang sedang aktif
        // return view('penjualan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'activeMenu' => $activeMenu]);
    }

    public function show_ajax(string $id)
    {
        $penjualan = PenjualanModel::with('detail')->find($id);

        if(!$penjualan){
            return response()-> json([
                'status' => false,
                'messege' => 'data level tidak ditemukan'
            ]);
        }

        return view('penjualan.show_ajax', ['penjualan' => $penjualan]);
    }

    public function create_ajax()
    {
        $penjualan = PenjualanModel::all();
        $user = UserModel::all();
        $barang = BarangModel::all();
        return view('penjualan.create_ajax', ['penjualan' => $penjualan, 'user' => $user, 'barang' => $barang]);
    }
    public function store_ajax(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'pembeli' => 'required|string|min:3|max:20',
            'penjualan_kode' => 'required|string|min:3|max:100|unique:t_penjualan,penjualan_kode',
            'penjualan_tanggal' => 'required|date',
            'barang_id' => 'required|array',
            'barang_id.*' => 'numeric',
            'harga' => 'required|array',
            'harga.*' => 'numeric',
            'jumlah' => 'required|array',
            'jumlah.*' => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'msgField' => $validator->errors()
            ]);
        }

        try {
            // Simpan data penjualan
            $penjualan = new PenjualanModel();
            $penjualan->user_id = $request->user_id;
            $penjualan->pembeli = $request->pembeli;
            $penjualan->penjualan_kode = $request->penjualan_kode;
            $penjualan->penjualan_tanggal = $request->penjualan_tanggal;
            $penjualan->save();

            // Simpan detail barang
            foreach ($request->barang_id as $index => $barangId) {
                $detailPenjualan = new DetailModel();
                $detailPenjualan->penjualan_id = $penjualan->penjualan_id;
                $detailPenjualan->barang_id = $barangId;
                $detailPenjualan->harga = $request->harga[$index];
                $detailPenjualan->jumlah = $request->jumlah[$index];
                $detailPenjualan->save();
            }

            return response()->json([
                'status' => true,
                'message' => 'Data penjualan berhasil disimpan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan, data gagal disimpan!',
                'error' => $e->getMessage()
            ]);
        }
    }
    public function edit_ajax($penjualan_id)
{
    try {
        // Mulai dengan mencari penjualan berdasarkan ID, menggunakan eager loading untuk relasi barang
        $penjualan = PenjualanModel::with('barang_penjualan.barang')->find($penjualan_id);

        // Jika data tidak ditemukan
        if (!$penjualan) {
            return response()->json([
                'status' => false,
                'message' => 'Data penjualan tidak ditemukan.'
            ], 404);
        }

        // Ambil data user untuk dropdown pilihan
        $user = UserModel::all();

        // Siapkan response data dengan data penjualan dan barang
        $response = [
            'penjualan' => [
                'penjualan_id' => $penjualan->penjualan_id,
                'pembeli' => $penjualan->pembeli,
                'penjualan_kode' => $penjualan->penjualan_kode,
                'penjualan_tanggal' => $penjualan->penjualan_tanggal->format('Y-m-d'),
                'user_id' => $penjualan->user_id,
            ],
            'barang_penjualan' => $penjualan->barang_penjualan->map(function ($item) {
                return [
                    'barang_id' => $item->barang_id,
                    'nama_barang' => $item->barang->nama_barang,
                    'harga' => $item->harga,
                    'jumlah' => $item->jumlah
                ];
            }),
            'user' => $user->map(function ($u) {
                return [
                    'user_id' => $u->user_id,
                    'username' => $u->username
                ];
            })
        ];

        // Kirim response dalam format JSON untuk ditangani oleh frontend
        return response()->json(['status' => true, 'data' => $response]);

    } catch (\Exception $e) {

        // Jika ada error, kirim response gagal
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan server. Coba lagi nanti.'
        ], 500);
    }
}

    public function update_ajax(Request $request, $penjualan_id)
    {
        // Validasi data input
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'pembeli' => 'required|string|min:3',
            'penjualan_kode' => 'nullable|string|min:3',
            'penjualan_tanggal' => 'required|date',
            'barang_id.*' => 'required|integer|exists:barang,barang_id',
            'jumlah.*' => 'required|integer|min:1',
            'harga.*' => 'required|numeric|min:0'
        ]);
    
        // Cek apakah validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal!',
                'msgField' => $validator->errors()
            ]);
        }
    
        try {
            // Ambil data penjualan berdasarkan ID
            $penjualan = PenjualanModel::findOrFail($penjualan_id);
    
            // Update data penjualan
            $penjualan->user_id = $request->user_id;
            $penjualan->pembeli = $request->pembeli;
            $penjualan->penjualan_kode = $request->penjualan_kode;
            $penjualan->penjualan_tanggal = $request->penjualan_tanggal;
            $penjualan->save();
    
            // Update atau tambahkan data barang yang dibeli
            $barangData = [];
            foreach ($request->barang_id as $key => $barang_id) {
                $jumlah = $request->jumlah[$key];
                $harga = $request->harga[$key];
                $totalHarga = $jumlah * $harga;
    
                // Simpan data barang ke array
                $barangData[] = [
                    'barang_id' => $barang_id,
                    'jumlah' => $jumlah,
                    'harga_satuan' => $harga,
                    'harga_total' => $totalHarga,
                ];
            }
    
            // Hapus barang penjualan yang lama
            $penjualan->barangPenjualan()->delete();
    
            // Simpan data barang baru
            $penjualan->barangPenjualan()->createMany($barangData);
    
            // Return response sukses
            return response()->json([
                'status' => true,
                'message' => 'Data penjualan berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            // Return response error
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat memperbarui data penjualan: ' . $e->getMessage()
            ]);
        }
    }
    
    public function confirm_ajax(string $penjualan_id)
    {
        // Mencari data penjualan berdasarkan ID
        $penjualan = PenjualanModel::find($penjualan_id);
    
        // Jika data penjualan ditemukan, ambil detail penjualan
        if ($penjualan) {
            // Ambil detail barang terkait penjualan
            $penjualanDetail = DetailModel::where('penjualan_id', $penjualan_id)->get();
    
            // Kirim data ke view 'penjualan.confirm_ajax'
            return view('penjualan.confirm_ajax', [
                'penjualan' => $penjualan,
                'penjualanDetail' => $penjualanDetail // Kirim juga detail barang
            ]);
        } else {
            // Jika penjualan tidak ditemukan, kembalikan response JSON untuk kesalahan
            return response()->json([
                'status' => false,
                'message' => 'Data penjualan tidak ditemukan.'
            ], 404);
        }
    }
    
    public function delete_ajax(Request $request, $penjualan_id)
    {
        // Cek apakah request datang dari AJAX atau menginginkan respons JSON
        if ($request->ajax() || $request->wantsJson()) {
            // Cari data penjualan berdasarkan ID
            $penjualan = PenjualanModel::find($penjualan_id);
    
            // Jika penjualan ditemukan
            if ($penjualan) {
                try {
                    // Lakukan penghapusan dalam sebuah transaksi untuk konsistensi data
                    DB::transaction(function () use ($penjualan) {
                        // Hapus semua detail penjualan terkait
                        DetailModel::where('penjualan_id', $penjualan->penjualan_id)->delete();
    
                        // Hapus data penjualan
                        $penjualan->delete();
                    });
    
                    // Return success response
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus'
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    // Jika ada error dalam penghapusan
                    return response()->json([
                        'status' => false,
                        'message' => 'Data gagal dihapus karena terdapat relasi dengan tabel lain'
                    ]);
                }
            } else {
                // Jika penjualan tidak ditemukan
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
    
        // Jika bukan request AJAX, redirect ke halaman utama
        return redirect('/');
    }
    public function import()
    {
        return view('penjualan.import');
    }
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_penjualan' => ['required', 'mimes:xlsx', 'max:1024'] // Validasi file
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            $file = $request->file('file_penjualan'); // Mengambil file dari request
            $reader = IOFactory::createReader('Xlsx'); // Load Excel reader
            $reader->setReadDataOnly(true); // Hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // Load file Excel
            $sheet = $spreadsheet->getActiveSheet(); // Ambil sheet aktif

            $data = $sheet->toArray(null, false, true, true); // Ubah data sheet menjadi array

            $insertPenjualan = [];
            $insertDetailPenjualan = [];

            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $penjualan_tanggal = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value['D'])->format('Y-m-d H:i:s');

                        // Proses data untuk tabel t_penjualan
                        $penjualan = PenjualanModel::updateOrCreate(
                            [
                                'penjualan_kode' => $value['C'] // Cek kode penjualan untuk menghindari duplikasi
                            ],
                            [
                                'user_id' => $value['A'],
                                'pembeli' => $value['B'],
                                'penjualan_kode' => $value['C'],
                                'penjualan_tanggal' => $penjualan_tanggal,
                                'created_at' => now(),
                                'updated_at' => now()
                            ]
                        );

                        // Jika penjualan berhasil diupdate/insert, proses detail penjualan
                        $insertDetailPenjualan[] = [
                            'penjualan_id' => $penjualan->penjualan_id, // Relasi ke penjualan_id di tabel t_penjualan
                            'barang_id' => $value['E'],
                            'harga' => $value['F'],
                            'jumlah' => $value['G'],
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                }

                // Insert detail penjualan
                if (count($insertDetailPenjualan) > 0) {
                    DetailModel::insertOrIgnore($insertDetailPenjualan);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/');
    }
    public function export_excel()
    {
        // ambil data barang yang akan di export
        $penjualan = PenjualanModel::select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal')
            ->orderBy('penjualan_id')
            ->with('user')
            ->get();
        // load library excel
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Penjualan');
        $sheet->setCellValue('C1', 'Pembeli');
        $sheet->setCellValue('D1', 'Username');
        $sheet->setCellValue('E1', 'Tanggal Penjualan');
        $sheet->getStyle('A1:E1')->getFont()->setBold(true); // bold header
        $no = 1; // nomor data dimulai dari 1
        $baris = 2; // baris data dimulai dari baris ke 2
        foreach ($penjualan as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->penjualan_kode);
            $sheet->setCellValue('D' . $baris, $value->user->username);
            $sheet->setCellValue('C' . $baris, $value->pembeli);
            $sheet->setCellValue('E' . $baris, $value->penjualan_tanggal);
            $baris++;
            $no++;
        }
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true); // set auto size untuk kolom
        }
        $sheet->setTitle('Data penjualan'); // set title sheet
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data penjualan ' . date('Y-m-d H:i:s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified:' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer->save('php://output');
        exit;
    } // end function export_excel
    public function export_pdf()
    {
        $penjualan = PenjualanModel::select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal')
            ->orderBy('penjualan_id')
            ->with('user')
            ->get();
        $pdf = Pdf::loadView('penjualan.export_pdf', ['penjualan' => $penjualan]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url $pdf->render();
        return $pdf->stream('Data penjualan' . date('Y-m-d H:i:s') . '.pdf');
    }
}