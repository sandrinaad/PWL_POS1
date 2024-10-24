<div class="sidebar">
  <!-- SidebarSearch Form -->
  <div class="form-inline mt-2">
      <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
              <button class="btn btn-sidebar">
                  <i class="fas fa-search fa-fw"></i>
              </button>
          </div>
      </div>
  </div>

  <!-- Sidebar Menu -->
  <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
              <a href="{{ url('/') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>Dashboard</p>
              </a>
          </li>
          <li class="nav-header">Data Pengguna</li>
          {{-- <li class="nav-item">
              <a href="{{ url('/profile') }}" class="nav-link {{ $activeMenu == 'profile' ? 'active' : '' }}">
                  <i class="nav-icon fas fa-user-circle"></i>
                  <p>Profile</p>
              </a>
          </li> --}}
          <li class="nav-item">
            <a href="{{ url('/profil') }}" class="nav-link {{ ($activeMenu == 'profil')? 'active' : ''}}">
                <i class="nav-icon far fa-address-card"></i>
                <p>Profile</p>
            </a>
        </li>
          <li class="nav-item">
              <a href="{{ url('/level') }}" class="nav-link {{ $activeMenu == 'level' ? 'active' : '' }}">
                  <i class="nav-icon fas fa-layer-group"></i>
                  <p>Level User</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ url('/user') }}" class="nav-link {{ $activeMenu == 'user' ? 'active' : '' }}">
                  <i class="nav-icon far fa-user"></i>
                  <p>Data User</p>
              </a>
          </li>

          <li class="nav-header">Data Barang</li>
          <li class="nav-item">
              <a href="{{ url('/kategori') }}" class="nav-link {{ $activeMenu == 'kategori' ? 'active' : '' }}">
                  <i class="nav-icon far fa-bookmark"></i>
                  <p>Kategori Barang</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ url('/barang') }}" class="nav-link {{ $activeMenu == 'barang' ? 'active' : '' }}">
                  <i class="nav-icon far fa-list-alt"></i>
                  <p>Data Barang</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ url('/supplier') }}" class="nav-link {{ $activeMenu == 'stok' ? 'active' : '' }}">
                  <i class="nav-icon fas fa-cubes"></i>
                  <p>Supplier</p>
              </a>
          </li>
          <li class="nav-item">
              <a href="{{ url('/stok') }}" class="nav-link {{ $activeMenu == 'stokBarang' ? 'active' : '' }}">
                  <i class="nav-icon fas fa-box"></i>
                  <p>Stok Barang</p>
              </a>
          </li>
          <li class="nav-header">Transaksi Penjualan</li>
          <li class="nav-item">
              <a href="{{ url('/penjualan') }}" class="nav-link {{ $activeMenu == 'penjualan' ? 'active' : '' }}">
                  <i class="nav-icon fas fa-cash-register"></i>
                  <p>Transaksi Penjualan</p>
              </a>
          </li>
      </ul>
  </nav>
</div>

<!-- Menambahkan Menu Logout -->
<!-- Menambahkan Menu Logout dengan SweetAlert2 -->
<li class="nav-item">
    <a href="{{ url('logout') }}" class="nav-link" onclick="confirmLogout(event)">
      <i class="nav-icon fas fa-sign-out-alt"></i>
      <p>Logout</p>
    </a>
    <form id="logout-form" action="{{ url('logout') }}" method="GET" style="display: none;">
    </form>
  </li>
  
  <script>
    function confirmLogout(event) {
      event.preventDefault(); // Menghentikan aksi default logout
  
      Swal.fire({
        title: 'Anda yakin ingin logout?',
        text: "Anda akan keluar dari sesi ini.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Logout!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          // Jika pengguna mengklik "Ya, Logout", submit form logout
          document.getElementById('logout-form').submit();
        }
      })
    }
  </script>
  