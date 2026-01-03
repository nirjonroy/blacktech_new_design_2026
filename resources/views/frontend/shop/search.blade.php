@extends('frontend.app')
@section('title', 'DC-Phone-Repair-Home')
@push('css')

@endpush
@section('seos')
    @php
        $SeoSettings = DB::table('seo_settings')->where('id', 1)->first();
        $siteName = $SeoSettings->site_name ?? config('app.name', 'Blacktech');
        $title = $SeoSettings->meta_title ?? $SeoSettings->seo_title ?? $siteName;
        $desc = \Illuminate\Support\Str::limit(strip_tags($SeoSettings->meta_description ?? $SeoSettings->seo_description ?? ''), 180);
        $url = url()->current();
        $fallbackLogo = siteInfo()->logo ?? null;
        $metaImage = $SeoSettings->meta_image ? asset($SeoSettings->meta_image) : ($fallbackLogo ? asset($fallbackLogo) : asset('images/og-default.jpg'));
        $author = $SeoSettings->author ?? 'Blacktech';
        $publisher = $SeoSettings->publisher ?? $siteName;
        $copyright = $SeoSettings->copyright ?? null;
        $keywords = $SeoSettings->keywords ?? null;
    @endphp

    <meta charset="UTF-8">

    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <meta name="title" content="{{ $title }}">

    <meta name="description" content="{{ $desc }}">
    <meta name="author" content="{{ $author }}">
    @if ($publisher)
    <meta name="publisher" content="{{ $publisher }}">
    @endif
    @if ($copyright)
    <meta name="copyright" content="{{ $copyright }}">
    @endif
    @if ($keywords)
    <meta name="keywords" content="{{ $keywords }}">
    @endif
    <link rel="canonical" href="{{ $url }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $desc }}">
    <meta property="og:url" content="{{ $url }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:image" content="{{ $metaImage }}">

    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">
    <meta property="article:modified_time" content="{{ optional($SeoSettings->updated_at)->toIso8601String() ?? now()->toIso8601String() }}">
    @if ($publisher)
    <meta property="article:publisher" content="{{ $publisher }}">
    @endif
    @if ($author)
    <meta property="article:author" content="{{ $author }}">
    @endif
    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="{{ $url }}">
    <meta name="twitter:image" content="{{ $metaImage }}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
@endsection
@section('content')
<div class="stricky-header stricked-menu main-menu">
    <div class="sticky-header__content"></div>
    <!-- /.sticky-header__content -->
</div>
<!-- /.stricky-header -->


<!--Services One Start-->
<section class="services-one">
    <div class="services-one-shape-1 float-bob-x">
        <img src="{{asset('frontend/assets/images/shapes/services-one-shape-1.png')}}" alt="">
    </div>
    <div class="services-one-shape-2 float-bob-y">
        <img src="{{asset('frontend/assets/images/shapes/services-one-shape-2.png')}}" alt="">
    </div>
    <div class="container">
        <div class="section-title section-title--two text-center">
            <span class="section-title__tagline">OUR SERVICES</span>
            <h2 class="section-title__title">Our Efficient Solution</h2>
            <p class="section-title__text">DC Phone Repair</p>
        </div>
        <div class="row">
            @foreach($services as $key=>$product)
            <!--Services One Single Start-->
            <div class="col-xl-3 col-lg-3 wow fadeInUp" data-wow-delay="100ms">
                <div class="services-one__single">
                    <div class="services-one__img">
                        <img src="{{asset($product->thumb_image)}}" alt="">

                    </div>
                    <div class="services-one__content">
                        <h3 class="services-one__title"><a href="services-details.html">{{$product->name}}</a></h3>
                        {{-- <p class="services-one__text">Black Tech</p> --}}
                        <div class="services-one__btn-box">
                            <a href="{{route('front.repair', $product->slug)}}" class="thm-btn services-one__btn">Repair Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!--Services One Single Start-->
            @endforeach
        </div>
    </div>
</section>
<!--Services One End-->








<!--Contact One Start-->
<section class="contact-one">
    <div class="contact-one-bg jarallax" data-jarallax data-speed="0.2" data-imgPosition="50% 0%" style="background-image: url({{asset('frontend/assets/images/backgrounds/contact-one-bg.jpg')}});">
    </div>
    <div class="container">
        <div class="section-title section-title--two text-center">
            <span class="section-title__tagline">Contact Us</span>
            <h2 class="section-title__title">Let Us Know Or Call Us At</h2>
            <p class=" section-title__text"></p>
        </div>
        <div class="contact-one__form-box">
            <form action="{{route('front.direct-message')}}" class="contact-one__form contact-form-validated" method="post" novalidate="novalidate">
                <div class="row">
                    <div class="col-xl-4 col-lg-4">
                        <div class="contact-form__input-box">
                            <input type="text" placeholder="Your Name" name="name">
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4">
                        <div class="contact-form__input-box">
                            <input type="email" placeholder="Email Address" name="email">
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4">
                        <div class="contact-form__input-box">
                            <input type="text" placeholder="Phone Number" name="phone">
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4">
                        <div class="contact-form__input-box">
                            <input type="text" placeholder="address" name="address">
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4">
                        <div class="contact-form__input-box">
                            <input type="text" placeholder="Subject" name="Subject">
                        </div>
                    </div>



                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12">
                        <div class="contact-form__input-box text-message-box">
                            <textarea name="message" placeholder="Message"></textarea>
                        </div>
                        <div class="contact-form__btn-box">
                            <button type="submit" class="thm-btn contact-form__btn">Send Message</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!--Contact One End-->

<!--Blog One Start-->

<!--Blog One End-->

@php
$phone = DB::table('informations')->first();
@endphp
<!--Newsletter One Start-->
<section class="newsletter-one">
    <div class="newsletter-one-bg jarallax" data-jarallax data-speed="0.2" data-imgPosition="50% 0%" style="background-image: url(assets/images/backgrounds/newsletter-one-bg.jpg);"></div>
    <div class="container">
        <div class="section-title section-title--two text-center">
            <span class="section-title__tagline">Contact Us</span>
            <h2 class="section-title__title">Let Us Know Or Call Us At</h2>
            <a href="tel:+{{$phone->owner_phone}}" class="btn btn-warning">Call Now</a>
            {{-- <p class=" section-title__text">Duis aute irure dolor in repreh enderit in volup tate velit esse cillum dolore <br> eu fugiat nulla dolor atur with Lorem ipsum is simply </p> --}}
        </div>
        {{-- <form class="newsletter-one__form">
            <div class="newsletter-one__input-box">
                <input type="email" placeholder="Your Email" name="email">
                <button type="submit" class="thm-btn newsletter-one__btn">Subscribe Now</button>
            </div>
        </form> --}}
    </div>
</section>
<!--Newsletter One End-->


@endsection
