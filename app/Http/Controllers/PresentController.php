<?php

namespace App\Http\Controllers;

use App\Models\Present;
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
}
