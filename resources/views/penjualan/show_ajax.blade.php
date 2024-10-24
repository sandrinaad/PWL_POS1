@if(empty($penjualan))
    <div id="modal-error" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Kesalahan!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan!</h5>
                    Data yang Anda cari tidak dapat ditemukan!
                </div>
                <a href="{{ url('/penjualan') }}" class="btn btn-secondary">Kembali ke Halaman Utama</a>
            </div>
        </div>
    </div>
@else
    @csrf
    <div id="modal-detail" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Informasi Transaksi Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <strong>Kode Penjualan:</strong>
                    <div>{{ $penjualan->penjualan_kode }}</div>
                </div>
                <div class="mb-3">
                    <strong>Pembeli:</strong>
                    <div>{{ $penjualan->pembeli }}</div>
                </div>
                <div class="mb-3">
                    <strong>Tanggal Transaksi:</strong>
                    <div>{{ $penjualan->penjualan_tanggal }}</div>
                </div>
                <div class="mb-3">
                    <strong>Dibeli Oleh:</strong>
                    <div>{{ $penjualan->user->nama }}</div>
                </div>

                <h5 class="mt-4">Rincian Barang:</h5>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah Beli</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penjualan->detail as $detail)
                            <tr>
                                <td>{{ $detail->barang->barang_nama }}</td>
                                <td>{{ number_format($detail->harga, 2, ',', '.') }}</td>
                                <td>{{ $detail->jumlah }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
@endif