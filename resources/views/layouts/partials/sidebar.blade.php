    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="{{ asset('dist/dist/img/Tilkam.png') }}" alt="SMKN 1 TILKAM Logo"
                class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">SMKN 1 TilKam</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('dist/dist/img/user.png') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">Hai, {{ Auth::guard()->user()->name }}</a>
                </div>
            </div>

            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                    <li class="nav-header">MENU</li>
                    @if (auth()->user()->role == 'Bimbingan Konseling')
                        <li class="nav-item">
                            <a href="#"
                                class="nav-link {{ Request::is('absensi') || Request::is('absensi/*') ? 'active' : '' }}">
                                <img src="{{ asset('dist/dist/img/absen.png') }}" alt=""
                                    class="img-fluid iconjur">
                                <p>
                                    Absensi
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('absen_dpib') }}"
                                        class="nav-link {{ Request::is('absensi/dpib') ? 'active' : '' }} ml-2">
                                        <img src="{{ asset('dist/dist/img/DPIB.png') }}" alt=""
                                            class="img-fluid iconjur">
                                        <p>
                                            Absensi DPIB
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('absen_titl') }}"
                                        class="nav-link {{ Request::is('absensi/titl') ? 'active' : '' }} ml-2">
                                        <img src="{{ asset('dist/dist/img/TITL.png') }}" alt=""
                                            class="img-fluid iconjur">
                                        <p>
                                            Absensi TITL
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('absen_tkj') }}"
                                        class="nav-link {{ Request::is('absensi/tjkt') ? 'active' : '' }} ml-2">
                                        <img src="{{ asset('dist/dist/img/TKJ.png') }}" alt=""
                                            class="img-fluid iconjur">
                                        <p>
                                            Absensi TJKT
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('absen_tkr') }}"
                                        class="nav-link {{ Request::is('absensi/tkr') ? 'active' : '' }} ml-2">
                                        <img src="{{ asset('dist/dist/img/TKR.png') }}" alt=""
                                            class="img-fluid iconjur">
                                        <p>
                                            Absensi TKR
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('absen') }}"
                                        class="nav-link {{ Request::is('absensi/all') ? 'active' : '' }} ml-2">
                                        <img src="{{ asset('dist/dist/img/Tilkam.png') }}" alt=""
                                            class="img-fluid iconjur">
                                        <p>
                                            Absensi Semua Siswa
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sakit-dan-izin') }}"
                                class="nav-link {{ Request::is('sakit-dan-izin') ? 'active' : '' }}">
                                <img src="{{ asset('dist/dist/img/izin.png') }}" alt=""
                                    class="img-fluid iconjur">
                                <p>
                                    Sakit dan Izin Siswa
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('bk') }}"
                                class="nav-link {{ Request::is('bk') || Request::is('bk/*') ? 'active' : '' }}">
                                <img src="{{ asset('dist/dist/img/bk.png') }}" alt=""
                                    class="img-fluid iconjur">
                                <p>
                                    Bimbingan Konseling
                                </p>
                                @if ($notif = App\Models\Student::where('alfa', 3)->orWhere('terlambat', 3)->count())
                                    <span class="badge badge-danger sidebar-badge">
                                        {{ $notif }}
                                    </span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('get-devices') }}"
                                class="nav-link {{ Request::is('wa') || Request::is('wa/*') ? 'active' : '' }}">
                                <img src="{{ asset('dist/dist/img/whatsapp.png') }}" alt=""
                                    class="img-fluid iconjur">
                                <p>
                                    Whatsapp Sekolah
                                </p>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('rekap-absen') }}"
                            class="nav-link {{ Request::is('rekap/*') ? 'active' : '' }}">
                            <img src="{{ asset('dist/dist/img/xls.png') }}" alt="" class="img-fluid iconjur">
                            <p>
                                Rekap absensi
                            </p>
                        </a>
                    </li>

                    @if (auth()->user()->role == 'Operator')
                        <li class="nav-item">
                            <a href="{{ route('student') }}"
                                class="nav-link {{ Request::is('siswa') || Request::is('siswa/*') ? 'active' : '' }}">
                                <img src="{{ asset('dist/dist/img/murid.png') }}" alt=""
                                    class="img-fluid iconjur">
                                <p>
                                    Siswa
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('verif-wajah') }}"
                                class="nav-link {{ Request::is('verif-wajah') || Request::is('verif-wajah/*') ? 'active' : '' }}">
                                <img src="{{ asset('dist/dist/img/face-recognition.png') }}" alt=""
                                    class="img-fluid iconjur">
                                <p>
                                    Verifikasi Wajah
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user') }}"
                                class="nav-link {{ Request::is('user') || Request::is('user/*') ? 'active' : '' }}">
                                <img src="{{ asset('dist/dist/img/users.png') }}" alt=""
                                    class="img-fluid iconjur">
                                <p>
                                    User
                                </p>
                            </a>
                        </li>
                    @endif

                    <li class="nav-header">
                        <hr>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link">
                            <img src="{{ asset('dist/dist/img/logout.png') }}" alt=""
                                class="img-fluid iconjur">
                            <p>
                                Log Out
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
