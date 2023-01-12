@extends('layouts.app')

@section('title')
Detail Aktivitas Kerja - {{ $site_name }}
@endsection

@section('content')

<!-- Begin Page Content -->
    <div class="container">
        <div class="card shadow h-100">
            <div class="card-header">
                <h5 class="m-0 pt-1 font-weight-bold float-left">Detail Aktivitas Kerja</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive table-borderless">
                  <table class="table">
                    <tbody>
                        <tr><td>Tanggal Aktivitas</td><td>: {{ date('d M Y', strtotime($schedule->dates)) }}</td></tr>
                        <tr><td>Batas Waktu</td><td>: {{ date('d M Y', strtotime($schedule->due_date)) }}</td></tr>
                        <tr><td>Waktu Mulai</td><td>: {{ date('H:i', strtotime($schedule->start)) }}</td></tr>
                        <tr><td>Waktu Selesai</td><td>: {{ date('H:i', strtotime($schedule->end)) }}</td></tr>
                        <tr><td>Aktivitas</td><td>: {{ $schedule->activity }}</td></tr>
                        <tr><td>Target</td><td>: {{ $schedule->target }}</td></tr>
                        <tr><td>Laporan</td><td>: {{ $schedule->report }}</td></tr>
                        <tr><td>Status</td><td>: {{$schedule->status}}</td></tr>
                        <tr><td>Persetujuan</td><td>: {{$schedule->approval}}</td></tr>
                        <tr><td>Catatan</td><td>: {{ $schedule->note }}</td></tr>
                        <tr><td>Surat / File Pendukung</td><td>: 
                          @if ($schedule->file)
                            <a href="{{ asset('storage/'.$schedule->file) }}" target="_blank" class="btn btn-sm btn-primary">Download</a>
                          @endif
                        </td></tr>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
<!-- /.container-fluid -->
@endsection
