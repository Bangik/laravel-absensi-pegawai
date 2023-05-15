@extends('layouts.app')
@section('title')
Buat Akitivitas Kerja - {{ $site_name }}
@endsection
@section('content')

<!-- Begin Page Content -->
    <div class="container">
      <div class="card shadow h-100">
          <div class="card-header">
            <h5 class="m-0 pt-1 font-weight-bold float-left">Buat Akitivitas Kerja</h5>
          </div>
          <div class="card-body">
              <form action=" {{ route('aktivitas-kerja.store') }} " method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="work_location">Pilihan Lokasi Kerja</label>
                    <select name="work_location" id="work_location" class="form-control @error('work_location') is-invalid @enderror">
                    <option value="Luar Ruangan">Kerja di Luar</option>
                    <option value="Dalam Ruangan">Kerja di Dalam</option>
                </select>
                    @error('work_location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                  <div class="form-group">
                      <label for="activity">Aktivitas</label>
                      <textarea name="activity" id="activity" cols="30" rows="10" class="form-control @error('activity') is-invalid @enderror">{{old('activity')}}</textarea>
                      @error('activity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="form-group">
                    <label for="target">Target</label>
                    <textarea class="form-control  @error('target') is-invalid @enderror" cols="30" rows="10" id="target" name="target">{{old('target')}}</textarea>
                    @error('target')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="form-group">
                    <label for="report">Laporan</label>
                    <textarea class="form-control  @error('report') is-invalid @enderror" cols="30" rows="10" id="report" name="report">{{old('report')}}</textarea>
                    @error('report')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="form-group">
                    <label for="dates">Tanggal Aktivitas</label>
                    <input type="date" class="form-control  @error('dates') is-invalid @enderror" id="dates" name="dates" value="{{old('dates')}}">
                    @error('dates')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="form-group">
                    <label for="due_date">Tanggal Batas Akhir</label>
                    <input type="date" class="form-control  @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{old('due_date')}}">
                    @error('due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="form-group">
                    <label for="start">Jam Mulai</label>
                    <input type="time" class="form-control  @error('start') is-invalid @enderror" id="start" name="start" value="{{old('start')}}">
                    @error('start')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="form-group">
                    <label for="end">Jam Selesai</label>
                    <input type="time" class="form-control  @error('end') is-invalid @enderror" id="end" name="end" value="{{old('end')}}">
                    @error('end')<div class="invalid-feedback">{{ $message }}</div>@enderror
                  </div>
                  <div class="form-group">
                    <label for="file">Upload File</label>
                    <input type="file" class="form-control-file  @error('file') is-invalid @enderror" id="file" name="file">
                  </div>
                  <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                  </div>
              </form>
          </div>
      </div>
    </div>
<!-- /.container-fluid -->

@endsection
