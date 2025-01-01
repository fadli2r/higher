@extends('layout.layout')

@section('content')
<!-- Start Hero -->
<div id="home">
    <div class="cs-height_80 cs-height_lg_80"></div>
    <section class="cs-hero cs-style1 cs-bg" data-src="{{ asset('assets/img/hero_bg.svg') }}">
        <div class="container">
            <div class="cs-hero_text">
                <h1 class="cs-hero_title">Jasa Kami</h1>
                <div class="cs-hero_subtitle">Kami menyediakan berbagai jasa untuk kebutuhan digitalmu </div>
            </div>
            <div class="cs-hero_shapes">
                <div class="cs-shape cs-shape_position1">
                    <img src="{{ asset('assets/img/shape/shape_1.svg') }}" alt="Shape">
                </div>
                <div class="cs-shape cs-shape_position2">
                    <img src="{{ asset('assets/img/shape/shape_2.svg') }}" alt="Shape">
                </div>
                <div class="cs-shape cs-shape_position3">
                    <img src="{{ asset('assets/img/shape/shape_3.svg') }}" alt="Shape">
                </div>
                <div class="cs-shape cs-shape_position4">
                    <img src="{{ asset('assets/img/shape/shape_4.svg') }}" alt="Shape">
                </div>
                <div class="cs-shape cs-shape_position5">
                    <img src="{{ asset('assets/img/shape/shape_5.svg') }}" alt="Shape">
                </div>
                <div class="cs-shape cs-shape_position6">
                    <img src="{{ asset('assets/img/shape/shape_6.svg') }}" alt="Shape">
                </div>
            </div>
        </div>
    </section>
</div>
<!-- End Hero -->
<section class="cs-bg" data-src="{{ asset('assets/img/feature_bg.svg') }}">
    <div class="cs-height_135 cs-height_lg_0"></div>
    <div id="feature">
        <div class="container">
            <div class="cs-seciton_heading cs-style1 text-center">
                <div class="cs-section_subtitle wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">Semua Kategori</div>
                <div class="cs-height_10 cs-height_lg_10"></div>
                <h3 class="cs-section_title">Pilih Jasa</h3>
            </div>
            <div class="cs-height_50 cs-height_lg_40"></div>
            <div class="row">
                @foreach ($categories as $category)
                    <div class="col-xl-4 col-md-6">
                        <div class="cs-iconbox cs-style1 cs-type1">
                            <div class="cs-iconbox_icon cs-center">
                                <img src="{{ asset('assets/img/icons/icon_box_' . ($loop->index + 5) . '.svg') }}" alt="Icon">
                            </div>
                            <div class="cs-iconbox_in">
                                <a href="{{ route('products.category', $category->id) }}">
                                    <h3 class="cs-iconbox_title">{{ $category->name }}</h3>
                                </a>
                                <div class="cs-iconbox_subtitle">Lihat produk dalam kategori ini</div>
                            </div>
                        </div>
                        <div class="cs-height_25 cs-height_lg_25"></div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="cs-height_75 cs-height_lg_45"></div>
    </div>
    <div class="cs-height_95 cs-height_lg_70"></div>

</section>

@endsection



