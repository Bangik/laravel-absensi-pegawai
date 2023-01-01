<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $name = Setting::where('name', 'site_name')->first()->value;
        $lat = Setting::where('name', 'latitude')->first()->value;
        $long = Setting::where('name', 'longitude')->first()->value;
        $time_in = Setting::where('name', 'time_in')->first()->value;
        $time_out = Setting::where('name', 'time_out')->first()->value;
        $time_in_reminder = Setting::where('name', 'time_in_reminder')->first()->value;
        $radius = Setting::where('name', 'radius')->first()->value;

        return view('setting.index', compact('name', 'lat', 'long', 'time_in', 'time_out', 'radius', 'time_in_reminder'));
    }

    public function update(Request $request){
        $request->validate([
            'name' => 'required',
            'lat' => 'required',
            'long' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',
            'time_in_reminder' => 'required',
            'radius' => 'required',
        ]);

        $name = Setting::where('name', 'site_name')->first();
        $name->value = $request->name;
        $name->save();

        $lat = Setting::where('name', 'latitude')->first();
        $lat->value = $request->lat;
        $lat->save();

        $long = Setting::where('name', 'longitude')->first();
        $long->value = $request->long;
        $long->save();

        $time_in = Setting::where('name', 'time_in')->first();
        $time_in->value = $request->time_in;
        $time_in->save();

        $time_out = Setting::where('name', 'time_out')->first();
        $time_out->value = $request->time_out;
        $time_out->save();

        $time_in_reminder = Setting::where('name', 'time_in_reminder')->first();
        $time_in_reminder->value = $request->time_in_reminder;
        $time_in_reminder->save();

        $radius = Setting::where('name', 'radius')->first();
        $radius->value = $request->radius;
        $radius->save();

        return redirect()->route('setting.index')->with('success', 'Setting berhasil diubah');
    }
}
