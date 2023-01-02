<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function index()
    {
        $submissions = Submission::orderBy('id', 'DESC')->paginate(5);
        $rank = $submissions->firstItem();
        $submissionToday = Submission::where('created_at', '>=', date('Y-m-d 00:00:00'))->count();
        return view('submission.index', compact('submissions', 'rank', 'submissionToday'));
    }

    public function create()
    {
        $submission = Submission::whereUserId(auth()->user()->id)->latest()->first();
        return view('submission.create', compact('submission'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required',
            'dates_start' => 'required',
            'dates_end' => 'required',
        ]);

        $submission = new Submission;
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

    public function show(Submission $submission)
    {
        $submission = Submission::find($submission->id);
        return view('submission.show', compact('submission'));
    }

    public function edit(Submission $submission)
    {
        return view('submission.edit', compact('submission'));
    }

    public function update(Request $request, Submission $submission)
    {
        $request->validate([
            'status' => 'required',
            'note' => 'required',
        ]);

        Submission::where('id', $submission->id)
            ->update([
                'status' => $request->status,
                'note' => $request->note,
            ]);
        return redirect()->route('submission.show', $submission->id)->with('status', 'Data berhasil diubah!');
    }

    public function destroy(Submission $submission)
    {
        if($submission->file) {
            Storage::delete($submission->file);
        }
        Submission::destroy($submission->id);
        return redirect()->route('submission.index')->with('status', 'Data berhasil dihapus!');
    }

    public function search(Request $request)
    {
        $request->validate([
            'cari' => 'required',
        ]);
        
        $search = $request->cari;
        $submissions = Submission::where('reason', 'like', '%' . $search . '%')->paginate(5);
        $rank = $submissions->firstItem();
        $submissionToday = Submission::where('created_at', '>=', date('Y-m-d 00:00:00'))->count();
        return view('submission.index', compact('submissions', 'rank', 'submissionToday'));
    }
}
