@extends('layout.layout')
<style>


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
<div class="cs-height_95 cs-height_lg_70"></div>

<div class="container">
    <h2>Order #{{ $order->id }}</h2>

    <!-- Tampilkan judul berdasarkan tipe Order -->
    @if ($order->product)
        <h3>Jasa: {{ $order->product->title }}</h3>
    @elseif ($order->customRequest)
        <h3>Custom Request: {{ $order->customRequest->name }}</h3>
    @endif

    <div class="list-group">
        @foreach($order->workerTasks as $task)
        <div class="list-group-item">
            <!-- Jika ini adalah workflow untuk produk -->
            @if ($task->productWorkflow)
                <h5>{{ $task->productWorkflow->step_name }}</h5>
            @elseif ($task->customRequest)
                <h5>{{ $task->task_description }}</h5> <!-- Custom Request Task -->
            @endif

            <!-- Progress Bar -->
            <div class="progress">
                <div class="progress-bar" role="progressbar"
                     style="width: {{ getTaskProgressWidth($task->id) }}%"
                     aria-valuenow="{{ getTaskProgressWidth($task->id) }}"
                     aria-valuemin="0" aria-valuemax="100">
                    {{ ucfirst($task->progress) }}
                </div>
            </div>

            <!-- Display Deadline -->
            <p><strong>Deadline:</strong> {{ $task->deadline }}</p>

            <!-- Revisi Section -->
            @if ($task->progress === 'revision_requested')
                <form action="{{ route('revisions.store') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="task_id" value="{{ $task->id }}">
                    <textarea name="description" class="form-control mb-2" required placeholder="Masukkan revisi..."></textarea>
                    <button type="submit" class="btn btn-warning">Kirim Revisi</button>
                </form>

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
<div class="cs-height_95 cs-height_lg_70"></div>

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
