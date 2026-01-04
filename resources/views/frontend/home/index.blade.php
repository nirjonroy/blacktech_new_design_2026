@extends('frontend.app')
@php
    // Prefer passing $SeoSettings from the controller; this is a safe fallback.
    $SeoSettings = $SeoSettings ?? DB::table('seo_settings')->where('id', 1)->first();

    $siteName = $SeoSettings->site_name ?? config('app.name', 'Blacktech');
    $title    = $SeoSettings->meta_title ?: ($SeoSettings->seo_title ?: $siteName);
    $rawDesc  = $SeoSettings->meta_description ?: $SeoSettings->seo_description;
    $desc     = \Illuminate\Support\Str::limit(strip_tags($rawDesc ?? ''), 180);
    $url      = url()->current();

    $fallbackLogo = siteInfo()->logo ?? null;
    $defaultImage = $fallbackLogo ? asset($fallbackLogo) : asset('images/og-default.jpg');
    $ogImage      = $SeoSettings->meta_image ? asset($SeoSettings->meta_image) : $defaultImage;

    $updatedIso = optional($SeoSettings->updated_at)->toIso8601String() ?? now()->toIso8601String();
    $twitter    = $SeoSettings->twitter_site ?? '@blacktech';
    $indexable  = isset($SeoSettings->indexable) ? (bool)$SeoSettings->indexable : true;
    $author     = $SeoSettings->author ?? 'Blacktech';
    $publisher  = $SeoSettings->publisher ?? $siteName;
    $copyright  = $SeoSettings->copyright ?? null;
    $keywords   = $SeoSettings->keywords ?? null;
@endphp
@section('title', $title)
@section('seos')


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $title }}</title>
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
<meta name="robots" content="{{ $indexable ? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' : 'noindex, nofollow' }}">

{{-- Open Graph --}}
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $desc }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:image:secure_url" content="{{ $ogImage }}">
<meta property="og:image:alt" content="{{ $siteName }}">
<meta property="og:updated_time" content="{{ $updatedIso }}">
<meta property="og:locale" content="en_US">
@if ($publisher)
<meta property="article:publisher" content="{{ $publisher }}">
@endif
@if ($author)
<meta property="article:author" content="{{ $author }}">
@endif

{{-- Twitter (logos look best with "summary") --}}
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="{{ $twitter }}">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $desc }}">
<meta name="twitter:url" content="{{ $url }}">
<meta name="twitter:image" content="{{ $ogImage }}">

{{-- CSRF for your AJAX --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
@endsection

@section('content')
<div class="site-content">
    <div class="container-fluid">
        <div class="item-efftect">
            <div class="efftect overflow-hidden"></div>
            <div class="efftect overflow-hidden"></div>
            <div class="efftect overflow-hidden"></div>
            <div class="efftect overflow-hidden"></div>
            <div class="efftect overflow-hidden"></div>
        </div>
    </div>

    <div class="main-banner main-banner-1">
        <div class="owl-carousel banner-carousel" data-items="1" data-nav-dots="false" data-nav-arrow="false" data-autoplay="true" data-space="0" data-sm-items="1" data-md-items="1" data-lg-items="1">
            @forelse($sliders as $slider)
                @php
                    $heroImage = !empty($slider->image) ? asset($slider->image) : asset('frontend/assets/images/banner/banner-01/banner-shape-01.png');
                @endphp
                <div class="item">
                    <div class="banner-inner">
                        <img class="img-fluid banner-bg-one" src="{{ asset('frontend/assets/images/banner/banner-01/banner-bg-01.png') }}" alt="">
                        <h1 class="banner-title">blacktech</h1>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <img class="img-fluid rotate rotate-img" src="{{ $heroImage }}" alt="">
                                </div>
                                <div class="col-md-6 ms-auto">
                                    <div class="banner-content">
                                        <h2>{{ $slider->title_two }}</h2>
                                        <a class="btn btn-effect" href="{{ route('front.contact') }}">
                                            <span>Get A Quote</span>
                                            <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_59_253)"><path d="M19.4854 11.4293L17.0513 12.221C13.1214 13.4993 10.3036 16.9595 9.84784 21.0668C9.49371 16.981 6.71926 13.5081 2.81255 12.2604L0.210283 11.4293" stroke="white" stroke-width="2"/><path d="M9.83594 20.8889L9.83594 0" stroke="white" stroke-width="2"/></g><defs><clipPath id="clip0_59_253"><rect width="21.3333" height="20" fill="white" transform="translate(20) rotate(90)"/></clipPath></defs></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="item">
                    <div class="banner-inner">
                        <img class="img-fluid banner-bg-one" src="{{ asset('frontend/assets/images/banner/banner-01/banner-bg-01.png') }}" alt="">
                        <h1 class="banner-title">blacktech</h1>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <img class="img-fluid rotate rotate-img" src="{{ asset('frontend/assets/images/banner/banner-01/banner-shape-01.png') }}" alt="">
                                </div>
                                <div class="col-md-6 ms-auto">
                                    <div class="banner-content">
                                        <h2>Creative solutions real results</h2>
                                        <a class="btn btn-effect" href="{{ route('front.contact') }}">
                                            <span>Get A Quote</span>
                                            <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_59_253)"><path d="M19.4854 11.4293L17.0513 12.221C13.1214 13.4993 10.3036 16.9595 9.84784 21.0668C9.49371 16.981 6.71926 13.5081 2.81255 12.2604L0.210283 11.4293" stroke="white" stroke-width="2"/><path d="M9.83594 20.8889L9.83594 0" stroke="white" stroke-width="2"/></g><defs><clipPath id="clip0_59_253"><rect width="21.3333" height="20" fill="white" transform="translate(20) rotate(90)"/></clipPath></defs></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="content-wrapper">
        <section class="space-pt">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-lg-7 mb-5 mb-lg-0">
                        <div class="section-title pb-0 pb-lg-4">
                            <span class="sub-title"><img class="img-fluid" src="{{ asset('frontend/assets/images/subtitle-icon.png') }}" alt=""> About Us</span>
                            <h2 class="title">About Us</h2>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <img class="img-fluid" src="{{ asset('frontend/assets/images/about/about-03.jpg') }}" alt="About">
                            </div>
                            <div class="col-sm-8">
                                <div class="ps-lg-3 mt-4 mt-sm-0">
                                    {!! $about->about_us !!}
                                </div>
                                <div class="d-flex justify-content-center mt-5 ms-sm-5 ms-0">
                                    <a class="btn btn-effect" href="{{ route('front.about-us') }}">
                                        <span>About Us</span>
                                        <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_59_254)"><path d="M19.4854 11.4293L17.0513 12.221C13.1214 13.4993 10.3036 16.9595 9.84784 21.0668C9.49371 16.981 6.71926 13.5081 2.81255 12.2604L0.210283 11.4293" stroke="white" stroke-width="2"/><path d="M9.83594 20.8889L9.83594 0" stroke="white" stroke-width="2"/></g><defs><clipPath id="clip0_59_254"><rect width="21.3333" height="20" fill="white" transform="translate(20) rotate(90)"/></clipPath></defs></svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4 mt-sm-5">
                            <div class="col-sm-6">
                                <div class="counter counter-style-1">
                                    <div class="counter-number"><span class="timer mb-0" data-to="87" data-speed="2000">87</span><span class="suffix">%</span></div>
                                    <div class="counter-info"><span class="counter-title">Digital Consultancy</span></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="counter counter-style-1">
                                    <div class="counter-number"><span class="timer mb-0" data-to="79" data-speed="2000">79</span><span class="suffix">%</span></div>
                                    <div class="counter-info"><span class="counter-title">Business Consulting</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <img class="img-fluid ps-lg-5" src="{{ asset($about->video_background) }}" alt="About Blacktech Consultency Service">
                    </div>
                </div>
            </div>
        </section>

        <section class="space-pt bg-black z-index-2 ellipse-top">
            <div class="space-pb ellipse-bottom">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-xxl-5 col-xl-5 mb-5 mb-xl-0">
                            <div class="sticky-top" style="top: 80px;">
                                <div class="section-title">
                                    <h2 class="title">Our Provide Specialized</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-xl-7">
                            @php
                                $serviceIcons = [
                                    'Information-Security.svg',
                                    'Data-Synchronization.svg',
                                    'Event-Processing.svg',
                                    'Process-Automation.svg',
                                    'Mobile-Platforms.svg',
                                    'Content-Management.svg',
                                ];
                                $serviceIndex = 0;
                                $serviceChunks = collect($products)->chunk((int) ceil(max(count($products), 1) / 2));
                            @endphp
                            <div class="row">
                                @foreach ($serviceChunks as $chunkIndex => $serviceChunk)
                                    <div class="col-sm-6">
                                        <div class="services grid-wrapper {{ $chunkIndex === 1 ? 'service-top-space' : '' }}">
                                            @foreach ($serviceChunk as $item)
                                                @php
                                                    $icon = $serviceIcons[$serviceIndex % count($serviceIcons)];
                                                    $serviceIndex++;
                                                @endphp
                                                <div class="service-wrapper service-style-1">
                                                    <div class="service-inner">
                                                        <div class="service-icon">
                                                            <img class="img-fluid" src="{{ asset('frontend/assets/images/svg/services/' . $icon) }}" alt="">
                                                        </div>
                                                        <div class="bg-icon">
                                                            <img class="img-fluid" src="{{ asset('frontend/assets/images/svg/services/color-icon/' . $icon) }}" alt="">
                                                        </div>
                                                        <div class="service-content">
                                                            <h5 class="service-title"><a href="{{ route('front.shop', $item->category->slug) }}">{{ $item->name }}</a></h5>
                                                            <div class="service-links">
                                                                <a class="btn-arrow" href="{{ route('front.shop', $item->category->slug) }}"><svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_923_133)"><path d="M8.70801 0.959961L9.29825 2.7665C10.2512 5.68321 12.8308 7.77453 15.8928 8.1128C12.8468 8.37564 10.2578 10.4348 9.3276 13.3343L8.70801 15.2657" stroke="inherit" stroke-width="2"/><path d="M15.7602 8.12158H0.1875" stroke="inherit" stroke-width="2"/></g><defs><clipPath id="clip0_923_133"><rect width="15.904" height="14.8437" fill="inherit" transform="translate(0.1875 0.578125)"/></clipPath></defs></svg></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row mt-4">
                                <div class="col-12 text-center">
                                    <a class="btn btn-effect" href="{{ route('front.all.service') }}">
                                        <span>More Services</span>
                                        <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_59_255)"><path d="M19.4854 11.4293L17.0513 12.221C13.1214 13.4993 10.3036 16.9595 9.84784 21.0668C9.49371 16.981 6.71926 13.5081 2.81255 12.2604L0.210283 11.4293" stroke="white" stroke-width="2"/><path d="M9.83594 20.8889L9.83594 0" stroke="white" stroke-width="2"/></g><defs><clipPath id="clip0_59_255"><rect width="21.3333" height="20" fill="white" transform="translate(20) rotate(90)"/></clipPath></defs></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="space-ptb z-index-2">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <img class="img-fluid" src="{{ asset('frontend/assets/images/about/about-01.jpg') }}" alt="">
                        <div class="mt-4">
                            <div class="counter counter-style-1">
                                <div class="counter-number"><span class="timer mb-0" data-to="120" data-speed="2000">120</span><span class="suffix">+</span></div>
                                <div class="counter-info"><span class="counter-title">Global Country in Our Company</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="section-title">
                            <span class="sub-title"><img class="img-fluid" src="{{ asset('frontend/assets/images/subtitle-icon.png') }}" alt=""> Why choose us</span>
                            <h2 class="title">Innovative Solutions for Your Business</h2>
                        </div>

                        <div class="description mt-4">
                            <p>Choosing the right digital partner can make all the difference in growing your business online. Our team of experts specializes in website development, SEO, digital marketing, social media management, and graphic design, creating strategies that are tailored to your unique goals.

By combining creativity with technical expertise, we deliver solutions that boost online visibility, attract the right audience, and drive measurable results. Every project is carefully crafted to reflect your brand identity while maximizing engagement and performance.

Partner with us to elevate your digital presence and achieve sustainable growth and lasting success.


</p>
    <br />
    <p style="font-weight:bold">Get in touch today:</p>
  <br />
  <p style="">  Email: admin@blacktechcorp.com </p>
 <br />
 <p style="">  Phone:Aÿƒ?¦+1Aÿ571-478-2431</p>
                        </div>

                        <div class="row mt-4">
                            <div class="col-sm-6">
                                <div class="service-wrapper service-style-1">
                                    <div class="service-inner">
                                        <div class="service-icon">
                                            <img class="img-fluid" src="{{ asset('frontend/assets/images/svg/services/Information-Security.svg') }}" alt="">
                                        </div>
                                        <div class="bg-icon">
                                            <img class="img-fluid" src="{{ asset('frontend/assets/images/svg/services/color-icon/Information-Security.svg') }}" alt="">
                                        </div>
                                        <div class="service-content">
                                            <h5 class="service-title">Business Consulting</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="service-wrapper service-style-1">
                                    <div class="service-inner">
                                        <div class="service-icon">
                                            <img class="img-fluid" src="{{ asset('frontend/assets/images/svg/services/Process-Automation.svg') }}" alt="">
                                        </div>
                                        <div class="bg-icon">
                                            <img class="img-fluid" src="{{ asset('frontend/assets/images/svg/services/color-icon/Process-Automation.svg') }}" alt="">
                                        </div>
                                        <div class="service-content">
                                            <h5 class="service-title">IT Management</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="space-ptb">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="counter counter-style-1">
                            <div class="counter-number"><span class="timer mb-0" data-to="5620" data-speed="2000">5620</span><span class="suffix">+</span></div>
                            <div class="counter-info"><span class="counter-title">Successful Project</span></div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="counter counter-style-1">
                            <div class="counter-number"><span class="timer mb-0" data-to="150" data-speed="2000">150</span><span class="suffix">+</span></div>
                            <div class="counter-info"><span class="counter-title">Expert Consulter</span></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="counter counter-style-1">
                            <div class="counter-number"><span class="timer mb-0" data-to="3225" data-speed="2000">3225</span><span class="suffix">+</span></div>
                            <div class="counter-info"><span class="counter-title">Client Satisfaction</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
