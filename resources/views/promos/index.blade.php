@extends('layout.template')
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
    <h2>Promo untuk Member</h2>

    <div class="list-group">
        @forelse($coupons as $coupon)
            <div class="list-group-item">
                <h5>Kode: {{ $coupon->code }}</h5>
                <p>Diskon:
                    @if($coupon->discount_type == 'fixed')
                        Rp {{ number_format($coupon->discount_value, 2) }}
                    @else
                        {{ $coupon->discount_value }}%
                    @endif
                </p>
                <p>Berlaku hingga: {{ $coupon->expires_at->format('d M Y') }}</p>
            </div>
        @empty
            <p>Tidak ada promo aktif saat ini.</p>
        @endforelse
    </div>
</div>
@endsection
