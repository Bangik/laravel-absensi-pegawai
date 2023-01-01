@extends('layouts.app')
@section('title')
Setting - {{ $site_name }}
@endsection
@section('content')

<!-- Begin Page Content -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow h-100">
                <div class="card-header">
                    <h5 class="m-0 pt-1 font-weight-bold">Setting</h5>
                </div>
                <div class="card-body">
                    <form action=" {{ route('setting.update') }} " method="post">
                        @method('patch')
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Website</label>
                            <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name" name="name" value="{{$name}}">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                          <label for="time_in">Jam Masuk</label>
                          <input type="time" class="form-control  @error('time_in') is-invalid @enderror" id="time_in" name="time_in" value="{{$time_in}}">
                          @error('time_in')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                          <label for="time_out">Jam Pulang</label>
                          <input type="time" class="form-control  @error('time_out') is-invalid @enderror" id="time_out" name="time_out" value="{{$time_out}}">
                          @error('time_out')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="time_in_reminder">Jam Pengingat Masuk</label>
                            <input type="time" class="form-control  @error('time_in_reminder') is-invalid @enderror" id="time_in_reminder" name="time_in_reminder" value="{{$time_in_reminder}}">
                            @error('time_in_reminder')<div class="invalid-feedback">{{ $message }}</div>@enderror
                          </div>
                        <div class="form-group">
                            <label for="lat">Koordinat Latitude</label>
                            <input type="text" class="form-control  @error('lat') is-invalid @enderror" id="lat" name="lat" value="{{$lat}}">
                            @error('lat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                          <label for="long">Koordinat Longitude</label>
                          <input type="text" class="form-control  @error('long') is-invalid @enderror" id="long" name="long" value="{{$long}}">
                          @error('long')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                          <label for="radius">Jarak / Radius</label>
                          <input type="number" class="form-control  @error('radius') is-invalid @enderror" id="radius" name="radius" value="{{$radius}}">
                          @error('radius')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
