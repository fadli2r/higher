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

<div class="container mt-5">
    <h2 class="mb-4 text-center">My Orders</h2>
    <!-- Filter Form -->
    <form action="{{ route('myorders.index') }}" method="GET" class="mb-4">
        <div class="row align-items-center">
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Sedang Dikerjakan</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>
    <div class="list-group">
        @foreach($orders as $order)
        <div class="list-group-item">
            <!-- Judul Order -->
            <h5>
                Order #{{ $order->id }} -
                @if ($order->product)
                    {{ $order->product->title }}
                @elseif ($order->customRequest)
                    Custom Request: {{ $order->customRequest->name }}
                @else
                    Produk tidak ditemukan
                @endif
                - Status: {{ ucfirst($order->order_status) }}
            </h5>

            <!-- Progress Bar -->
            <div class="progress">
                <div class="progress-bar" role="progressbar"
                     style="width: {{ getOrderProgressWidth($order->id) }}%"
                     aria-valuenow="{{ getOrderProgressWidth($order->id) }}"
                     aria-valuemin="0" aria-valuemax="100">
                    {{ getOrderProgressText($order->id) }} - {{ getOrderProgressWidth($order->id) }}%
                </div>
            </div>

            <!-- Status Pending -->
            @if($order->order_status === 'pending')
                <p class="text-danger mt-2">Harap selesaikan pembayaran terlebih dahulu.</p>
            @else
                <!-- Lihat Progress -->
                <a href="{{ route('myorders.progress', $order->id) }}" class="btn btn-info mt-2">Lihat Progress</a>
            @endif

            <!-- Ulasan -->
            @if($order->order_status === 'completed' && $order->product && !$order->product->feedbacks->contains('user_id', auth()->id()))
                <a href="{{ route('feedback.create', $order->id) }}" class="btn btn-primary mt-2">Beri Ulasan</a>
            @elseif ($order->order_status === 'completed' && $order->customRequest && !$order->customRequest->feedbacks->contains('user_id', auth()->id()))
                <a href="{{ route('feedback.create', $order->id) }}" class="btn btn-primary mt-2">Beri Ulasan</a>
            @endif
        </div>
        @endforeach
    </div>
</div>
<div class="cs-height_95 cs-height_lg_70"></div>

@endsection

@php
    // Helper function untuk mendapatkan persentase progres order
    function getOrderProgressWidth($orderId) {
        $order = \App\Models\Order::with('workerTasks')->find($orderId);

        $completedSteps = $order->workerTasks->filter(function($task) {
            return $task->progress == 'completed';
        })->count();

        $totalSteps = $order->workerTasks->count();

        if ($totalSteps > 0) {
            return ($completedSteps / $totalSteps) * 100;
        }

        return 0; // Jika tidak ada step, return 0
    }

    // Helper function untuk mendapatkan status progres
    function getOrderProgressText($orderId) {
        $order = \App\Models\Order::with('workerTasks')->find($orderId);

        $completedSteps = $order->workerTasks->filter(function($task) {
            return $task->progress == 'completed';
        })->count();

        $totalSteps = $order->workerTasks->count();

        if ($completedSteps == $totalSteps) {
            return 'Completed';
        } elseif ($completedSteps > 0) {
            return 'In Progress';
        } else {
            return 'Not Started';
        }
    }
@endphp
