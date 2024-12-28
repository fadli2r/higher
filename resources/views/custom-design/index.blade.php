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

    /* Progress Bar */
    .progress {
        margin: 20px auto;
        padding: 0;
        width: 90%;
        height: 30px;
        overflow: hidden;
        background: #e5e5e5;
        border-radius: 6px;
    }

    .bar {
        position: relative;
        float: left;
        min-width: 1%;
        height: 100%;
        background: cornflowerblue;
    }

    .percent {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        margin: 0;
        font-family: tahoma, arial, helvetica;
        font-size: 12px;
        color: white;
    }
</style>

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Custom Desain</h2>

    <form action="{{ route('custom-design.store') }}" method="POST" enctype="multipart/form-data" id="customDesignForm" class="bg-light p-4 rounded shadow">
        @csrf

        <div class="mb-3">
            <label for="projectName" class="form-label">Nama Proyek</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="whatsapp">No. WhatsApp Anda</label>
            <input type="text" name="whatsapp" id="whatsapp" class="form-control" required>
        </div>

        <!-- Nama PT atau Brand -->
        <div class="mb-3">
            <label for="brand_name">Nama PT atau Brand</label>
            <input type="text" name="brand_name" id="brand_name" class="form-control">
        </div>

        <!-- Rekomendasi Warna -->
        <div class="mb-3">
            <label for="color_recommendation">Rekomendasi Warna</label>
            <input type="text" name="color_recommendation" id="color_recommendation" class="form-control">
        </div>

        <!-- Arahan Lainnya -->
        <div class="mb-3">
            <label for="direction">Arahan Lainnya</label>
            <textarea name="direction" id="direction" class="form-control"></textarea>
        </div>

        <!-- Referensi Desain -->
        <div class="mb-3">
            <label for="design_reference">Referensi Desain (opsional)</label>
            <input type="file" name="design_reference" id="design_reference" class="form-control" accept=".jpg,.png,.pdf,.ai,.eps,.cdr">
        </div>
        <div class="mb-3">
            <label for="custom_item_id" class="form-label">Ingin Custom Design apa?</label>
            <select name="custom_item_id" id="custom_item_id" class="form-select" required>
                <option value="" data-price="0">Pilih Item Custom</option>
                @foreach($customItems as $item)
                    <option value="{{ $item->id }}" data-price="{{ $item->base_price }}">
                        {{ $item->name }} (+@rupiah($item->base_price))
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="size_id" class="form-label">Ukuran</label>
            @if($customSizes->isEmpty())
                <p>No sizes available</p>
            @else
                <select name="size_id" id="size_id" class="form-select" required>
                    <option value="" data-price="0">Pilih Ukuran</option>
                    @foreach($customSizes as $size)
                        <option value="{{ $size->id }}" data-price="{{ $size->additional_price }}">
                            {{ $size->size_name }} (+@rupiah($size->additional_price))
                        </option>
                    @endforeach
                </select>
            @endif
        </div>



        <div class="mt-3">
            <h4>Total Harga: Rp. <span id="total-price">0</span></h4>
        </div>

        <button type="submit" class="btn btn-primary w-100">Buat Custom Desain</button>
    </form>
</div>

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
