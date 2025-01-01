@extends('layout.layout')

@section('content')
<div class="cs-height_95 cs-height_lg_70"></div>

<div class="container">
    <h2>Beri Ulasan untuk Order #{{ $order->id }}</h2>

    <form action="{{ route('feedback.store', $order->id) }}" method="POST">
        @csrf

        <label for="rating">Rating (1-5)</label>
        <select name="rating" id="rating" required>
            <option value="5">5 - Sangat Baik</option>
            <option value="4">4 - Baik</option>
            <option value="3">3 - Cukup</option>
            <option value="2">2 - Kurang</option>
            <option value="1">1 - Buruk</option>
        </select>

        <label for="comment">Komentar</label>
        <textarea name="comment" id="comment" rows="4" placeholder="Tulis komentar Anda..."></textarea>

        <button type="submit" class="btn btn-success mt-3">Kirim Ulasan</button>
    </form>
</div>
<div class="cs-height_95 cs-height_lg_70"></div>

@endsection
