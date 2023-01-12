<?php

namespace App\Http\Controllers;

use App\Models\OvertimeApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OvertimeApplicationController extends Controller
{
    public function index()
    {
        $overtimes = OvertimeApplication::orderBy('id', 'DESC')->paginate(5);
        $rank = $overtimes->firstItem();
        $overtimeToday = OvertimeApplication::where('created_at', '>=', date('Y-m-d 00:00:00'))->count();
        return view('overtime.index', compact('overtimes', 'rank', 'overtimeToday'));
    }

    public function create()
    {
        $overtime = OvertimeApplication::whereUserId(auth()->user()->id)->latest()->first();
        return view('overtime.create', compact('overtime'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'dates' => 'required',
            'start' => 'required',
            'end' => 'required',
        ]);

        $overtime = new OvertimeApplication;
        $overtime->user_id = auth()->user()->id;
        $overtime->description = $request->description;
        $overtime->status = 'Tertunda';
        $overtime->dates = $request->dates;
        $overtime->start = $request->start;
        $overtime->end = $request->end;

        if($request->file('file')) {
            $overtime->file = $request->file('file')->store('files');
        }

        $overtime->save();

        return redirect()->route('overtime.create')
            ->with('success', 'Lembur berhasil diajukan!');
    }

    public function show(OvertimeApplication $overtime)
    {
        return view('overtime.show', compact('overtime'));
    }

    public function edit(OvertimeApplication $overtime)
    {
        return view('overtime.edit', compact('overtime'));
    }

    public function update(Request $request, OvertimeApplication $overtime)
    {
        $request->validate([
            'status' => 'required',
            'note' => 'required',
        ]);
        $overtime->update($request->all());

        return redirect()->route('overtime.show', $overtime->id)
            ->with('success', 'Status lembur berhasil diubah!');
    }

    public function destroy(OvertimeApplication $overtime)
    {
        if($overtime->file) {
            Storage::delete($overtime->file);
        }

        $overtime->delete();

        return redirect()->route('overtime.index')
            ->with('success', 'Lembur berhasil dihapus!');
    }

    public function list(){
        $overtimes = OvertimeApplication::whereUserId(auth()->user()->id)->orderBy('id', 'DESC')->paginate(5);
        $rank = $overtimes->firstItem();
        return view('overtime.list', compact('overtimes', 'rank'));
    }

    public function detail($id){
        $overtime = OvertimeApplication::whereId($id)->whereUserId(auth()->user()->id)->first();
        if(!$overtime) {
            return redirect()->route('overtime.list')->with('error', 'Data tidak ditemukan!');
        }
        return view('overtime.detail', compact('overtime'));
    }
    
    public function search(Request $request){
        $request->validate([
            'cari' => 'required',
        ]);
        
        $search = $request->cari;
        $overtimes = OvertimeApplication::whereHas('user', function($query) use($search){
            $query->where('users.name', 'like', '%'.$search.'%');
        })
        ->orWhere('description', 'like', "%".$search."%")
        ->orderBy('id', 'DESC')->paginate(5);
        $rank = $overtimes->firstItem();
        $overtimeToday = OvertimeApplication::where('created_at', '>=', date('Y-m-d 00:00:00'))->count();
        return view('overtime.index', compact('overtimes', 'rank', 'overtimeToday'));
    }

    public function searchHistory(Request $request){
        $request->validate([
            'cari' => 'required',
        ]);
        
        $search = $request->cari;
        $overtimes = OvertimeApplication::whereUserId(auth()->user()->id)->where('description', 'like', "%".$search."%")->orderBy('id', 'DESC')->paginate(5);
        $rank = $overtimes->firstItem();
        return view('overtime.list', compact('overtimes', 'rank'));
    }
}
