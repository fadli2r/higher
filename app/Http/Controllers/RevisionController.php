<?php

namespace App\Http\Controllers;
use App\Models\Revision;
use App\Models\WorkerTask;
use Illuminate\Http\Request;

class RevisionController extends Controller
{
    public function store(Request $request)
    {
        Revision::create([
            'task_id' => $request->task_id,
            'requested_by' => auth()->id(),
            'description' => $request->description,
            'status' => 'pending',
        ]);

        $task = WorkerTask::find($request->task_id);
        $task->progress = 'revision_requested';
        $task->save();

        return redirect()->back()->with('success', 'Revisi berhasil dikirim.');
    }
}
