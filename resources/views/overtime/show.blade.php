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
                  <div class="float-right">
                    <button type="button" href="#" class="btn btn-sm btn-success" title="Ubah" data-toggle="modal" data-target="#ubahStatus">Ubah status</button>
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
          <form class="formUbahKehadiran" action="{{route('overtime.update', ['overtime' => $overtime->id])}}" method="post">
              @csrf @method('patch')
              <div class="modal-body">
                  <div class="form-group row">
                      <label for="status" class="col-form-label col-sm-3">Status</label>
                      <div class="col-sm-9">
                          <select class="form-control @error('status') is-invalid @enderror" name="status" id="status">
                              <option value="Tertunda" {{ old('status') == 'Tertunda' ? 'selected':'' }}>Tertunda</option>
                              <option value="Disetujui" {{ old('status') == 'Disetujui' ? 'selected':'' }}>Disetujui</option>
                              <option value="Ditolak" {{ old('status') == 'Ditolak' ? 'selected':'' }}>Ditolak</option>
                          </select>
                          @error('status') <span class="invalid-feedback" role="alert">{{ $message }}</span> @enderror
                      </div>
                  </div>
                  <div class="form-group row" id="jamMasuk">
                      <label for="note" class="col-form-label col-sm-3">Catatan / Pesan</label>
                      <div class="col-sm-9">
                          <textarea name="note" id="note" class="form-control @error('note') is-invalid @enderror">{{$overtime->note}}</textarea>
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