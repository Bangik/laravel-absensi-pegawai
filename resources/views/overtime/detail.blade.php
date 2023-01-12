@extends('layouts.app')

@section('title')
Detail Pengajuan Lembur - {{ $site_name }}
@endsection

@section('content')

<!-- Begin Page Content -->
    <div class="container">
        <div class="card shadow h-100">
            <div class="card-header">
                <h5 class="m-0 pt-1 font-weight-bold float-left">Detail Pengajuan Lembur</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive table-borderless">
                  <table class="table">
                    <tbody>
                        <tr><td>Tanggal Pengajuan</td><td>: {{ date('d M Y H:s', strtotime($overtime->created_at)) }}</td></tr>
                        <tr><td>Nama</td><td>: {{ $overtime->user->name }}</td></tr>
                        <tr><td>Tanggal Lembur</td><td>: {{ date('d M Y', strtotime($overtime->dates)) }}</td></tr>
                        <tr><td>Jam Mulai</td><td>: {{ date('H:i', strtotime($overtime->start)) }}</td></tr>
                        <tr><td>Jam Berakhir</td><td>: {{ date('H:i', strtotime($overtime->end)) }}</td></tr>
                        <tr><td>Keterangan</td><td>: {{ $overtime->description }}</td></tr>
                        <tr><td>Surat / File Pendukung</td><td>: 
                          @if ($overtime->file)
                            <a href="{{ asset('storage/'.$overtime->file) }}" target="_blank" class="btn btn-sm btn-primary">Download</a>
                          @endif
                        </td></tr>
                        <tr><td>Status</td><td>: {{ $overtime->status }}</td></tr>
                        <tr><td>Catatan</td><td>: {{ $overtime->note }}</td></tr>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
<!-- /.container-fluid -->
@endsection
