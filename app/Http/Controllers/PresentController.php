<?php

namespace App\Http\Controllers;

use App\Models\Present;
use Illuminate\Http\Request;

class PresentController extends Controller
{
    public function index()
    {
        $presents = Present::whereDates(date('Y-m-d'))->orderBy('jam_masuk','desc')->paginate(6);
        $masuk = Present::whereDates(date('Y-m-d'))->whereStatus('masuk')->count();
        $telat = Present::whereDates(date('Y-m-d'))->whereStatus('telat')->count();
        $cuti = Present::whereDates(date('Y-m-d'))->whereStatus('cuti')->count();
        $alpha = Present::whereDates(date('Y-m-d'))->whereStatus('alpha')->count();
        $rank = $presents->firstItem();
        return view('presents.index', compact('presents','rank','masuk','telat','cuti','alpha'));
    }
}
