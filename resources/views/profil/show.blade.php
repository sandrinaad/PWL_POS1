@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Profil Pengguna</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            @empty($user)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <table class="table table-bordered table-striped table-hover table-sm">
                    <tr>
                        <th>ID</th>
                        <td>{{ $user->user_id }}</td>
                    </tr>
                    <tr>
                        <th>Level</th>
                        <td>{{ $user->level->level_nama }}</td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $user->nama }}</td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td>****</td>
                    </tr>
                    <tr>
                        <th>Foto Profil</th>
                        <td>
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Profile Picture" class="img-fluid" style="max-width: 150px; height: auto;">
                            @else
                                <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="No Profile Picture" class="img-fluid" style="max-width: 150px; height: auto;">
                            @endif
                        </td>
                    </tr>
                </table>

                <!-- Upload form -->
                <form action="{{ route('user.update_avatar', $user->user_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="avatar">Upload Foto Profil</label>
                        <input type="file" name="avatar" class="form-control" id="avatar">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            @endempty
            <a href="{{ url('user') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
@endpush