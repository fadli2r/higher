<?php

namespace App\Http\Controllers;
use App\Models\WorkerTask;

use Illuminate\Http\Request;

class WorkerTaskController extends Controller
{
    public function complete($id)
    {
        $task = WorkerTask::find($id);
        $task->progress = 'completed';
        $task->save();

        return redirect()->back()->with('success', 'Tugas berhasil diselesaikan.');
    }
}
