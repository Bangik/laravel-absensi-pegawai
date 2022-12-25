<?php

namespace App\Http\Controllers;

use App\Models\Present;
use App\Models\User;
use Illuminate\Http\Request;

class PresentController extends Controller
{
    public function index()
    {
        $presents = Present::whereDates(date('Y-m-d'))->orderBy('time_in','desc')->paginate(6);
        $masuk = Present::whereDates(date('Y-m-d'))->whereStatus('masuk')->count();
        $telat = Present::whereDates(date('Y-m-d'))->whereStatus('telat')->count();
        $cuti = Present::whereDates(date('Y-m-d'))->whereStatus('cuti')->count();
        $alpha = Present::whereDates(date('Y-m-d'))->whereStatus('alpha')->count();
        $rank = $presents->firstItem();
        return view('presents.index', compact('presents','rank','masuk','telat','cuti','alpha'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'tanggal' => ['required']
        ]);
        $presents = Present::whereDates($request->tanggal)->orderBy('time_in','desc')->paginate(6);
        $masuk = Present::whereDates($request->tanggal)->whereStatus('masuk')->count();
        $telat = Present::whereDates($request->tanggal)->whereStatus('telat')->count();
        $cuti = Present::whereDates($request->tanggal)->whereStatus('cuti')->count();
        $alpha = Present::whereDates($request->tanggal)->whereStatus('alpha')->count();
        $rank = $presents->firstItem();
        return view('presents.index', compact('presents','rank','masuk','telat','cuti','alpha'));
    }

    public function cari(Request $request, $user)
    {

        $user = User::findOrFail($user);

        $request->validate([
            'bulan' => ['required']
        ]);

        $data = explode('-',$request->bulan);
        $presents = Present::whereUserId($user->id)->whereMonth('dates',$data[1])->whereYear('dates',$data[0])->orderBy('dates','desc')->paginate(5);
        $masuk = Present::whereUserId($user->id)->whereMonth('dates',$data[1])->whereYear('dates',$data[0])->whereStatus('masuk')->count();
        $telat = Present::whereUserId($user->id)->whereMonth('dates',$data[1])->whereYear('dates',$data[0])->whereStatus('telat')->count();
        $cuti = Present::whereUserId($user->id)->whereMonth('dates',$data[1])->whereYear('dates',$data[0])->whereStatus('cuti')->count();
        $alpha = Present::whereUserId($user->id)->whereMonth('dates',$data[1])->whereYear('dates',$data[0])->whereStatus('alpha')->count();
        $kehadiran = Present::whereUserId($user->id)->whereMonth('dates',$data[1])->whereYear('dates',$data[0])->whereStatus('telat')->get();
        $totalJamTelat = 0;
        foreach ($kehadiran as $present) {
            $totalJamTelat = $totalJamTelat + (\Carbon\Carbon::parse($present->jam_masuk)->diffInHours(\Carbon\Carbon::parse(config('absensi.jam_masuk') .' -1 hours')));
        }
        $url = 'https://kalenderindonesia.com/api/YZ35u6a7sFWN/libur/masehi/'.date('Y/m');
        $kalender = file_get_contents($url);
        $kalender = json_decode($kalender, true);
        $libur = false;
        $holiday = null;
        if ($kalender['data'] != false) {
            if ($kalender['data']['holiday']['data']) {
                foreach ($kalender['data']['holiday']['data'] as $key => $value) {
                    if ($value['date'] == date('Y-m-d')) {
                        $holiday = $value['name'];
                        $libur = true;
                        break;
                    }
                }
            }
        }
        return view('users.show', compact('presents','user','masuk','telat','cuti','alpha','libur','totalJamTelat'));
    }

    public function store(Request $request)
    {
        $present = Present::whereUserId($request->user_id)->whereDates(date('Y-m-d'))->first();
        if ($present) {
            return redirect()->back()->with('error','Absensi hari ini telah terisi');
        }
        $data = $request->validate([
            'status'    => ['required'],
            'user_id'    => ['required']
        ]);
        $data['dates'] = date('Y-m-d');
        if ($request->status == 'Masuk' || $request->status == 'Telat') {
            $data['time_in'] = $request->jam_masuk;
            if (strtotime($data['time_in']) >= strtotime(config('absensi.jam_masuk') .' -1 hours') && strtotime($data['time_in']) <= strtotime(config('absensi.jam_masuk'))) {
                $data['status'] = 'Masuk';
            } else if (strtotime($data['time_in']) > strtotime(config('absensi.jam_masuk')) && strtotime($data['time_in']) <= strtotime(config('absensi.jam_pulang'))) {
                $data['status'] = 'Telat';
            } else {
                $data['status'] = 'Alpha';
            }
        }
        Present::create($data);
        return redirect()->back()->with('success','Kehadiran berhasil ditambahkan');
    }

    public function update(Request $request, $kehadiran)
    {
        $kehadiran = Present::findOrFail($kehadiran);
        $data = $request->validate([
            'status'    => ['required']
        ]);

        if ($request->jam_keluar) {
            $data['time_out'] = $request->jam_keluar;
        }

        if ($request->status == 'Masuk' || $request->status == 'Telat') {
            $data['time_in'] = $request->jam_masuk;
            if (strtotime($data['time_in']) >= strtotime(config('absensi.jam_masuk') .' -1 hours') && strtotime($data['time_in']) <= strtotime(config('absensi.jam_masuk'))) {
                $data['status'] = 'Masuk';
            } else if (strtotime($data['time_in']) > strtotime(config('absensi.jam_masuk')) && strtotime($data['time_in']) <= strtotime(config('absensi.jam_pulang'))) {
                $data['status'] = 'Telat';
            } else {
                $data['status'] = 'Alpha';
            }
        } else {
            $data['time_in'] = null;
            $data['time_out'] = null;
        }
        $kehadiran->update($data);
        return redirect()->back()->with('success', 'Kehadiran tanggal "'.date('l, d F Y',strtotime($kehadiran->dates)).'" berhasil diubah');
    }
}
