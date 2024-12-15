@extends('layout.template')
@section('styles')
<style>
    * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: white;
    border-bottom: 1px solid #ddd;
}
ul {
    list-style: none;
    margin-bottom: 20px;
    padding-top: 20px;
}

.logo {
    font-size: 24px;
    font-weight: bold;
}

.menu ul {
    list-style: none;
    display: flex;
    gap: 20px;
}

.menu a {
    text-decoration: none;
    color: #333;
    font-weight: 500;
}

.menu a:hover {
    color: #007BFF;
}

.icons {
    display: flex;
    gap: 15px;
}

.icon {
    text-decoration: none;
    font-size: 20px;
    color: #333;
}

.icon:hover {
    color: #007BFF;
}

/* Responsif */
@media (max-width: 768px) {
    .header {
        flex-direction: column;
        align-items: flex-start;
    }

    .menu ul {
        flex-direction: column;
        gap: 10px;
    }
}

/* progress BAR */
.progress {
  margin:20px auto;
  padding:0;
  width:90%;
  height:30px;
  overflow:hidden;
  background:#e5e5e5;
  border-radius:6px;
}

.bar {
	position:relative;
  float:left;
  min-width:1%;
  height:100%;
  background:cornflowerblue;
}

.percent {
	position:absolute;
  top:50%;
  left:50%;
  transform:translate(-50%,-50%);
  margin:0;
  font-family:tahoma,arial,helvetica;
  font-size:12px;
  color:white;
}

    </style>
@section('content')
<div class="container">
    <h2>Order #{{ $order->id }} - Product: {{ $order->product->title }}</h2> <!-- Show product title here -->

    <div class="list-group">
        @foreach($order->workerTasks as $task)
        <div class="list-group-item">
            <h5>{{ $task->productWorkflow->step_name }}</h5>

            <!-- Progress Bar -->
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: {{ getTaskProgressWidth($task->id) }}%" aria-valuenow="{{ getTaskProgressWidth($task->id) }}" aria-valuemin="0" aria-valuemax="100">
                    {{ ucfirst($task->progress) }}
                </div>
            </div>

            <!-- Display Deadline -->
            <p><strong>Deadline:</strong> {{ $task->deadline }}</p> <!-- Format tanggal -->

            <!-- Revisi Section -->
            @if ($task->progress === 'revision_requested')
    <!-- Tombol Revisi -->
    <form action="{{ route('revisions.store') }}" method="POST" class="d-inline">
        @csrf
        <input type="hidden" name="task_id" value="{{ $task->id }}">
        <textarea name="description" class="form-control mb-2" required placeholder="Masukkan revisi..."></textarea>
        <button type="submit" class="btn btn-warning">Kirim Revisi</button>
    </form>

    <!-- Tombol Lanjutkan -->
    <form action="{{ route('worker-tasks.complete', $task->id) }}" method="POST" class="d-inline">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-success">Lanjutkan</button>
    </form>
@endif



            <!-- Download Report Button -->
            <div class="mt-3">
                @if($task->file_path)
                    <a href="{{ asset('storage/' . $task->file_path) }}" class="btn btn-success" download>
                        Download Report ({{ basename($task->file_path) }})
                    </a>
                @else
                    <p class="mt-2 text-muted">No report available for this task.</p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@php
    function getTaskProgressWidth($taskId) {
        $task = \App\Models\WorkerTask::find($taskId);

        switch ($task->progress) {
            case 'not_started': return 0;
            case 'in_progress': return 50;
            case 'revision_requested': return 75;
            case 'completed': return 100;
            default: return 0;
        }
    }
@endphp
