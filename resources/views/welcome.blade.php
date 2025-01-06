@extends('layout.layout')

@section('content')
    <!-- Start Hero -->
    <div id="home">
        <div class="cs-height_80 cs-height_lg_80"></div>
        <section class="cs-hero cs-style1 cs-bg" data-src="{{ asset('assets/img/hero_bg.svg') }}">
            <div class="container">
                <div class="cs-hero_img">
                    <div class=" cs-bg" data-src="{{ asset('assets/img/bg-desain.webp') }}"></div>
                    <img src="{{ asset('assets/img/bg-desain.webp') }}" alt="Hero Image" class="wow fadeInRight" data-wow-duration="1s" data-wow-delay="0.4s">
                </div>
                <div class="cs-hero_text">
                    <div class="cs-hero_secondary_title">Free Forever For All Users.</div>
                    <h1 class="cs-hero_title">Digital Product <br>Design Custom</h1>
                    <div class="cs-hero_subtitle">You may start selling in a matter of minutes and easy to <br>use. Appropriate for all devices.</div>
                    <a href="{{ route('custom-design.index') }}" class="cs-btn"><span>Custom</span></a>
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
  <!-- Start Main Feature -->
  <section class="cs-bg" data-src="assets/img/feature_bg.svg">
    <div class="cs-height_95 cs-height_lg_70"></div>
    <div class="container">
      <div class="cs-seciton_heading cs-style1 text-center">
        <div class="cs-section_subtitle wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">Office & Inventory</div>
        <div class="cs-height_10 cs-height_lg_10"></div>
        <h3 class="cs-section_title">Our best inventory</h3>
      </div>
      <div class="cs-height_50 cs-height_lg_40"></div>
      <div class="row">
        <div class="col-md-6 col-xl-3">
          <div class="cs-height_25 cs-height_lg_0"></div>
          <div class="cs-iconbox cs-style1">
            <div class="cs-iconbox_icon cs-center">
              <img src="assets/img/icons/icon_box_1.svg" alt="Icon">
            </div>
            <div class="cs-iconbox_in">
              <div class="cs-iconbox_number cs-primary_font">01</div>
              <h3 class="cs-iconbox_title">Konsultasi</h3>
              <div class="cs-iconbox_subtitle">Buka Tiket untuk konsultasi</div>
            </div>
          </div>
          <div class="cs-height_25 cs-height_lg_25"></div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="cs-iconbox cs-style1">
            <div class="cs-iconbox_icon cs-center">
              <img src="assets/img/icons/icon_box_2.svg" alt="Icon">
            </div>
            <div class="cs-iconbox_in">
              <div class="cs-iconbox_number cs-primary_font">02</div>
              <h3 class="cs-iconbox_title">Pilih layanan
            </h3>
              <div class="cs-iconbox_subtitle">Pilih Layanan sesuai dengan kebutuhan</div>
            </div>
          </div>
          <div class="cs-height_25 cs-height_lg_25"></div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="cs-height_25 cs-height_lg_0"></div>
          <div class="cs-iconbox cs-style1">
            <div class="cs-iconbox_icon cs-center">
              <img src="assets/img/icons/icon_box_3.svg" alt="Icon">
            </div>
            <div class="cs-iconbox_in">
              <div class="cs-iconbox_number cs-primary_font">03</div>
              <h3 class="cs-iconbox_title">Pembayaran</h3>
              <div class="cs-iconbox_subtitle">Pakai apa saja bisa</div>
            </div>
          </div>
          <div class="cs-height_25 cs-height_lg_25"></div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="cs-iconbox cs-style1">
            <div class="cs-iconbox_icon cs-center">
              <img src="assets/img/icons/icon_box_4.svg" alt="Icon">
            </div>
            <div class="cs-iconbox_in">
              <div class="cs-iconbox_number cs-primary_font">04</div>
              <h3 class="cs-iconbox_title">Proses</h3>
              <div class="cs-iconbox_subtitle">Pantau Proses dengan sekali klik</div>
            </div>
          </div>
          <div class="cs-height_25 cs-height_lg_25"></div>
        </div>
      </div>
      <div class="cs-height_75 cs-height_lg_45"></div>
    </div>
  </section>
  <!-- End Main Feature -->
      <!-- Start About -->
  <section id="about" class="cs-gradient_bg_1">
    <div class="cs-height_100 cs-height_lg_70"></div>
    <div class="container">
      <div class="row align-items-center flex-column-reverse-lg">
        <div class="col-xl-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.3s">
          <div class="cs-left_full_width cs-space110">
            <div class="cs-left_sided_img">
              <img src="https://originfamous.cloud/images/assets/how-p.png" style="max-width: 500px; width:100%" alt="About">
            </div>
          </div>
        </div>
        <div class="col-xl-6">
          <div class="cs-height_0 cs-height_lg_40"></div>
          <div class="cs-seciton_heading cs-style1">
            <div class="cs-section_subtitle">Famous Team
            </div>
            <div class="cs-height_10 cs-height_lg_10"></div>
            <h3 class="cs-section_title">Konsultasi bisnis Gratis khusus UMKM
            </h3>
          </div>
          <div class="cs-height_20 cs-height_lg_20"></div>
          <p>
            #UMKMBisa adalah salah satu pelopor Konsultan Digital Marketing Agency di indonesia yang menjadi prioritas Generasi Digital Kreatif Indonesia.
          </p>
          <div class="cs-height_15 cs-height_lg_15"></div>
          <div class="cs-list_1_wrap">
            <ul class="cs-list cs-style1 cs-mp0">
              <li>
                <span class="cs-list_icon">
                  <img src="assets/img/icons/tick.svg" alt="Tick">
                </span>
                <div class="cs-list_right">
                  <h3>Konsultasikan bisnismu secara Gratis</h3>
                </div>
              </li>
              <li>
                <span class="cs-list_icon">
                  <img src="assets/img/icons/tick.svg" alt="Tick">
                </span>
                <div class="cs-list_right">
                  <h3>Menangani semua kebutuhan digital bisnismu
                </h3>
                </div>
              </li>
              <li>
                <span class="cs-list_icon">
                  <img src="assets/img/icons/tick.svg" alt="Tick">
                </span>
                <div class="cs-list_right">
                  <h3>Prioritas kami bukan harga, tapi Hasil dan Kepercayaan
                </h3>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="cs-height_100 cs-height_lg_70"></div>
    <div class="cs-height_135 cs-height_lg_0"></div>
  </section>
  <!-- End About -->

  <!-- Start Fun Fact -->
  <div class="container-fluid">
    <div class="cs-funfact_1_wrap cs-type1">
      <div class="cs-funfact cs-style1">
        <div class="cs-funfact_icon cs-center"><img src="assets/img/icons/funfact_icon_1.svg" alt="Icon"></div>
        <div class="cs-funfact_right">
          <div class="cs-funfact_number cs-primary_font"><span data-count-to="100" class="odometer"></span>JT+</div>
          <h2 class="cs-funfact_title">Total Penjualan</h2>
        </div>
      </div>
      <div class="cs-funfact cs-style1">
        <div class="cs-funfact_icon cs-center"><img src="assets/img/icons/funfact_icon_2.svg" alt="Icon"></div>
        <div class="cs-funfact_right">
          <div class="cs-funfact_number cs-primary_font"><span data-count-to="92" class="odometer"></span>k</div>
          <h2 class="cs-funfact_title">Total Customer</h2>
        </div>
      </div>
      <div class="cs-funfact cs-style1">
        <div class="cs-funfact_icon cs-center"><img src="assets/img/icons/funfact_icon_3.svg" alt="Icon"></div>
        <div class="cs-funfact_right">
          <div class="cs-funfact_number cs-primary_font"><span data-count-to="5" class="odometer"></span>k</div>
          <h2 class="cs-funfact_title">Total Ulasan</h2>
        </div>
      </div>
      <div class="cs-funfact cs-style1">
        <div class="cs-funfact_icon cs-center"><img src="assets/img/icons/funfact_icon_4.svg" alt="Icon"></div>
        <div class="cs-funfact_right">
          <div class="cs-funfact_number cs-primary_font"><span data-count-to="20" class="odometer"></span>+</div>
          <h2 class="cs-funfact_title">Sertifikat</h2>
        </div>
      </div>
    </div>
  </div>
  <!-- End Fun Fact -->

    <!-- Include Category Partial -->
    @include('partials.category', ['categories' => $categories])
      <!-- Start FAQ -->
  <section id="faq" class="cs-gradient_bg_1">
    <div class="cs-height_95 cs-height_lg_70"></div>
    <div class="cs-seciton_heading cs-style1 text-center">
      <div class="cs-section_subtitle wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">POS FAQ</div>
      <div class="cs-height_10 cs-height_lg_10"></div>
      <h3 class="cs-section_title">Pertanyaan Umum</h3>
    </div>
    <div class="cs-height_50 cs-height_lg_40"></div>
    <div class="container">
      <div class="row align-items-center flex-column-reverse-lg">
        <div class="col-xl-6 wow fadeInLeft" data-wow-duration="1s" data-wow-delay="0.4s">
          <div class="cs-left_full_width cs-space110">
            <div class="cs-left_sided_img">
              <img src="assets/img/faq.jpg" style="max-width: 500px" alt="About">
            </div>
          </div>
          <div class="cs-height_0 cs-height_lg_40"></div>
        </div>
        <div class="col-xl-6">
            <div class="cs-accordians cs-style1 wow fadeIn" data-wow-duration="1s" data-wow-delay="0.4s">
                @foreach ($faqs as $index => $faq)
                <div class="cs-accordian cs-white_bg {{ $index === 0 ? 'active' : '' }}">
                    <div class="cs-accordian_head">
                        <h2 class="cs-accordian_title"><span>Q{{ $index + 1 }}.</span> {{ $faq->question }}</h2>
                        <span class="cs-accordian_toggle">
                            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 -7.36618e-07C12.0333 -8.82307e-07 9.13319 0.879733 6.66645 2.52795C4.19971 4.17617 2.27713 6.51885 1.14181 9.25975C0.00649787 12.0006 -0.290551 15.0166 0.288226 17.9264C0.867005 20.8361 2.29562 23.5088 4.3934 25.6066C6.49119 27.7044 9.16393 29.133 12.0736 29.7118C14.9834 30.2905 17.9994 29.9935 20.7403 28.8582C23.4811 27.7229 25.8238 25.8003 27.472 23.3335C29.1203 20.8668 30 17.9667 30 15C29.9957 11.0231 28.414 7.21026 25.6019 4.39815C22.7897 1.58603 18.9769 0.00430081 15 -7.36618e-07V-7.36618e-07ZM15 20C14.085 20.0009 13.2014 19.6665 12.5163 19.06C12.1075 18.6962 11.72 18.3425 11.4663 18.0887L7.875 14.5587C7.75017 14.4457 7.64946 14.3086 7.57892 14.1557C7.50838 14.0028 7.46947 13.8372 7.46452 13.6689C7.45957 13.5005 7.48869 13.3329 7.55012 13.1762C7.61155 13.0194 7.70402 12.8766 7.822 12.7564C7.93998 12.6362 8.08102 12.5412 8.23667 12.4769C8.3923 12.4125 8.55934 12.3804 8.72773 12.3822C8.89612 12.3841 9.0624 12.4199 9.21659 12.4876C9.37078 12.5553 9.5097 12.6535 9.62501 12.7762L13.225 16.3125C13.46 16.5462 13.81 16.8637 14.1738 17.1875C14.4021 17.3889 14.6961 17.5001 15.0006 17.5001C15.3051 17.5001 15.5991 17.3889 15.8275 17.1875C16.19 16.865 16.54 16.5475 16.7675 16.3212L20.375 12.7762C20.4903 12.6535 20.6292 12.5553 20.7834 12.4876C20.9376 12.4199 21.1039 12.3841 21.2723 12.3822C21.4407 12.3804 21.6077 12.4125 21.7633 12.4769C21.919 12.5412 22.06 12.6362 22.178 12.7564C22.296 12.8766 22.3885 13.0194 22.4499 13.1762C22.5113 13.333 22.5404 13.5005 22.5355 13.6689C22.5305 13.8372 22.4916 14.0028 22.4211 14.1557C22.3505 14.3086 22.2498 14.4457 22.125 14.5587L18.5263 18.095C18.2763 18.345 17.8925 18.695 17.485 19.0562C16.8003 19.6647 15.916 20.0006 15 20Z" fill="currentColor"/>
                            </svg>
                        </span>
                    </div>
                    <div class="cs-accordian-body">
                        {{ $faq->answer }}
                    </div>
                </div>
                <div class="cs-height_25 cs-height_lg_25"></div>
                @endforeach
            </div>
        </div>
      </div>
    </div>
    <div class="cs-height_100 cs-height_lg_70"></div>
  </section>
  <!-- End FAQ -->
    <!-- Start Testimonials Section -->
<section class="cs-gradient_bg_1">
    <div class="cs-height_95 cs-height_lg_70"></div>
    <div class="container">
        <div class="cs-seciton_heading cs-style1 text-center">
            <div class="cs-section_subtitle wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">Testimonials</div>
            <div class="cs-height_10 cs-height_lg_10"></div>
            <h3 class="cs-section_title">What our client’s say</h3>
        </div>
        <div class="cs-height_50 cs-height_lg_40"></div>
        <div class="cs-slider cs-style1 cs-gap-24">
            <div class="cs-slider_container" data-autoplay="0" data-loop="1" data-speed="600" data-fade-slide="0" data-slides-per-view="responsive" data-xs-slides="1" data-sm-slides="2" data-md-slides="3" data-lg-slides="3" data-add-slides="3">
                <div class="cs-slider_wrapper">
                    @foreach($testimonials as $testimonial)
                    <div class="cs-slide">
                        <div class="cs-testimonial cs-style1">
                            <div class="cs-testimonial_text">
                                {{ $testimonial->comment }}
                            </div>
                            <div class="cs-testimonial_meta">
                                <div class="cs-avatar">
                                    <img src="{{ $testimonial->user->avatar_url ?? 'assets/img/user_ava.jpg' }}" alt="Avatar">
                                    <div class="cs-quote cs-center">
                                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 6h-5v7h5v11l7-11h-5z"/>
                                            <path d="M20 6h-5v7h5v11l7-11h-5z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="cs-testimonial_meta_right">
                                    <h3>{{ $testimonial->user->name }}</h3>
                                    <p>{{ $testimonial->product->title ?? 'Customer' }}</p>
                                    <div class="cs-review" data-review="{{ $testimonial->rating }}">
                                        <img src="assets/img/icons/stars.svg" alt="Star">
                                        <div class="cs-review_in">
                                            <img src="assets/img/icons/stars.svg" alt="Star">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- .cs-slide -->
                    @endforeach
                </div>
            </div><!-- .cs-slider_container -->
            <div class="cs-pagination cs-style1"></div>
        </div><!-- .cs-slider -->
    </div>
    <div class="cs-height_100 cs-height_lg_70"></div>
</section>
<!-- End Testimonials Section -->
  <!-- Start Contact Section -->
  <section class="cs-gradient_bg_1" id="contact">
    <div class="cs-height_95 cs-height_lg_70"></div>
    <div class="container">
      <div class="row">
        <div class="col-xl-5 col-lg-8">
          <div class="cs-seciton_heading cs-style1">
            <div class="cs-section_subtitle wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">Hubungi Kami</div>
            <div class="cs-height_10 cs-height_lg_10"></div>
            <h3 class="cs-section_title">Ada pertanyaan yang detail?</h3>
          </div>
          <div class="cs-height_20 cs-height_lg_20"></div>
          <p>
Konsultasi bersama kami, gratis          </p>
          <div class="cs-height_15 cs-height_lg_15"></div>
          <div class="cs-iconbox cs-style3">
            <div class="cs-iconbox_icon">
              <img src="assets/img/icons/contact_icon_1.svg" alt="Icon">
            </div>
            <div class="cs-iconbox_right">
              <h2 class="cs-iconbox_title">Address</h2>
              <div class="cs-iconbox_subtitle">Babadan Rukun 07/31 A</div>
            </div>
          </div>
          <div class="cs-height_30 cs-height_lg_30"></div>
          <div class="cs-iconbox cs-style3">
            <div class="cs-iconbox_icon">
              <img src="assets/img/icons/contact_icon_2.svg" alt="Icon">
            </div>
            <div class="cs-iconbox_right">
              <h2 class="cs-iconbox_title">Contract Number</h2>
              <div class="cs-iconbox_subtitle">+62-113-651-127</div>
            </div>
          </div>
          <div class="cs-height_30 cs-height_lg_30"></div>
          <div class="cs-iconbox cs-style3">
            <div class="cs-iconbox_icon">
              <img src="assets/img/icons/contact_icon_3.svg" alt="Icon">
            </div>
            <div class="cs-iconbox_right">
              <h2 class="cs-iconbox_title">Email Address</h2>
              <div class="cs-iconbox_subtitle">originfamousid@gmail.com</div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 offset-xl-1">
          <div class="cs-height_40 cs-height_lg_40"></div>
          <form class="cs-contact_form" id="contactForm">
            <h2 class="cs-contact_form_title">Kontak kami sekarang:</h2>
            <div class="row">
                <div class="col-lg-6">
                    <input type="text" id="name" class="cs-form_field" placeholder="Name" required>
                    <div class="cs-height_25 cs-height_lg_25"></div>
                </div>
                <div class="col-lg-6">
                    <input type="email" id="mael" class="cs-form_field" placeholder="Email address" required>
                    <div class="cs-height_25 cs-height_lg_25"></div>
                </div>
                <div class="col-lg-12">
                    <input type="text" id="phone" class="cs-form_field" placeholder="Phone number" required>
                    <div class="cs-height_25 cs-height_lg_25"></div>
                </div>
                <div class="col-lg-12">
                    <textarea id="message" cols="30" rows="5" class="cs-form_field" placeholder="Write your message" required></textarea>
                    <div class="cs-height_25 cs-height_lg_25"></div>
                </div>
                <div class="col-lg-12">
                    <button type="button" id="sendMessage" class="cs-btn cs-size_md"><span>Send Message</span></button>
                </div>
            </div>
        </form>
        </div>
      </div>
    </div>
    <div class="cs-height_95 cs-height_lg_70"></div>
  </section>
  <!-- End Contact Section -->
  <script>
    document.getElementById('sendMessage').addEventListener('click', function () {
        const name = document.getElementById('name').value;
        const email = document.getElementById('mael').value;
        const phone = document.getElementById('phone').value;
        const message = document.getElementById('message').value;

        const whatsappNumber = '628113651127'; // Nomor WhatsApp tujuan tanpa "+" atau "0"
        const whatsappMessage = `Halo, saya ${name}.%0AEmail: ${mael}%0ANomor HP: ${phone}%0APesan:%0A${message}`;

        const whatsappURL = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(whatsappMessage)}`;
        window.open(whatsappURL, '_blank');
    });
</script>
@endsection
