<h1>Produk dalam Kategori: {{ $category->name }}</h1>

<section class="cs-bg" data-src="{{ asset('assets/img/feature_bg.svg') }}" id="pricing">
    <div class="cs-height_95 cs-height_lg_70"></div>
    <div class="container">
        <div class="cs-seciton_heading cs-style1 text-center">
            <div class="cs-section_subtitle wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">Pricing Plan</div>
            <div class="cs-height_10 cs-height_lg_10"></div>
            <h3 class="cs-section_title">The best choice for you</h3>
        </div>
        <div class="cs-height_50 cs-height_lg_40"></div>
        <div class="row">
            @forelse ($products as $product)
                <div class="col-lg-4">
                    <div class="cs-pricing_table cs-style1">
                        <div class="cs-pricing_head">
                            <div class="cs-pricing_heading">
                                <div class="cs-pricing_icon cs-center">
                                    <img src="{{ asset('assets/img/icons/pricing_icon_1.svg') }}" alt="Icon">
                                </div>
                                <h2 class="cs-pricing_title cs-m0">{{ $product->title }}</h2>
                            </div>
                            <div class="cs-price cs-primary_font">
                                <b class="cs-accent_color">@rupiah($product->price)</b>
                            </div>
                            <div class="cs-pricing_lable">Special Offer</div>
                        </div>
                        <div class="cs-pricing_body">
                            <div class="description">
                                {!! $product->description !!}
                            </div>
                        </div>
                        <div class="cs-pricing_btn">
                            <a href="{{ route('cart.create', $product->id) }}" class="cs-btn cs-size_md">
                                <span>Add to Cart</span>
                            </a>
                        </div>
                    </div>
                    <div class="cs-height_25 cs-height_lg_25"></div>
                </div>
            @empty
                <p class="text-center">Tidak ada produk dalam kategori ini.</p>
            @endforelse
        </div>
        <div class="cs-height_75 cs-height_lg_45"></div>
    </div>
</section>
