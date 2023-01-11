@extends('layouts.app')
@section('title')
Pengajuan Cuti - {{ $site_name }}
@endsection
@section('content')

<!-- Begin Page Content -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header">
                  <h5 class="m-0 pt-1 font-weight-bold float-left">Pengajuan Cuti</h5>
                  <a href="{{ route('submission.list') }}" class="btn btn-primary btn-sm float-right" title="Histori Pengajuan"><i class="fas fa-history"></i></a>
                </div>
                <div class="card-body">
                    @if ($submission != null)
                      @if ($submission->status == 'Tertunda')
                        <div class="alert alert-warning show" role="alert">
                          Status Pengajuan Cuti Tanggal {{ date('d M Y', strtotime($submission->dates_start)) }} Anda : <strong>{{ $submission->status }}</strong> Silakan Hubungi Admin!
                        </div>
                        @elseif($submission->status == 'Ditolak')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          Status Pengajuan Cuti Tanggal {{ date('d M Y', strtotime($submission->dates_start)) }} Anda : <strong>{{ $submission->status }}</strong> dengan catatan : <strong>{{ $submission->note }}</strong>
                        </div>
                        @else
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                          Status Pengajuan Cuti Tanggal {{ date('d M Y', strtotime($submission->dates_start)) }} Anda : <strong>{{ $submission->status }}</strong>
                        </div>
                      @endif
                    @endif
                    <form action=" {{ route('submission.store') }} " method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="reason">Alasan Cuti</label>
                            <textarea name="reason" id="reason" cols="30" rows="10" class="form-control @error('reason') is-invalid @enderror"></textarea>
                            @error('reason')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                          <label for="dates_start">Cuti Untuk Tanggal</label>
                          <input type="date" class="form-control  @error('dates_start') is-invalid @enderror" id="dates_start" name="dates_start">
                          @error('dates_start')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                          <label for="dates_end">Sampai Tanggal</label>
                          <input type="date" class="form-control  @error('dates_end') is-invalid @enderror" id="dates_end" name="dates_end">
                          @error('dates_end')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                          <label for="file">Upload Surat / Bukti Pendukung </label>
                          <input type="file" class="form-control-file  @error('file') is-invalid @enderror" id="file" name="file">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- /.container-fluid -->

@endsection
