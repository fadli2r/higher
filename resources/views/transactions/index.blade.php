@extends('layout.layout')
<style>
    /* Default badge styling */
.badge {
    display: inline-block;
    padding: 0.25em 0.5em;
    font-size: 0.875em;
    font-weight: 700;
    line-height: 1;
    color: white;
    border-radius: 0.25rem;
    text-align: center;
}

/* Status-specific styling */
.bg-success {
    background-color: #28a745; /* Green */
}

.bg-warning {
    background-color: #ffc107; /* Yellow */
}

.bg-danger {
    background-color: #dc3545; /* Red */
}

.bg-info {
    background-color: #17a2b8; /* Blue */
}

    </style>

@section('content')
<div class="cs-height_95 cs-height_lg_70"></div>

<div class="container mt-5">
    <h1 class="mb-4 text-center">Transaksi Saya</h1>
    <div class="mb-4">
        <form method="GET" action="{{ route('transactions.index') }}">
            <div class="d-flex gap-3">
                <select name="status" class="form-select w-auto">
                    <option value="">Semua Status</option>
                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Gagal</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-light">
                <tr>
                    <th>Invoice</th>
                    <th>Total Harga</th>
                    <th>Tipe Pembayaran</th>
                    <th>Sisa Pembayaran</th>
                    <th>Status Pembayaran</th>
                    <th>Tanggal</th>
                    <th>Jatuh Tempo</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr>
                        <td>
                            @if ($transaction->invoice)
                                <a href="{{ route('invoices.show', $transaction->invoice->id) }}">
                                    {{ $transaction->invoice->invoice_number }}
                                </a>
                            @else
                                <span class="text-muted">Invoice tidak tersedia</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($transaction->total_price, 2) }}</td>
                        <td>{{ ($transaction->down_payment > 0) ? 'Down Payment' : 'Full Payment' }}</td>
                        <td>{{ ($transaction->remaining_payment > 0) ? 'Rp. '.number_format($transaction->remaining_payment, 0, ',', '.') : '-' }}</td>
                        <td>
                            <span class="badge
                            {{ $transaction->payment_status === 'paid' ? 'bg-success' : '' }}
                            {{ $transaction->payment_status === 'pending' ? 'bg-warning' : '' }}
                            {{ $transaction->payment_status === 'failed' ? 'bg-danger' : '' }}">
                            {{ ucfirst($transaction->payment_status) }}
                            </span>
                        </td>
                        <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                        <td>
                            @if ($transaction->invoice)
                                {{ $transaction->invoice->due_date->format('d M Y') }}
                            @else
                                <span class="text-muted">Tidak tersedia</span>
                            @endif
                        </td>
                        <td>
                            @if($transaction->payment_status === 'pending')
                                <a href="{{ $transaction->invoice_url }}" class="btn btn-primary btn-sm" target="_blank">Bayar</a>
                            @elseif($transaction->payment_status === 'failed')
                                <span class="text-danger">Transaksi Gagal</span>
                            @else
                                <span class="text-success">Sudah Dibayar</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
<div class="cs-height_95 cs-height_lg_70"></div>

@endsection
