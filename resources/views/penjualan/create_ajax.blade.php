<form action="{{ url('/penjualan/ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama User</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        <option value="">- Pilih User -</option>
                        @foreach ($user as $l)
                            <option value="{{ $l->user_id }}">{{ $l->nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-user_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama Pembeli</label>
                    <input type="text" name="pembeli" id="pembeli" class="form-control" required>
                    <small id="error-pembeli" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Kode Penjualan</label>
                    <input type="text" name="penjualan_kode" id="penjualan_kode" class="form-control" required>
                    <small id="error-penjualan_kode" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Penjualan</label>
                    <input type="datetime-local" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control" required>
                    <small id="error-penjualan_tanggal" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jumlah Barang</label>
                    <input type="number" id="jumlah_barang" class="form-control" required>
                    <small id="error-jumlah_barang" class="error-text form-text text-danger"></small>
                </div>
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <td>Nama Barang</td>
                            <td>Jumlah</td>
                            <td>Harga Satuan</td>
                            <td>Harga Total</td>
                        </tr>
                    </thead>
                    <tbody id="barang-table"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- jQuery Script for Dynamic Form Handling -->
<script>
    $(document).ready(function() {
        // Dynamically generate barang rows based on jumlah_barang
        $('#jumlah_barang').on('input', function() {
            let jumlah = $(this).val();
            $('#barang-table').empty();  // Clear existing rows
            for (let i = 0; i < jumlah; i++) {
                let newRow = `
                    <tr>
                        <td>
                            <select name="barang_id[${i}]" class="form-control select-barang" required>
                                <option value="">- Pilih Barang -</option>
                                @foreach ($barang as $b)
                                    <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="jumlah[${i}]" class="form-control jumlah-barang" required></td>
                        <td><input type="number" name="harga[${i}]" class="form-control harga-satuan"></td>
                        <td><input type="text" name="harga_total[${i}]" class="form-control harga-total" readonly></td>
                    </tr>
                `;
                $('#barang-table').append(newRow);
            }
        });

       // Calculate harga total when harga satuan is updated
$(document).on('input', '.harga-satuan', function() {
    let row = $(this).closest('tr');
    let hargaSatuan = $(this).val();
    let jumlah = row.find('.jumlah-barang').val();
    let hargaTotal = jumlah * hargaSatuan;
    row.find('.harga-total').val(hargaTotal);
});


        // Calculate harga total when jumlah is updated
        $(document).on('input', '.jumlah-barang', function() {
            let row = $(this).closest('tr');
            let jumlah = $(this).val();
            let hargaSatuan = row.find('.harga-satuan').val();
            let hargaTotal = jumlah * hargaSatuan;
            row.find('.harga-total').val(hargaTotal);
        });

        // Submit form using AJAX
        $("#form-tambah").validate({
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: 'POST',
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
                            dataPenjualan.ajax.reload(); // Reload the DataTable
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