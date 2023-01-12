<?php

namespace App\Http\Controllers;

use App\Models\WorkSchedule;
use Illuminate\Http\Request;

class WorkScheduleController extends Controller
{
    public function index()
    {
        $schedules = WorkSchedule::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(5);
        $rank = $schedules->firstItem();
        $unfinish = WorkSchedule::where('user_id', auth()->user()->id)->where('status', 'Belum Selesai')->count();
        $process = WorkSchedule::where('user_id', auth()->user()->id)->where('status', 'Proses')->count();
        $finish = WorkSchedule::where('user_id', auth()->user()->id)->where('status', 'Selesai')->count();
        $notfinish = WorkSchedule::where('user_id', auth()->user()->id)->where('status', 'Tidak Selesai')->count();
        return view('workSchedule.index', compact('schedules', 'rank', 'unfinish', 'process', 'finish', 'notfinish'));
    }

    public function create()
    {
        return view('workSchedule.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'activity' => 'required',
            'target' => 'required',
            'report' => 'required',
            'dates' => 'required',
            'due_date' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);

        $schedule = new WorkSchedule;
        $schedule->user_id = auth()->user()->id;
        $schedule->activity = $request->activity;
        $schedule->target = $request->target;
        $schedule->report = $request->report;
        $schedule->status = 'Belum Selesai';
        $schedule->approval = 'Tertunda';
        $schedule->dates = $request->dates;
        $schedule->due_date = $request->due_date;
        $schedule->start = $request->start;
        $schedule->end = $request->end;

        if ($request->hasFile('file')) {
            $schedule->file = $request->file('file')->store('files');
        }

        $schedule->save();

        return redirect()->route('aktivitas-kerja.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function detail($id)
    {
        $schedule = WorkSchedule::where('user_id', auth()->user()->id)->find($id);
        if (!$schedule) {
            return redirect()->route('aktivitas-kerja.index')->with('error', 'Data tidak ditemukan');
        }
        return view('workSchedule.detail', compact('schedule'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'cari' => 'required',
        ]);

        $search = $request->cari;
        $schedules = WorkSchedule::where('user_id', auth()->user()->id)
        ->where('activity', 'like', "%".$search."%")
        ->orWhere('target', 'like', "%".$search."%")
        ->orWhere('report', 'like', "%".$search."%")
        ->paginate(5);
        $rank = $schedules->firstItem();
        $unfinish = WorkSchedule::where('user_id', auth()->user()->id)->where('status', 'Belum Selesai')->count();
        $process = WorkSchedule::where('user_id', auth()->user()->id)->where('status', 'Proses')->count();
        $finish = WorkSchedule::where('user_id', auth()->user()->id)->where('status', 'Selesai')->count();
        $notfinish = WorkSchedule::where('user_id', auth()->user()->id)->where('status', 'Tidak Selesai')->count();
        return view('workSchedule.index', compact('schedules', 'rank', 'unfinish', 'process', 'finish', 'notfinish'));
    }

    public function list(){
        $schedules = WorkSchedule::orderBy('id', 'DESC')->paginate(5);
        $rank = $schedules->firstItem();
        $pending = WorkSchedule::where('approval', 'Tertunda')->count();
        $approved = WorkSchedule::where('approval', 'Disetujui')->count();
        $rejected = WorkSchedule::where('approval', 'Ditolak')->count();
        return view('workSchedule.list', compact('schedules', 'rank', 'pending', 'approved', 'rejected'));
    }

    public function searchActivity(Request $request){
        $request->validate([
            'cari' => 'required',
        ]);

        $search = $request->cari;
        $schedules = WorkSchedule::whereHas('user', function($query) use($search){
            $query->where('users.name', 'like', '%'.$search.'%');
        })
        ->orWhere('activity', 'like', "%".$search."%")
        ->orWhere('target', 'like', "%".$search."%")
        ->orWhere('report', 'like', "%".$search."%")
        ->paginate(5);
        $rank = $schedules->firstItem();
        $pending = WorkSchedule::where('approval', 'Tertunda')->count();
        $approved = WorkSchedule::where('approval', 'Disetujui')->count();
        $rejected = WorkSchedule::where('approval', 'Ditolak')->count();
        return view('workSchedule.list', compact('schedules', 'rank', 'pending', 'approved', 'rejected'));
    }

    public function show($id){
        $schedule = WorkSchedule::find($id);
        if (!$schedule) {
            return redirect()->route('aktivitas-kerja.list')->with('error', 'Data tidak ditemukan');
        }
        return view('workSchedule.show', compact('schedule'));
    }

    public function approval(Request $request, $id){
        $request->validate([
            'approval' => 'required',
            'note' => 'required',
        ]);

        $schedule = WorkSchedule::find($id);
        if (!$schedule) {
            return redirect()->route('aktivitas-kerja.list')->with('error', 'Data tidak ditemukan');
        }

        $schedule->approval = $request->approval;
        $schedule->note = $request->note;
        $schedule->save();

        return redirect()->route('aktivitas-kerja.list')->with('success', 'Data berhasil diubah');
    }

    public function destroy($id)
    {
        $schedule = WorkSchedule::find($id);
        if (!$schedule) {
            return redirect()->route('aktivitas-kerja.list')->with('error', 'Data tidak ditemukan');
        }
        $schedule->delete();
        return redirect()->route('aktivitas-kerja.list')->with('success', 'Data berhasil dihapus');
    }
}
