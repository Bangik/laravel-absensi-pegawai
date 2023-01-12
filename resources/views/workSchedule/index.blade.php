@extends('layouts.app')

@section('title')
Aktivitas Kerja - {{ $site_name }}
@endsection

@section('header')
    <div class="row">
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Pekerjaan Belum Selesai</h5>
                            <span class="h2 font-weight-bold mb-0">{{$unfinish }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-warning text-white rounded-circle shadow">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6">
          <div class="card card-stats mb-4 mb-xl-0">
              <div class="card-body">
                  <div class="row">
                      <div class="col">
                          <h5 class="card-title text-uppercase text-muted mb-0">Pekerjaan Masih Proses</h5>
                          <span class="h2 font-weight-bold mb-0">{{ $process }}</span>
                      </div>
                      <div class="col-auto">
                          <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                              <i class="fas fa-pen"></i>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6">
          <div class="card card-stats mb-4 mb-xl-0">
              <div class="card-body">
                  <div class="row">
                      <div class="col">
                          <h5 class="card-title text-uppercase text-muted mb-0">Pekerjaan Selesai</h5>
                          <span class="h2 font-weight-bold mb-0">{{ $finish }}</span>
                      </div>
                      <div class="col-auto">
                          <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                              <i class="fas fa-check"></i>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
        <div class="col-xl-3 col-lg-6">
          <div class="card card-stats mb-4 mb-xl-0">
              <div class="card-body">
                  <div class="row">
                      <div class="col">
                          <h5 class="card-title text-uppercase text-muted mb-0">Pekerjaan Tidak Selesai</h5>
                          <span class="h2 font-weight-bold mb-0">{{ $notfinish }}</span>
                      </div>
                      <div class="col-auto">
                          <div class="icon icon-shape bg-gradient-danger text-white rounded-circle shadow">
                              <i class="fas fa-times"></i>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
    </div>
@endsection

@section('content')

<!-- Begin Page Content -->
    <div class="container">
        <div class="card shadow h-100">
            <div class="card-header">
                <h5 class="m-0 pt-1 font-weight-bold float-left">Aktivitas Kerja</h5>
                <a href="{{ route('aktivitas-kerja.create') }}" class="btn btn-primary btn-sm float-right" title="Histori Pengajuan"><i class="fas fa-plus"></i></a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form action="{{ route('aktivitas-kerja.search') }}" method="get">
                            <input type="text" name="cari" id="cari" class="form-control mb-3" value="{{ request('cari') }}" placeholder="Cari . . ." autocomplete="off">
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <div class="float-right">
                            {{ $schedules->links() }}
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal</th>
                                <th>Batas Waktu</th>
                                <th>Aktivitas</th>
                                <th>Target</th>
                                <th>Status</th>
                                <th>Persetujuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$schedules->count())
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data yang tersedia</td>
                                </tr>
                            @else
                                @foreach ($schedules as $schedule)
                                    <tr>
                                        <th>{{ $rank++ }}</th>
                                        <td>{{ date('d M Y', strtotime($schedule->dates)) }}</td>
                                        <td>{{ date('d M Y', strtotime($schedule->due_date)) }}</td>
                                        <td>{{ $schedule->activity }}</td>
                                        <td>{{ $schedule->target }}</td>
                                        <td>{{ $schedule->status }}</td>
                                        <td>{{ $schedule->approval }}</td>
                                        <td>
                                            <a href="{{ route('aktivitas-kerja.detail', $schedule->id) }}" class="btn btn-sm btn-info" title="Detail User"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<!-- /.container-fluid -->

@endsection
