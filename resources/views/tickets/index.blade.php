@extends('layout.layout')
<style>
.status-badge {
    display: inline-block; /* Membuat badge menjadi inline-block */
    padding: 6px 12px; /* Padding dalam badge */
    font-size: 0.875rem; /* Ukuran font */
    font-weight: bold; /* Teks lebih tebal */
    border-radius: 12px; /* Sudut melengkung untuk badge */
    text-align: center; /* Rata tengah teks */
    text-transform: capitalize; /* Membuat teks dengan huruf pertama kapital */
    color: white; /* Warna teks */
}

/* Warna badge berdasarkan status */
.status-open {
    background-color: #28a745; /* Hijau untuk status "open" */
}

.status-in-progress {
    background-color: #ffc107; /* Kuning untuk status "in-progress" */
    color: #333; /* Warna teks lebih gelap untuk kontras */
}

.status-closed {
    background-color: #6c757d; /* Abu-abu untuk status "closed" */
}

/* Efek hover pada badge */
.status-badge:hover {
    opacity: 0.9; /* Sedikit redup saat hover */
    transform: scale(1.05); /* Sedikit membesar saat hover */
    transition: all 0.3s ease; /* Animasi halus */
}
    </style>

@section('content')
<div class="cs-height_95 cs-height_lg_70"></div>

<div class="container mx-auto py-6">
    <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Daftar Tiket</h1>

    <div class="text-center mb-6">
        <button onclick="window.location='{{ route('tickets.create') }}'" class="inline-block px-6 py-3 bg-blue-600 text-black rounded-lg shadow hover:bg-blue-700 transition duration-200">
            Buat Tiket Baru
        </button>
    </div>

    <div class="mt-6">
        @if ($tickets->isEmpty())
            <p class="text-gray-500 text-center">Belum ada tiket yang dibuat.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 shadow-md rounded-lg">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2 text-left font-semibold">Judul</th>
                            <th class="border border-gray-300 px-4 py-2 text-center font-semibold">Status</th>
                            <th class="border border-gray-300 px-4 py-2 text-center font-semibold">Tanggal</th>
                            <th class="border border-gray-300 px-4 py-2 text-center font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $ticket)
                            <tr class="hover:bg-gray-50 transition duration-200">
                                <td class="border border-gray-300 px-4 py-2">{{ $ticket->title }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <span class="status-badge
                                        @if ($ticket->status === 'open') status-open
                                        @elseif ($ticket->status === 'in-progress') status-in-progress
                                        @else status-closed
                                        @endif">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </td>

                                <td class="border border-gray-300 px-4 py-2 text-center">{{ $ticket->created_at->format('d M Y') }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <a href="{{ route('tickets.show', $ticket->id) }}" class="text-blue-600 hover:underline">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
<div class="cs-height_95 cs-height_lg_70"></div>

@endsection
