@extends('layouts.app')
@section('title')
Pengajuan Lembur - {{ $site_name }}
@endsection
@section('content')

<!-- Begin Page Content -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header">
                  <h5 class="m-0 pt-1 font-weight-bold float-left">Pengajuan Lembur</h5>
                  <a href="{{ route('overtime.list') }}" class="btn btn-primary btn-sm float-right" title="Histori Pengajuan"><i class="fas fa-history"></i></a>
                </div>
                <div class="card-body">
                    @if ($overtime != null)
                      @if ($overtime->status == 'Tertunda')
                        <div class="alert alert-warning show" role="alert">
                          Status Pengajuan Lembur Tanggal {{ date('d M Y', strtotime($overtime->dates)) }} Anda : <strong>{{ $overtime->status }}</strong> Silakan Hubungi Admin!
                        </div>
                        @elseif($overtime->status == 'Ditolak')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          Status Pengajuan Lembur Tanggal {{ date('d M Y', strtotime($overtime->dates)) }} Anda : <strong>{{ $overtime->status }}</strong> dengan catatan : <strong>{{ $overtime->note }}</strong>
                        </div>
                        @else
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                          Status Pengajuan Lembur Tanggal {{ date('d M Y', strtotime($overtime->dates)) }} Anda : <strong>{{ $overtime->status }}</strong>
                        </div>
                      @endif
                    @endif
                    <form action=" {{ route('overtime.store') }} " method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                          <label for="dates">Lembur Untuk Tanggal</label>
                          <input type="date" class="form-control  @error('dates') is-invalid @enderror" id="dates" name="dates" value="{{old('dates')}}">
                          @error('dates')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                          <label for="start">Jam Mulai</label>
                          <input type="time" class="form-control  @error('start') is-invalid @enderror" id="start" name="start" value="{{old('start')}}">
                          @error('start')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                          <label for="end">Jam Berakhir</label>
                          <input type="time" class="form-control  @error('end') is-invalid @enderror" id="end" name="end" value="{{old('end')}}">
                          @error('end')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Keterangan Lembur</label>
                            <textarea name="description" id="description" cols="30" rows="10" class="form-control @error('description') is-invalid @enderror">{{old('description')}}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
