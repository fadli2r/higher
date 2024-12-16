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
<h2>Custom Desain</h2>

<form action="{{ route('custom-design.store') }}" method="POST" id="customDesignForm">
    @csrf

    <div>
        <label>Nama Proyek</label>
        <input type="text" name="name" required>
    </div>

    <div>
        <label>Deskripsi</label>
        <textarea name="description" required></textarea>
    </div>

    <div>
        <label>Ukuran</label>
        @if($customSizes->isEmpty())
            <p>No sizes available</p>
        @else
            <select name="size_id" id="size_id" required>
                <option value="" data-price="0">Pilih Ukuran</option>
                @foreach($customSizes as $size)
                    <option value="{{ $size->id }}" data-price="{{ $size->additional_price }}">
                        {{ $size->size_name }} (+@rupiah($size->additional_price))
                    </option>
                @endforeach
            </select>
        @endif
    </div>

    <div>
        <label>Item Custom</label>
        <select name="custom_item_id" id="custom_item_id" required>
            <option value="" data-price="0">Pilih Item Custom</option>
            @foreach($customItems as $item)
                <option value="{{ $item->id }}" data-price="{{ $item->base_price }}">
                    {{ $item->name }} (+@rupiah($item->base_price))
                </option>
            @endforeach
        </select>
    </div>

    <div class="mt-3">
        <h4>Total Harga: Rp. <span id="total-price">0</span></h4>
    </div>

    <button type="submit" class="btn btn-primary">Buat Custom Desain</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sizeSelect = document.getElementById('size_id');
    const itemSelect = document.getElementById('custom_item_id');
    const totalPriceElement = document.getElementById('total-price');

    function calculateTotal() {
        const sizePrice = parseFloat(sizeSelect.selectedOptions[0].getAttribute('data-price')) || 0;
        const itemPrice = parseFloat(itemSelect.selectedOptions[0].getAttribute('data-price')) || 0;
        const total = sizePrice + itemPrice;
        totalPriceElement.textContent = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(total);
    }

    sizeSelect.addEventListener('change', calculateTotal);
    itemSelect.addEventListener('change', calculateTotal);
});
</script>
@endsection
