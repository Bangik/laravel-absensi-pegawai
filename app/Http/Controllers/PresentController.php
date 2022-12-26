<?php

namespace App\Http\Controllers;

use App\Models\Present;
use App\Models\Setting;
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
        $time_in = Setting::where('name', 'time_in')->first()->value;

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
            $totalJamTelat = $totalJamTelat + (\Carbon\Carbon::parse($present->time_in)->diffInHours(\Carbon\Carbon::parse($time_in .' -1 hours')));
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
        $time_in = Setting::where('name', 'time_in')->first()->value;
        $time_out = Setting::where('name', 'time_out')->first()->value;
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
            if (strtotime($data['time_in']) >= strtotime($time_in .' -1 hours') && strtotime($data['time_in']) <= strtotime($time_in)) {
                $data['status'] = 'Masuk';
            } else if (strtotime($data['time_in']) > strtotime($time_in) && strtotime($data['time_in']) <= strtotime($time_out)) {
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
        $time_in = Setting::where('name', 'time_in')->first()->value;
        $time_out = Setting::where('name', 'time_out')->first()->value;
        $kehadiran = Present::findOrFail($kehadiran);
        $data = $request->validate([
            'status'    => ['required']
        ]);

        if ($request->jam_keluar) {
            $data['time_out'] = $request->jam_keluar;
        }

        if ($request->status == 'Masuk' || $request->status == 'Telat') {
            $data['time_in'] = $request->jam_masuk;
            if (strtotime($data['time_in']) >= strtotime($time_in .' -1 hours') && strtotime($data['time_in']) <= strtotime($time_in)) {
                $data['status'] = 'Masuk';
            } else if (strtotime($data['time_in']) > strtotime($time_in) && strtotime($data['time_in']) <= strtotime($time_out)) {
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

    public function ubah(Request $request)
    {
        $present = Present::findOrFail($request->id);
        echo json_encode($present);
    }

    public function checkIn(Request $request)
    {
        $time_in = Setting::where('name', 'time_in')->first()->value;
        $time_out = Setting::where('name', 'time_out')->first()->value;
        $users = User::all();
        $radius = Setting::where('name', 'radius')->first()->value;
        $data['time_in']  = date('H:i:s');
        $data['dates']    = date('Y-m-d');
        $data['user_id']    = $request->user_id;

        if (date('l') == 'Saturday' || date('l') == 'Sunday') {
            return redirect()->back()->with('error','Hari Libur Tidak bisa Check In');
        }

        if($request->distance > $radius) {
            return redirect()->back()->with('error','Anda berada diluar radius kantor');
        }

        foreach ($users as $user) {
            $absen = Present::whereUserId($user->id)->whereDates($data['dates'])->first();
            if (!$absen) {
                if ($user->id != $data['user_id']) {
                    Present::create([
                        'status'    => 'Alpha',
                        'dates'       => date('Y-m-d'),
                        'user_id'       => $user->id
                    ]);
                }
            }
        }

        if (strtotime($data['time_in']) >= strtotime($time_in .' -1 hours') && strtotime($data['time_in']) <= strtotime($time_in)) {
            $data['status'] = 'Masuk';
        } else if (strtotime($data['time_in']) > strtotime($time_in) && strtotime($data['time_in']) <= strtotime($time_out)) {
            $data['status'] = 'Telat';
        } else {
            $data['status'] = 'Alpha';
        }

        $present = Present::whereUserId($data['user_id'])->whereDates($data['dates'])->first();
        if ($present) {
            if ($present->status == 'Alpha') {
                $present->update($data);
                return redirect()->back()->with('success','Check-in berhasil');
            } else {
                return redirect()->back()->with('error','Check-in gagal');
            }
        }

        Present::create($data);
        return redirect()->back()->with('success','Check-in berhasil');
    }

    public function checkOut(Request $request, Present $kehadiran)
    {
        $radius = Setting::where('name', 'radius')->first()->value;
        if($request->distance > $radius) {
            return redirect()->back()->with('error','Anda berada diluar radius kantor');
        }

        $data['time_out'] = date('H:i:s');
        $kehadiran->update($data);
        return redirect()->back()->with('success', 'Check-out berhasil');
    }

    public function cariDaftarHadir(Request $request)
    {
        $request->validate([
            'bulan' => ['required']
        ]);
        $data = explode('-',$request->bulan);
        $presents = Present::whereUserId(auth()->user()->id)->whereMonth('dates',$data[1])->whereYear('dates',$data[0])->orderBy('dates','desc')->paginate(5);
        $masuk = Present::whereUserId(auth()->user()->id)->whereMonth('dates',$data[1])->whereYear('dates',$data[0])->wherestatus('masuk')->count();
        $telat = Present::whereUserId(auth()->user()->id)->whereMonth('dates',$data[1])->whereYear('dates',$data[0])->wherestatus('telat')->count();
        $cuti = Present::whereUserId(auth()->user()->id)->whereMonth('dates',$data[1])->whereYear('dates',$data[0])->wherestatus('cuti')->count();
        $alpha = Present::whereUserId(auth()->user()->id)->whereMonth('dates',$data[1])->whereYear('dates',$data[0])->wherestatus('alpha')->count();
        return view('presents.show', compact('presents','masuk','telat','cuti','alpha'));
    }
    
    public function show()
    {
        $presents = Present::whereUserId(auth()->user()->id)->whereMonth('dates',date('m'))->whereYear('dates',date('Y'))->orderBy('dates','desc')->paginate(6);
        $masuk = Present::whereUserId(auth()->user()->id)->whereMonth('dates',date('m'))->whereYear('dates',date('Y'))->wherestatus('masuk')->count();
        $telat = Present::whereUserId(auth()->user()->id)->whereMonth('dates',date('m'))->whereYear('dates',date('Y'))->wherestatus('telat')->count();
        $cuti = Present::whereUserId(auth()->user()->id)->whereMonth('dates',date('m'))->whereYear('dates',date('Y'))->wherestatus('cuti')->count();
        $alpha = Present::whereUserId(auth()->user()->id)->whereMonth('dates',date('m'))->whereYear('dates',date('Y'))->wherestatus('alpha')->count();
        return view('presents.show', compact('presents','masuk','telat','cuti','alpha'));
    }
}
