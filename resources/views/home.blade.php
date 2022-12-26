@extends('layouts.home')
@section('title')
    Home - {{ config('app.name') }}
@endsection
@section('content')
    @if ($libur)
        <div class="text-center">
            <p>Absen Libur (Hari Libur Nasional {{ $holiday }})</p>
        </div>
    @else
        @if (date('l') == "Saturday" || date('l') == "Sunday")
            <div class="text-center">
                <p>Absen Libur</p>
            </div>
        @else
            @if ($present)
                @if ($present->status == 'Alpha')
                    <div class="text-center">
                        @if (strtotime(date('H:i:s')) >= strtotime(config('absensi.jam_masuk') .' -1 hours') && strtotime(date('H:i:s')) <= strtotime(config('absensi.jam_pulang')))
                            <p>Silahkan Absen Datang</p>
                            <form action="{{ route('kehadiran.check-in') }}" method="post">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="distance" id="distance">
                                <button class="btn btn-primary btn-present" type="submit">Absen Datang</button>
                            </form>
                        @else
                            <p>Absen Datang Belum Tersedia</p>
                        @endif
                    </div>
                @elseif($present->status == 'Cuti')
                    <div class="text-center">
                        <p>Anda Sedang Cuti</p>
                    </div>
                @else
                    <div class="text-center">
                        <p>
                            Absen Datang hari ini pukul : ({{ ($present->time_in) }})
                        </p>
                        @if ($present->time_out)
                            <p>Absen Pulang hari ini pukul : ({{ $present->time_out }})</p>
                        @else
                            @if (strtotime('now') >= strtotime(config('absensi.jam_pulang')))
                                <p>Jika pekerjaan telah selesai silahkan Absen Pulang</p>
                                <form action="{{ route('kehadiran.check-out', ['kehadiran' => $present]) }}" method="post">
                                    @csrf @method('patch')
                                    <input type="hidden" name="distance" id="distance">
                                    <button class="btn btn-primary btn-present" type="submit">Absen Pulang</button>
                                </form>
                            @else
                                <p>Absen Pulang Belum Tersedia</p>
                            @endif
                        @endif
                    </div>
                @endif
            @else
                <div class="text-center">
                    @if (strtotime(date('H:i:s')) >= strtotime(config('absensi.jam_masuk') . ' -1 hours') && strtotime(date('H:i:s')) <= strtotime(config('absensi.jam_pulang')))
                        <p>Silahkan Absen Datang</p>
                        <form action="{{ route('kehadiran.check-in') }}" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="distance" id="distance">
                            <button class="btn btn-primary btn-present" type="submit">Absen Datang</button>
                        </form>
                    @else
                        <p>Absen Datang Belum Tersedia</p>
                    @endif
                </div>
            @endif
        @endif
    @endif
@endsection
