@extends('layouts.template')
@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
        </div>
        <div class="card-body">
            @empty($user)
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
            @else
                <div class="d-flex align-items-start mb-4">
                    <img src="{{ asset($user->avatar ? 'gambar/' . $user->avatar : 'gambar/profil-pic.png') }}" class="img-circle elevation-2 me-4" alt="User Image" width="150" height="150">
                    <div>
                        <h5 class="mt-0">Data Pengguna</h5>
                        <div class="d-flex mb-3">
                            <div class="me-3">
                                <label>ID Pengguna</label>
                                <div class="border rounded p-3" style="min-width: 200px;">{{ $user->user_id }}</div>
                            </div>
                            <div class="me-3">
                                <label>Nama</label>
                                <div class="border rounded p-3" style="min-width: 200px;">{{ $user->nama }}</div>
                            </div>
                            <div>
                                <label>Level</label>
                                <div class="border rounded p-3" style="min-width: 200px;">{{ $user->level->level_nama }}</div>
                            </div>
                        </div>
                        <h5 class="mt-0">Data Akun</h5>
                        <div class="d-flex mb-3">
                            <div class="me-3">
                                <label>Username</label>
                                <div class="border rounded p-3" style="min-width: 200px;">{{ $user->username }}</div>
                            </div>
                            <div>
                                <label>Password</label>
                                <div class="border rounded p-3" style="min-width: 200px;">*******</div>
                            </div>
                        </div>

                        <div class="d-flex mb-3">
                            <div class="me-3">
                                 <button onclick="modalAction('{{ url('/profil/' . $user->user_id . '/edit_ajax') }}')" class="btn btn-info">Edit Profil</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endempty
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Konten modal akan dimuat di sini -->
            </div>
        </div>
    </div>
@endsection
@push('css')
    <style>
        /* Optional custom styles */
        .img-circle img-circle elevation-2 me-4 {
            border: 3px solid #ddd;
            /* Add border to the avatar */
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            /* Add shadow for better visual effect */
            margin-right: 60px;
        }
        .list-group-item {
            display: flex;
            justify-content: space-between;
            /* Align items properly */
        }
        .card {
            margin-left: 20px;
            margin-right: 20px;
            padding: 5px;
            /* Menambahkan padding pada card */
        }
        .me-4 {
            margin-right: 30px;
            margin-bottom: 30px;
        }
        .me-3{
            margin-right: 20px;
            margin-bottom: 20px;
        }
        .mt-4{
            margin-top: 10px;
        }
        h3 {
            margin-bottom: 0.5rem;
            /* Menambahkan jarak bawah pada nama pengguna */
        }
        p {
            margin-bottom: 0.5rem;
            /* Menambahkan jarak bawah pada deskripsi pengguna */
        }
    </style>
    </style>
@endpush
@push('js')
    <script>
        function modalAction(url = '') {
            console.log(url); // Debugging
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
    </script>
@endpush