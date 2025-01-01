@extends('layout.layout')

@section('content')
<div class="cs-height_95 cs-height_lg_70"></div>

<div class="container">
    <div class="cs-section_heading cs-style1 text-center">
        <h1 class="cs-section_title">Detail Tiket</h1>
    </div>

    <div class="cs-height_50 cs-height_lg_40"></div>

    <div class="cs-box cs-style1 cs-bg-light p-6 rounded-md shadow-md">
        <h2 class="cs-box_title">{{ $ticket->title }}</h2>
        <p class="cs-text_small">
            Status:
            <span class="font-bold
                @if ($ticket->status === 'open') cs-text_success
                @elseif ($ticket->status === 'in-progress') cs-text_warning
                @else cs-text_muted
                @endif">
                {{ ucfirst($ticket->status) }}
            </span>
        </p>
    </div>

    <div class="cs-height_50 cs-height_lg_40"></div>

    <div class="cs-box cs-style1">
        <h2 class="cs-box_title">Percakapan</h2>

        <div class="cs-height_20 cs-height_lg_20"></div>

        <div class="space-y-4">
            @foreach ($ticket->messages as $message)
                <div class="cs-box_message {{ $message->sender_type === 'user' ? 'cs-user_message' : 'cs-admin_message' }} p-4 rounded-md shadow-sm">
                    <div class="cs-box_meta text-xs">
                        [{{ $message->created_at->format('d M Y H:i') }}]
                        {{ $message->sender_type === 'user' ? $ticket->user->name : 'Admin' }}:
                    </div>
                    <p class="cs-box_text mt-1">{{ $message->message }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="cs-height_50 cs-height_lg_40"></div>

    <form action="{{ route('ticket-messages.store') }}" method="POST" class="cs-form cs-style1">
        @csrf
        <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">

        <div class="cs-form_group">
            <label for="message" class="cs-form_label">Balas Pesan</label>
            <textarea name="message" id="message" rows="4" class="cs-form_field" required></textarea>
        </div>

        <button type="submit" class="cs-btn cs-color1 cs-size_md w-full">
            Kirim
        </button>
    </form>
</div>

<div class="cs-height_75 cs-height_lg_70"></div>

<div class="cs-height_95 cs-height_lg_70"></div>

@endsection
