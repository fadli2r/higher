@extends('layout.layout')
<style>
    .cs-list_group {
    display: grid; /* Menggunakan Grid Layout */
    gap: 15px; /* Jarak antar item */
    max-width: 1200px; /* Lebar maksimum untuk list group */
    margin: 0 auto; /* Memusatkan list group */
    padding: 15px; /* Padding di dalam list group */
    background-color: #f9f9f9; /* Warna latar belakang */
    border-radius: 5px; /* Sudut melengkung */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Bayangan */
}

.cs-list_group_item {
    border: 1px solid #ccc; /* Border untuk setiap item */
    border-radius: 5px; /* Sudut melengkung */
    padding: 10px; /* Padding di dalam item */
    background-color: #fff; /* Warna latar belakang item */
    transition: box-shadow 0.3s; /* Transisi untuk efek hover */
}

.cs-list_group_item:hover {
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Efek bayangan saat hover */
}

.cs-list_group_title {
    font-size: 1.2em; /* Ukuran font untuk judul */
    margin-bottom: 5px; /* Jarak bawah judul */
}

.cs-list_group_text {
    font-size: 1em; /* Ukuran font untuk teks */
    margin: 5px 0; /* Jarak atas dan bawah teks */
}

.cs-text_primary {
    color: #007bff; /* Warna untuk teks utama */
}

.cs-text_success {
    color: #28a745; /* Warna untuk teks sukses */
}

.cs-text_warning {
    color: #ffc107; /* Warna untuk teks peringatan */
}

.cs-text_danger {
    color: #dc3545; /* Warna untuk teks bahaya */
}

.cs-height_25 {
    height: 25px; /* Tinggi untuk jarak */
}

.cs-height_lg_25 {
    height: 25px; /* Tinggi untuk jarak besar */
}
    </style>
@section('content')
<div class="cs-height_95 cs-height_lg_70"></div>
<div class="cs-container">
    <h2 class="cs-section_title text-center">Promo untuk Member</h2>

    <div class="cs-list_group">
        @forelse($coupons as $coupon)
            <div class="cs-list_group_item">
                <h5 class="cs-list_group_title">Kode: <span class="cs-text_primary">{{ $coupon->code }}</span></h5>
                <p class="cs-list_group_text">
                    Diskon:
                    @if($coupon->discount_type == 'fixed')
                        <span class="cs-text_success">Rp {{ number_format($coupon->discount_value, 2) }}</span>
                    @else
                        <span class="cs-text_success">{{ $coupon->discount_value }}%</span>
                    @endif
                </p>
                <p class="cs-list_group_text">
                    Berlaku hingga: <span class="cs-text_warning">{{ $coupon->expires_at->format('d M Y') }}</span>
                </p>
            </div>
            <div class="cs-height_25 cs-height_lg_25"></div>
        @empty
            <div class="cs-list_group_item">
                <p class="cs-text_danger text-center">Tidak ada promo aktif saat ini.</p>
            </div>
        @endforelse
    </div>
</div>

<div class="cs-height_95 cs-height_lg_70"></div>

@endsection
