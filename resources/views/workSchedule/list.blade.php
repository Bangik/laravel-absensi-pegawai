@extends('layouts.app')

@section('title')
Aktivitas Kerja Pegawai - {{ $site_name }}
@endsection

@section('header')
    <div class="row">
        <div class="col-xl-4 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Persetujuan Pending</h5>
                            <span class="h2 font-weight-bold mb-0">{{$pending }}</span>
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
        <div class="col-xl-4 col-lg-6">
          <div class="card card-stats mb-4 mb-xl-0">
              <div class="card-body">
                  <div class="row">
                      <div class="col">
                          <h5 class="card-title text-uppercase text-muted mb-0">Pekerjaan Disetujui</h5>
                          <span class="h2 font-weight-bold mb-0">{{ $approved }}</span>
                      </div>
                      <div class="col-auto">
                          <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                              <i class="fas fa-check"></i>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
        </div>
        <div class="col-xl-4 col-lg-6">
          <div class="card card-stats mb-4 mb-xl-0">
              <div class="card-body">
                  <div class="row">
                      <div class="col">
                          <h5 class="card-title text-uppercase text-muted mb-0">Pekerjaan Ditolak</h5>
                          <span class="h2 font-weight-bold mb-0">{{ $rejected }}</span>
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
                <h5 class="m-0 pt-1 font-weight-bold float-left">Aktivitas Kerja Pegawai</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form action="{{ route('aktivitas-kerja.searchActivity') }}" method="get">
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
                                <th>Nama Pegawai</th>
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
                                        <td>{{ $schedule->user->name }}</td>
                                        <td>{{ $schedule->activity }}</td>
                                        <td>{{ $schedule->target }}</td>
                                        <td>{{ $schedule->status }}</td>
                                        <td>{{ $schedule->approval }}</td>
                                        <td>
                                            <a href="{{ route('aktivitas-kerja.show', $schedule->id) }}" class="btn btn-sm btn-info" title="Detail"><i class="fas fa-eye"></i></a>
                                            <form action="{{ route('aktivitas-kerja.destroy', $schedule->id) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></button>
                                            </form>
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
