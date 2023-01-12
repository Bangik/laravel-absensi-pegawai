@extends('layouts.app')

@section('title')
Manajemen Pengajuan Lembur - {{ $site_name }}
@endsection

@section('header')
    <div class="row">
        <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-uppercase text-muted mb-0">Pengajuan lembur baru Hari ini</h5>
                            <span class="h2 font-weight-bold mb-0">{{ $overtimeToday }}</span>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                <i class="fas fa-calendar"></i>
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
                <h5 class="m-0 pt-1 font-weight-bold float-left">Manajemen Pengajuan Lembur</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <form action="{{ route('overtime.search') }}" method="get">
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
                                            <a href="{{ route('overtime.show', $overtime) }}" class="btn btn-sm btn-info" title="Detail User"><i class="fas fa-eye"></i></a>
                                            <form action="{{ route('overtime.destroy', $overtime) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus User" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fas fa-trash"></i></button>
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
