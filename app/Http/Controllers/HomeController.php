<?php

namespace App\Http\Controllers;

use App\Helpers\GetHoliday;
use App\Models\Present;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $present = Present::whereUserId(auth()->user()->id)->whereDates(date('Y-m-d'))->first();
        $data = GetHoliday::getHoliday(date('Y/m'));
        $libur = $data['libur'];
        $holiday = $data['holiday'];        
        return view('home', compact('present','libur','holiday'));
    }
}
