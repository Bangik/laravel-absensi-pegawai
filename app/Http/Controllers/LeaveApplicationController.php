<?php

namespace App\Http\Controllers;

use App\Models\LeaveApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LeaveApplicationController extends Controller
{
    public function index()
    {
        $submissions = LeaveApplication::orderBy('id', 'DESC')->paginate(5);
        $rank = $submissions->firstItem();
        $submissionToday = LeaveApplication::where('created_at', '>=', date('Y-m-d 00:00:00'))->count();
        return view('submission.index', compact('submissions', 'rank', 'submissionToday'));
    }

    public function list(){
        $submissions = LeaveApplication::whereUserId(auth()->user()->id)->orderBy('id', 'DESC')->paginate(5);
        $rank = $submissions->firstItem();
        return view('submission.list', compact('submissions', 'rank'));
    }

    public function detail($id){
        $submission = LeaveApplication::whereId($id)->whereUserId(auth()->user()->id)->first();
        if(!$submission) {
            return redirect()->route('submission.list')->with('error', 'Data tidak ditemukan!');
        }
        return view('submission.detail', compact('submission'));
    }

    public function create()
    {
        $submission = LeaveApplication::whereUserId(auth()->user()->id)->latest()->first();
        return view('submission.create', compact('submission'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required',
            'dates_start' => 'required',
            'dates_end' => 'required',
        ]);

        $submission = new LeaveApplication;
        $submission->user_id = auth()->user()->id;
        $submission->reason = $request->reason;
        $submission->status = 'Tertunda';
        $submission->dates_start = $request->dates_start;
        $submission->dates_end = $request->dates_end;

        if($request->file('file')) {
            $submission->file = $request->file('file')->store('files');
        }

        $submission->save();

        return redirect()->route('submission.create')->with('success', 'Cuti berhasil diajukan!');
    }

    public function show(LeaveApplication $submission)
    {
        $submission = LeaveApplication::find($submission->id);
        return view('submission.show', compact('submission'));
    }

    public function edit(LeaveApplication $submission)
    {
        return view('submission.edit', compact('submission'));
    }

    public function update(Request $request, LeaveApplication $submission)
    {
        $request->validate([
            'status' => 'required',
            'note' => 'required',
        ]);

        LeaveApplication::where('id', $submission->id)
            ->update([
                'status' => $request->status,
                'note' => $request->note,
            ]);
        return redirect()->route('submission.show', $submission->id)->with('status', 'Data berhasil diubah!');
    }

    public function destroy(LeaveApplication $submission)
    {
        if($submission->file) {
            Storage::delete($submission->file);
        }
        LeaveApplication::destroy($submission->id);
        return redirect()->route('submission.index')->with('status', 'Data berhasil dihapus!');
    }

    public function search(Request $request)
    {
        $request->validate([
            'cari' => 'required',
        ]);
        
        $search = $request->cari;
        $submissions = LeaveApplication::
        whereHas('user', function($query) use($search){
            $query->where('users.name', 'like', '%'.$search.'%');
        })
        ->orWhere('reason', 'like', '%' . $search . '%')->paginate(5);
        $rank = $submissions->firstItem();
        $submissionToday = LeaveApplication::where('created_at', '>=', date('Y-m-d 00:00:00'))->count();
        return view('submission.index', compact('submissions', 'rank', 'submissionToday'));
    }

    public function searchHistory(Request $request)
    {
        $request->validate([
            'cari' => 'required',
        ]);
        
        $search = $request->cari;
        $submissions = LeaveApplication::whereUserId(auth()->user()->id)->where('reason', 'like', '%' . $search . '%')->paginate(5);
        $rank = $submissions->firstItem();
        return view('submission.list', compact('submissions', 'rank'));
    }
}
