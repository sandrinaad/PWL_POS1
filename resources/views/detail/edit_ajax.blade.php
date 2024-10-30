<form action="{{ url('/detail/edit_ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data Detail Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Kode Penjualan</label>
                    <select class="form-control" id="penjualan_id" name="penjualan_id" required>
                        <option value="">- Pilih penjualan -</option>
                        @foreach ($penjualan as $a)
                            <option value="{{ $a->penjualan_id }}">{{ $a->penjualan_kode }}</option>
                        @endforeach
                    </select>
                    <small id="error-penjualan_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Barang</label>
                    <select class="form-control" id="barang_id" name="barang_id" required>
                        <option value="">- Pilih barang -</option>
                        @foreach ($barang as $b)
                            <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-barang_id" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Harga</label>
                    <input value="" type="text" name="harga" id="harga" class="form-control" required readonly>
                    <small id="error-harga" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Jumlah</label>
                    <input value="" type="text" name="jumlah" id="jumlah" class="form-control" required>
                    <small id="error-jumlah" class="error-text form-text text-danger"></small>
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
    // Event listener untuk barang_id
    $('#barang_id').on('change', function() {
        let barangId = $(this).val();
        if (barangId) {
            $.ajax({
                url: "{{ url('/barang/harga') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    barang_id: barangId
                },
                success: function(response) {
                    if (response.status) {
                        $('#harga').val(response.harga); // Isi harga otomatis
                    } else {
                        $('#harga').val(''); // Reset harga jika tidak ditemukan
                        Swal.fire({
                            icon: 'error',
                            title: 'Barang tidak ditemukan',
                            text: response.message
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Tidak dapat mengambil data harga'
                    });
                }
            });
        } else {
            $('#harga').val(''); // Kosongkan kolom harga jika tidak ada barang yang dipilih
        }
    });

    // Event listener untuk tombol edit
    $(document).on('click', '.btn-edit', function() {
        let detailId = $(this).data('id');
        $.ajax({
            url: "/detail/edit/" + detailId, // URL untuk mendapatkan detail penjualan berdasarkan id
            type: "GET",
            success: function(response) {
                if (response.status) {
                    // Isi form dengan data yang diterima dari server
                    $('#penjualan_id').val(response.detail.penjualan_id);
                    $('#barang_id').val(response.detail.barang_id);
                    $('#harga').val(response.detail.harga);
                    $('#jumlah').val(response.detail.jumlah);
                    $('#form-tambah').attr('action', '/detail/update/' + detailId); // Ubah action form untuk edit
                    $('#myModal').modal('show'); // Tampilkan modal edit
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal mendapatkan data detail'
                });
            }
        });
    });

    // Validasi form
    $("#form-tambah").validate({
        rules: {
            penjualan_id: {
                required: true,
                number: true
            },
            barang_id: {
                required: true,
                number: true
            },
            harga: {
                required: true,
                number: true,
                minlength: 3
            },
            jumlah: {
                required: true,
                number: true,
                minlength: 1
            }
        },
        submitHandler: function(form) {
            let actionUrl = form.action; // Action URL yang bisa untuk create atau update
            $.ajax({
                url: actionUrl,
                type: form.method,
                data: $(form).serialize(),
                success: function(response) {
                    if (response.status) {
                        $('#myModal').modal('hide'); // Sembunyikan modal setelah sukses
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });
                        tableDetail.ajax.reload(); // Reload tabel untuk melihat hasil edit
                    } else {
                        $('.error-text').text('');
                        $.each(response.msgField, function(prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi Kesalahan',
                            text: response.message
                        });
                    }
                }
            });
            return false;
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
});
</script>

