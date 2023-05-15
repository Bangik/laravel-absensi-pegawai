<!--

=========================================================
* Argon Dashboard - v1.1.2
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright 2020 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        @yield('title')
    </title>
    <!-- Favicon -->
    <link href="{{ asset('argon/assets/img/brand/favicon.png')}}" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ asset('argon/assets/js/plugins/nucleo/css/nucleo.css')}}" rel="stylesheet" />
    <link href="{{ asset('argon/assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="{{ asset('argon/assets/css/argon-dashboard.css?v=1.1.2')}}" rel="stylesheet" />
    @yield('styles')

</head>

<body class="">
    <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
        <div class="container-fluid">
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
                aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Brand -->
            <a class="navbar-brand pt-0" href="{{ route('home') }}">
                <h1>PRISTA JAYA</h1>
            </a>
            <!-- User -->
            <ul class="nav align-items-center d-md-none">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="media align-items-center">
                            <span class="avatar avatar-sm rounded-circle">
                                <img alt="Image placeholder" src="{{ asset(Storage::url(Auth::user()->avatar)) }}"
                                    alt="{{ Auth::user()->foto }}">
                            </span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="dropdown-item">
                            <i class="ni ni-user-run"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </li>
            </ul>
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Collapse header -->
                <div class="navbar-collapse-header d-md-none">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="{{ route('home') }}">
                                <h1>{{ $site_name }}</h1>
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                                aria-label="Toggle sidenav">
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Navigation -->
                <ul class="navbar-nav">
                    @role('admin')
                        @if (Request::segment(1) == 'kehadiran')
                            <li class="nav-item active">
                            <a class="nav-link active" href="{{ route('kehadiran.index') }}">
                        @else
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('kehadiran.index') }}">
                        @endif
                                <i class="ni ni-check-bold text-primary"></i> Kehadiran
                            </a>
                        </li>

                        @if (Request::segment(1) == 'users')
                            <li class="nav-item active">
                            <a class="nav-link active" href="{{ route('users.index') }}">
                        @else
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('users.index') }}">
                        @endif
                                <i class="ni ni-circle-08 text-primary"></i> Users
                            </a>
                        </li>

                        @if (Request::segment(1) == 'aktivitas-kerja-pegawai')
                            <li class="nav-item active">
                            <a class="nav-link active" href="{{ route('aktivitas-kerja.list') }}">
                        @else
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('aktivitas-kerja.list') }}">
                        @endif
                                <i class="ni ni-calendar-grid-58 text-primary"></i> Aktivitas Kerja Pegawai
                            </a>
                        </li>

                        @if (Request::segment(1) == 'pengajuan')
                            <li class="nav-item active">
                            <a class="nav-link active" href="{{ route('submission.index') }}">
                        @else
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('submission.index') }}">
                        @endif
                                <i class="fas fa-envelope text-teal"></i> Pengajuan Cuti
                            </a>
                        </li>

                        @if (Request::segment(1) == 'lembur')
                            <li class="nav-item active">
                            <a class="nav-link active" href="{{ route('overtime.index') }}">
                        @else
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('overtime.index') }}">
                        @endif
                                <i class="fas fa-clock"></i> Pengajuan Lembur
                            </a>
                        </li>

                        @if (Request::segment(1) == 'setting')
                            <li class="nav-item active">
                            <a class="nav-link active" href="{{ route('setting.index') }}">
                        @else
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('setting.index') }}">
                        @endif
                                <i class="ni ni-settings text-primary"></i> Setting
                            </a>
                        </li>
                    @else
                        @if (Request::segment(1) == 'daftar-hadir')
                            <li class="nav-item active">
                            <a class="nav-link active" href="{{ route('daftar-hadir') }}">
                        @else
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('daftar-hadir') }}">
                        @endif
                                <i class="ni ni-check-bold text-primary"></i> Kehadiran
                            </a>
                        </li>

                        @if (Request::segment(1) == 'aktivitas-kerja')
                            <li class="nav-item active">
                            <a class="nav-link active" href="{{ route('aktivitas-kerja.index') }}">
                        @else
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('aktivitas-kerja.index') }}">
                        @endif
                                <i class="ni ni-calendar-grid-58 text-primary"></i> Aktivitas Kerja
                            </a>
                        </li>

                        @if (Request::segment(1) == 'pengajuan')
                            <li class="nav-item active">
                            <a class="nav-link active" href="{{ route('submission.create') }}">
                        @else
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('submission.create') }}">
                        @endif
                                <i class="fas fa-envelope text-teal"></i> Pengajuan Cuti
                            </a>
                        </li>

                        @if (Request::segment(1) == 'lembur')
                            <li class="nav-item active">
                            <a class="nav-link active" href="{{ route('overtime.create') }}">
                        @else
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('overtime.create') }}">
                        @endif
                                <i class="fas fa-clock"></i> Pengajuan Lembur
                            </a>
                        </li>
                    @endrole

                    @if (Request::segment(1) == 'profil')
                        <li class="nav-item active">
                        <a class="nav-link active" href="{{ route('profil') }}">
                    @else
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('profil') }}">
                    @endif
                            <i class="ni ni-single-02 text-yellow"></i> Profil
                        </a>
                    </li>

                    @if (Request::segment(1) == 'ganti-password')
                        <li class="nav-item active">
                        <a class="nav-link active" href="{{ route('ganti-password') }}">
                    @else
                        <li class="nav-item">
                        <a class="nav-link" href="{{ route('ganti-password') }}">
                    @endif
                            <i class="ni ni-key-25 text-green"></i> Ganti Password
                        </a>
                    </li>
                </ul>
                <hr class="my-3">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ni ni-user-run text-info"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
            <div class="container-fluid">
                <!-- Brand -->
                <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block"
                    href="{{ route('home') }}">Home</a>
                <!-- User -->
                <ul class="navbar-nav align-items-center d-none d-md-flex">
                    <li class="nav-item dropdown">
                        <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <div class="media align-items-center">
                                <span class="avatar avatar-sm rounded-circle">
                                    <img alt="Image placeholder" src="{{ Storage::url(Auth::user()->avatar ) }}"
                                        alt="{{ Auth::user()->foto }}">
                                </span>
                                <div class="media-body ml-2 d-none d-lg-block">
                                    <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->nama }}</span>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="dropdown-item">
                                <i class="ni ni-user-run"></i>
                                <span>Logout</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- End Navbar -->

        <!-- Header -->
        <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
            <div class="container-fluid">
                <div class="header-body">
                    <!-- Card stats -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if ($errors->any())<div class="alert alert-danger alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                    @yield('header')
                </div>
            </div>
        </div>
        <div class="container-fluid mt--7">
            @yield('content')
            <!-- Footer -->
            <footer class="footer">
                <div class="row align-items-center justify-content-xl-between">
                    <div class="col-xl-6">
                    <marquee behavior="scroll" direction="left">
                        <div class="copyright text-center text-xl-left text-muted">
                            © {{ date('Y')}} Developed By <a href="#" class="font-weight-bold ml-1"
                                target="_lank">Pasien Isoman</a> Theme By <a href="https://www.creative-tim.com"
                                class="font-weight-bold ml-1" target="_blank">Creative Tim</a>
                        </div>
                    </marquee>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!--   Core   -->
    <script src="{{ asset('argon/assets/js/plugins/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{ asset('argon/assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>

    <!--   Optional JS   -->
    @stack('scripts')

    <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
    <script>
        window.TrackJS &&
            TrackJS.install({
                token: "ee6fab19c5a04ac1a32a645abde4613a",
                application: "argon-dashboard-free"
            });
    </script>

</body>

</html>
