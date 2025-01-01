@extends('layout.layout')

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
