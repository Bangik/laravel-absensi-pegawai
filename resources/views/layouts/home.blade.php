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

    <!-- leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
</head>

<body class="bg-default">
    <!-- Navbar -->
    @auth
    <nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
        <div class="container px-4">
            <a class="navbar-brand" href="{{ route('home') }}">
                <h1 class="text-white">{{ $site_name }}</h1>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-main"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar-collapse-main">
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
                                data-target="#navbar-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                                aria-label="Toggle sidenav">
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Navbar items -->
                <ul class="navbar-nav ml-auto">
                    @role('admin')
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link nav-link-icon">
                                <i class="ni ni-circle-08"></i>
                                <span class="nav-link-inner--text">Users</span>
                            </a>
                        </li>
                    @endrole
                    <li class="nav-item">
                        @role('admin')
                            <a class="nav-link nav-link-icon" href="{{ route('kehadiran.index') }}">
                        @else
                            <a class="nav-link nav-link-icon" href="{{ route('daftar-hadir') }}">
                        @endrole
                            <i class="ni ni-check-bold"></i>
                            <span class="nav-link-inner--text">Kehadiran</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="{{ route('profil') }}">
                            <i class="ni ni-single-02"></i>
                            <span class="nav-link-inner--text">Profile</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link nav-link-icon" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ni ni-user-run"></i>
                            <span class="nav-link-inner--text">Logout</span>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endauth

    <div class="main-content">
        <!-- Header -->
        <div class="header bg-gradient-info py-7 py-lg-8">
            <div class="container">
                <div class="header-body text-center mb-7">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-6">
                            <h1 class="text-white">Selamat Datang!</h1>
                            <p class="text-lead text-light">Sistem Informasi Prista Jaya</p>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div id="map" style="width: 100%; height: 500px;"></div>
                    </div>
                </div>
                <br>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                    xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <!-- Page content -->
        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary shadow border-0">
                        <div class="card-body px-lg-5 py-lg-5">
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
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="text-align: center;">
            <p style="font-size: 26px; font-weight: bold;" class="motivation ">"Believe you can and you're halfway there." -Theodore Roosevelt</p>
            </div>
        <footer class="py-5">
            <div class="container">
                <div class="copyright text-center">
                    © {{ date('Y')}} Developed By <a href="#" class="font-weight-bold ml-1"
                                target="_lank">Pasien Isoman</a> Theme By <a href="https://www.creative-tim.com"
                                class="font-weight-bold ml-1" target="_blank">Creative Tim</a>
                </div>
            </div>
        </footer>
    </div>
    <!--   Core   -->
    <script src="{{ asset('argon/assets/js/plugins/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{ asset('argon/assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <!--   Optional JS   -->
    @stack('scripts')

    <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
    <script>
        $(document).ready(function(){
                window.TrackJS && TrackJS.install({
                token: "ee6fab19c5a04ac1a32a645abde4613a",
                application: "argon-dashboard-free"
            });
            
            const radius = {{ $radius }};
            const lat = {{ $lat }};
            const lng = {{ $long }};
            let distance = 0;

            const peta1 = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                id: 'mapbox/streets-v11'
            });

            let map = L.map('map', {
                center: [lat, lng],
                zoom: 12,
                layers: [peta1]
            });

            // get current location
            map.locate({
                setView: true,
                maxZoom: 16
            });

            function onLocationFound(e) {
                distance = map.distance(e.latlng, [lat, lng]);

                L.circle([lat, lng], radius).addTo(map);
                L.marker([lat, lng]).addTo(map)
                    .bindPopup("Point").openPopup();
                L.marker(e.latlng).addTo(map)
                    .bindPopup("You are within " + distance + " meters from this point").openPopup();
            }

            
            
            function onLocationError(e) {
                alert(e.message);
            }
            
            map.on('locationfound', onLocationFound);
            map.on('locationerror', onLocationError);
            
            $('.btn-present').click(function(){
                $('#distance').val(distance);

                if (distance > radius) {
                    alert('Anda Berada Diluar Jangkauan, Silahkan Cek Lokasi Anda dan Refresh Halaman');
                    return false;
                }
            });
        });
    </script>
    <script src="{{ asset('js/myscript.js') }}"></script>

</body>

</html>
