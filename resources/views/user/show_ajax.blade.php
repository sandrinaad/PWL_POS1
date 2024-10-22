@if (empty($user))
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data yang anda cari tidak ditemukan
            </div>
            <a href="{{ url('/user') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Data User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                <h5><i class="icon fas fa-info"></i> Detail Informasi</h5>
            </div>
            <table class="table table-sm table-bordered table-striped">
                <tr>
                    <th class="text-right col-3">User ID :</th>
                    <td class="col-9">{{ $user->user_id }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Level Pengguna :</th>
                    <td class="col-9">{{ $user->level->level_nama }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Username :</th>
                    <td class="col-9">{{ $user->username }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Nama :</th>
                    <td class="col-9">{{ $user->nama }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Password :</th>
                    <td class="col-9">*******</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endif

<script>
$(document).ready(function() {
    // Tampilkan modal jika berhasil
    $('#userDetailModal').modal('show'); // pastikan ID modal cocok
});
</script>