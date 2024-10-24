@empty($penjualan)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                        Data yang anda cari tidak ditemukan
                    </div>
                    <a href="{{ url('/penjualan') }}" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </div>
@else
    <form action="{{ url('/penjualan/' . $penjualan->penjualan_id . '/update_ajax') }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Penjualan Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">User</label>
                        <div class="col-11">
                            <select class="form-control" id="user_id" name="user_id" required>
                                <option value="">- Pilih user -</option>
                                @foreach ($user as $item)
                                    <option {{ $item->user_id == $penjualan->user_id ? 'selected' : '' }}
                                        value="{{ $item->user_id }}">{{ $item->username }}</option>
                                @endforeach
                            </select>
                            <small id="error-user_id" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nama Pembeli</label>
                        <input value="{{ $penjualan->pembeli }}" type="text" name="pembeli" id="pembeli" class="form-control"
                            required>
                        <small id="error-pembeli" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Kode Penjualan</label>
                        <input type="text" name="penjualan_kode" id="penjualan_kode" class="form-control"
                            placeholder="{{ $penjualan->penjualan_kode }}">
                        <small id="error-penjualan_kode" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Penjualan</label>
                        <input value="{{ $penjualan->penjualan_tanggal }}" type="date" name="penjualan_tanggal"
                            id="penjualan_tanggal" class="form-control" required>
                        <small id="error-penjualan_tanggal" class="error-text form-text text-danger"></small>
                    </div>

                    <!-- Bagian Barang yang Dibeli -->
                    <div class="form-group">
                        <label>Barang yang Dibeli</label>
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <td>Nama Barang</td>
                                    <td>Jumlah</td>
                                    <td>Harga Satuan</td>
                                    <td>Harga Total</td>
                                </tr>
                            </thead>
                            <tbody id="barang-table-edit">
                                @foreach($penjualan->barangPenjualan as $i => $barang)
                                    <tr>
                                        <td>
                                            <select name="barang_id[{{ $i }}]" class="form-control select-barang" required>
                                                <option value="">- Pilih Barang -</option>
                                                @foreach ($barangList as $b)
                                                    <option value="{{ $b->barang_id }}" {{ $b->barang_id == $barang->barang_id ? 'selected' : '' }}>
                                                        {{ $b->barang_nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td><input type="number" name="jumlah[{{ $i }}]" class="form-control jumlah-barang" value="{{ $barang->jumlah }}" required></td>
                                        <td><input type="number" name="harga[{{ $i }}]" class="form-control harga-satuan" value="{{ $barang->harga_satuan }}" required></td>
                                        <td><input type="text" name="harga_total[{{ $i }}]" class="form-control harga-total" value="{{ $barang->jumlah * $barang->harga_satuan }}" readonly></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            // Menghitung harga total ketika jumlah atau harga diubah
            $(document).on('input', '.jumlah-barang, .harga-satuan', function() {
                let row = $(this).closest('tr');
                let jumlah = row.find('.jumlah-barang').val();
                let hargaSatuan = row.find('.harga-satuan').val();
                let hargaTotal = jumlah * hargaSatuan;
                row.find('.harga-total').val(hargaTotal);
            });

            // Proses pengiriman form dengan AJAX
            $("#form-edit").validate({
                rules: {
                    user_id: {
                        required: true,
                        number: true
                    },
                    pembeli: {
                        required: true,
                        minlength: 3
                    },
                    penjualan_kode: {
                        required: false,
                        minlength: 3
                    },
                    penjualan_tanggal: {
                        required: true,
                        date: true
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message
                                });
                                dataPenjualan.ajax.reload(); // Reload data
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan!'
                            });
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endempty
