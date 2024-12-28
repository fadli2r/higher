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
.container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .message {
            margin: 10px 0;
            padding: 10px;
            border-radius: 5px;
        }
        .user {
            background-color: #e1f5fe;
            text-align: left;
        }
        .admin {
            background-color: #ffe0b2;
            text-align: left;
        }
        .timestamp {
            font-size: 0.8em;
            color: #888;
        }

    </style>

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Detail Tiket</h1>

    <div class="bg-gray-100 p-6 rounded-md shadow-md">
        <h2 class="text-2xl font-semibold">{{ $ticket->title }}</h2>
        <p class="text-sm text-gray-500">Status:
            <span class="font-bold @if ($ticket->status === 'open') text-green-600
            @elseif ($ticket->status === 'in-progress') text-yellow-500
            @else text-gray-500
            @endif">
                {{ ucfirst($ticket->status) }}
            </span>
        </p>
    </div>

    <div class="mt-6">
        <h2 class="text-lg font-bold mb-4">Percakapan</h2>

        <div class="space-y-4">
            @foreach ($ticket->messages as $message)
                <div class="message {{ $message->sender_type === 'user' ? 'user' : 'admin' }} p-4 rounded-md shadow-sm bg-white">
                    <div class="timestamp text-xs text-gray-400">
                        [{{ $message->created_at->format('d M Y H:i') }}]
                        {{ $message->sender_type === 'user' ? $ticket->user->name : 'Admin' }}:
                    </div>
                    <p class="mt-1">{{ $message->message }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <form action="{{ route('ticket-messages.store') }}" method="POST" class="mt-6 space-y-4">
        @csrf
        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

        <div>
            <label for="message" class="block font-medium text-gray-700">Balas Pesan</label>
            <textarea name="message" id="message" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required></textarea>
        </div>

        <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
            Kirim
        </button>
    </form>
</div>
@endsection
