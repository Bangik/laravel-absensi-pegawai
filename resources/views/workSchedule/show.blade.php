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
                        <tr><td>Nama Pegawai</td><td>: {{ $schedule->user->name }}</td></tr>
                        <tr><td>Tanggal Aktivitas</td><td>: {{ date('d M Y', strtotime($schedule->dates)) }}</td></tr>
                        <tr><td>Batas Waktu</td><td>: {{ date('d M Y', strtotime($schedule->due_date)) }}</td></tr>
                        <tr><td>Waktu Mulai</td><td>: {{ date('H:i', strtotime($schedule->start)) }}</td></tr>
                        <tr><td>Waktu Selesai</td><td>: {{ date('H:i', strtotime($schedule->end)) }}</td></tr>
                        <tr><td>Lokasi Kerja</td><td>: {{ $schedule->work_location }}</td></tr>
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
                  <div class="float-right">
                    <button type="button" href="#" class="btn btn-sm btn-success" title="Ubah" data-toggle="modal" data-target="#ubahStatus">Ubah Persetujuan</button>
                  </div>
                </div>
            </div>
        </div>
    </div>
<!-- /.container-fluid -->

<!-- Modal -->
<div class="modal fade" id="ubahStatus" tabindex="-1" role="dialog" aria-labelledby="ubahStatusLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="ubahStatusLabel">Ubah Status</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <form class="formUbahKehadiran" action="{{route('aktivitas-kerja.approval', $schedule->id)}}" method="post">
              @csrf @method('patch')
              <div class="modal-body">
                  <div class="form-group row">
                      <label for="approval" class="col-form-label col-sm-3">Status</label>
                      <div class="col-sm-9">
                          <select class="form-control @error('approval') is-invalid @enderror" name="approval" id="approval">
                              <option value="Tertunda" {{ old('approval') == 'Tertunda' ? 'selected':'' }}>Tertunda</option>
                              <option value="Disetujui" {{ old('approval') == 'Disetujui' ? 'selected':'' }}>Disetujui</option>
                              <option value="Ditolak" {{ old('approval') == 'Ditolak' ? 'selected':'' }}>Ditolak</option>
                          </select>
                          @error('approval') <span class="invalid-feedback" role="alert">{{ $message }}</span> @enderror
                      </div>
                  </div>
                  <div class="form-group row" id="jamMasuk">
                      <label for="note" class="col-form-label col-sm-3">Catatan / Pesan</label>
                      <div class="col-sm-9">
                          <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror">{{$schedule->note}}</textarea>
                          @error('note') <span class="invalid-feedback" role="alert">{{ $message }}</span> @enderror
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-success">Simpan</button>
              </div>
          </form>
      </div>
  </div>
</div>
@endsection
