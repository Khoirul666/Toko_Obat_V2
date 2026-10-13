<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="{{route('home')}}"><img src="{{asset('mazer-1.0.0/dist')}}/assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item {{request()->is('/') ? 'active' : '' }}">
                    <a href="{{route('home')}}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item {{request()->is('penjualan*') || request()->is('pembelian*') ? 'active' : '' }} has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-file-earmark-medical-fill"></i>
                        <span>Transaksi</span>
                    </a>
                    <ul class="submenu {{request()->is('penjualan*') || request()->is('pembelian*') ? 'active' : ''}}">
                        <li class="submenu-item">
                            <a href="{{route('penjualan.index')}}">Penjualan</a>
                        </li>
                        <li class="submenu-item">
                            <a href="{{route('pembelian.index')}}">Pembelian</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item {{request()->is('satuan*') || request()->is('produk*') ? 'active' : ''}} has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-collection-fill"></i>
                        <span>Produk</span>
                    </a>
                    <ul class="submenu {{request()->is('satuan*') || request()->is('kategori*')  || request()->is('produk*') ? 'active' : ''}}">
                        <li class="submenu-item ">
                            <a href="{{route('satuan.index')}}">Satuan</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('kategori.index')}}">Kategori</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('produk.index')}}">Daftar</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item {{request()->is('transaksi*') ? 'active' : ''}} has-sub">
                    <a href="#" class='sidebar-link'>
                        <i class="bi bi-stack"></i>
                        <span>Laporan</span>
                    </a>
                    <ul class="submenu {{request()->is('transaksi*') ? 'active' : ''}} ">
                        <li class="submenu-item ">
                            <a href="{{route('transaksi.penjualan.index')}}">Penjualan</a>
                        </li>
                        <li class="submenu-item ">
                            <a href="{{route('transaksi.pembelian.index')}}">Pembelian</a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>