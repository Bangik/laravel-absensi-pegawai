@extends('layouts.app')

@section('title')
Histori Pengajuan Lembur - {{ $site_name }}
@endsection

@section('content')

<!-- Begin Page Content -->
    <div class="container">
        <div class="card shadow h-100">
            <div class="card-header">
                <h5 class="m-0 pt-1 font-weight-bold float-left">Histori Pengajuan Lembur</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form action="{{ route('overtime.searchHistory') }}" method="get">
                            <input type="text" name="cari" id="cari" class="form-control mb-3" value="{{ request('cari') }}" placeholder="Cari . . ." autocomplete="off">
                        </form>
                    </div>
                    <div class="col-lg-6">
                        <div class="float-right">
                            {{ $overtimes->links() }}
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                              <th>#</th>
                              <th>Nama</th>
                              <th>Tanggal Lembur</th>
                              <th>Keterangan</th>
                              <th>Status</th>
                              <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$overtimes->count())
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data yang tersedia</td>
                                </tr>
                            @else
                                @foreach ($overtimes as $overtime)
                                    <tr>
                                      <th>{{ $rank++ }}</th>
                                      <td>{{ $overtime->user->name }}</td>
                                      <td>{{ date('d M Y H:s', strtotime($overtime->dates)) }}</td>
                                      <td>{{ $overtime->description }}</td>
                                      <td>
                                          @if ($overtime->status == 'Tertunda')
                                              <span class="badge badge-warning">Tertunda</span>
                                          @elseif ($overtime->status == 'Disetujui')
                                              <span class="badge badge-success">Disetujui</span>
                                          @else
                                              <span class="badge badge-danger">Ditolak</span>
                                          @endif
                                      </td>
                                      <td>
                                          <a href="{{ route('overtime.detail', $overtime) }}" class="btn btn-sm btn-info" title="Detail User"><i class="fas fa-eye"></i></a>
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
