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
    <h2>My Orders</h2>
    <div class="list-group">
        @foreach($orders as $order)
        <div class="list-group-item">
            <h5>Order #{{ $order->id }} - Status: {{ ucfirst($order->order_status) }}</h5>

            <!-- Progress Bar -->
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: {{ getOrderProgressWidth($order->id) }}%" aria-valuenow="{{ getOrderProgressWidth($order->id) }}" aria-valuemin="0" aria-valuemax="100">
                    {{ getOrderProgressText($order->id) }} - {{ getOrderProgressWidth($order->id) }}%
                </div>
            </div>
            <div class="progress" >
                <div class="bar" style="width:35%">
                    <p class="percent">35%</p>
                </div>
            </div>
            <a href="{{ route('myorders.progress', $order->id) }}" class="btn btn-info mt-2">Lihat Progress</a>
            @if($order->order_status == 'pending' || $order->order_status == 'in_progress')
            <a href="{{ route('cart.createInvoice', $order->id) }}" class="btn btn-primary order-button">Bayar</a>
            @endif
            @if($order->order_status === 'completed' && !$order->product->feedbacks->contains('user_id', auth()->id()))
    <a href="{{ route('feedback.create', $order->id) }}" class="btn btn-primary">Beri Ulasan</a>
@endif

        </div>
        @endforeach

    </div>
</div>
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
