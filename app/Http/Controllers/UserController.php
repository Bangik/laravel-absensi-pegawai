<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Present;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(5);
        $rank = $users->firstItem();
        return view('users.index', compact('users','rank'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->validate([
            'nama'  => ['required', 'max:32', 'string'],
            'nrp'   => ['required', 'digits:9','unique:users'],
            'foto'  => ['image', 'mimes:jpeg,png,gif', 'max:2048']
        ]);
        $password = Str::random(10);
        $user['password'] = Hash::make($password);
        if ($request->file('foto')) {
            $user['foto'] = $request->file('foto')->store('foto-profil');
        } else {
            $user['foto'] = 'default.jpg';
        }

        User::create($user);
        return redirect('/users')->with('success', 'User berhasil ditambahkan, password = '.$password);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $presents = Present::whereUserId($user->id)->whereMonth('dates',date('m'))->whereYear('dates',date('Y'))->orderBy('dates','desc')->paginate(5);
        $masuk = Present::whereUserId($user->id)->whereMonth('dates',date('m'))->whereYear('dates',date('Y'))->whereStatus('masuk')->count();
        $telat = Present::whereUserId($user->id)->whereMonth('dates',date('m'))->whereYear('dates',date('Y'))->whereStatus('telat')->count();
        $cuti = Present::whereUserId($user->id)->whereMonth('dates',date('m'))->whereYear('dates',date('Y'))->whereStatus('cuti')->count();
        $alpha = Present::whereUserId($user->id)->whereMonth('dates',date('m'))->whereYear('dates',date('Y'))->whereStatus('alpha')->count();
        $kehadiran = Present::whereUserId($user->id)->whereMonth('dates',date('m'))->whereYear('dates',date('Y'))->whereStatus('telat')->get();
        $totalJamTelat = 0;
        foreach ($kehadiran as $present) {
            $totalJamTelat = $totalJamTelat + (\Carbon\Carbon::parse($present->jam_masuk)->diffInHours(\Carbon\Carbon::parse(config('absensi.jam_masuk'))));
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
        return view('users.show',compact('user','presents','libur','masuk','telat','cuti','alpha','totalJamTelat'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'nama'  => ['required', 'max:32', 'string'],
            'nrp'   => ['required', 'digits:9',Rule::unique('users','nrp')->ignore($user)],
            'foto'  => ['image', 'mimes:jpeg,png,gif', 'max:2048']
        ]);
        if ($request->file('foto')) {
            if ($user->foto != 'default.jpg') {
                File::delete(public_path('storage'.'/'.$user->foto));
            }
            $data['foto'] = $request->file('foto')->store('foto-profil');
        }
        $user->update($data);
        return redirect()->back()->with('success', 'User berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $nama = $user->nama;
        if ($user->foto != 'default.jpg') {
            File::delete(public_path('storage'.'/'.$user->foto));
        }
        User::destroy($user->id);
        return redirect('/users')->with('success','User "'.$user->nama.'" berhasil dihapus');
    }
}
