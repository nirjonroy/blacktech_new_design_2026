@extends('frontend.app')

@push('css')

@endpush
@php
    $SeoSettings = DB::table('seo_settings')->where('page_name', 'Service')->first();
    $siteName = optional($SeoSettings)->site_name ?? config('app.name', 'Blacktech');
    $title = optional($SeoSettings)->meta_title ?? optional($SeoSettings)->seo_title ?? $siteName;
    $descriptionSource = optional($SeoSettings)->meta_description ?? optional($SeoSettings)->seo_description ?? '';
    $desc = \Illuminate\Support\Str::limit(strip_tags($descriptionSource), 180);
    $url = url()->current();
    $fallbackLogo = siteInfo()->logo ?? null;
    $firstItemImage = isset($all_service) && $all_service->count() ? optional($all_service->first())->image : null;
    $collectionImage = $firstItemImage ? asset($firstItemImage) : null;
    $metaImagePath = optional($SeoSettings)->meta_image;
    $metaImage = $metaImagePath
        ? asset($metaImagePath)
        : ($collectionImage ?? ($fallbackLogo ? asset($fallbackLogo) : asset('images/og-default.jpg')));
    $author = optional($SeoSettings)->author ?? 'Blacktech';
    $publisher = optional($SeoSettings)->publisher ?? $siteName;
    $copyright = optional($SeoSettings)->copyright;
    $keywords = optional($SeoSettings)->keywords;
    $updatedIso = optional(optional($SeoSettings)->updated_at ? \Illuminate\Support\Carbon::parse($SeoSettings->updated_at) : null)->toIso8601String() ?? now()->toIso8601String();
@endphp
@section('title', $title)
@section('seos')


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

<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $desc }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:image" content="{{ $metaImage }}">
<meta property="og:image:secure_url" content="{{ $metaImage }}">
<meta property="og:image:alt" content="{{ $title }}">
<meta property="og:updated_time" content="{{ $updatedIso }}">
<meta property="og:locale" content="en_US">
@if ($publisher)
<meta property="article:publisher" content="{{ $publisher }}">
@endif
@if ($author)
<meta property="article:author" content="{{ $author }}">
@endif

<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $desc }}">
<meta name="twitter:url" content="{{ $url }}">
<meta name="twitter:image" content="{{ $metaImage }}">
@endsection
@section('content')
<div class="offcanvas-overlay"></div>
    <!-- offcanvas-overlay -->
    <!-- header end -->


    <!-- header end -->

    <!-- page-banner start -->
    <section class="page-banner pt-xs-60 pt-sm-80 overflow-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-banner__content mb-xs-10 mb-sm-15 mb-md-15 mb-20">
                        <div class="transparent-text">Explore our</div>
                        <div class="page-title">
                            <h2 class="display-4 text-center"> Service </h2>
                        </div>
                    </div>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('front.home')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Explore Service</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-md-6">
                    <div class="page-banner__media mt-xs-30 mt-sm-40">
                        <img src="{{asset('frontend/assets/img/page-banner/page-banner-start.svg')}}" class="img-fluid start" alt="">
                        <img src="{{asset('frontend/assets/img/page-banner/page-banner.jpg" class="img-fluid')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- page-banner end -->
    <!-- our projects  -->
    <div class="container">
    <div class="text-content-our-projects p-4">
        <h1 class="text-uppercase text-center display-1 fs-2 fw-bold">{{ $title }}</h1>
    </div>
    <div class="container projects-cards">
        <div class="row mb-minus-30">
            @foreach ($all_service  as $item)
             @php
                        $serviceSlug = optional($item->category)->slug ?? $item->slug;
                        $serviceUrl = $serviceSlug ? route('front.shop', $serviceSlug) : 'javascript:void(0);';
                    @endphp
            <div class="col-lg-4 col-md-6">
                <div class="similar-work__item mb-30 d-flex justify-content-between flex-column wow fadeInUp" data-wow-delay=".3s">
                    <div class="top d-flex align-items-center">

                        <h4 class="title color-secondary"><a href="{{ $serviceUrl }}">{{$item->name}} </a></h4>
                    </div>

                   
                    <div class="bottom">
                        <div class="media overflow-hidden">
                            <a href="{{ $serviceUrl }}">
                                <img src="{{ asset($item->image) }}" class="img-fluid" alt="">
                            </a>
                            
                        </div>

                        <div class="text pt-30 pr-30 pb-30 pl-30 pt-sm-20 pt-xs-15 pr-sm-20 pr-xs-15 pb-sm-20 pb-xs-15 pl-sm-20 pl-xs-15 font-la">
                            {{-- <p>Maximize your online presence and outrank your competitors with our tailored SEO services! 🚀</p> --}}
                        </div>

                        <a href="{{ $serviceUrl }}" class="theme-btn text-center fw-600 btn-yellow">Discover More <i class="fas fa-long-arrow-alt-right"></i></a>
                    </div>
                </div>
            </div>
            @endforeach



        </div>

    </div>
    </div>


    <!-- our-company start -->

    <!-- our-company end -->



    <!-- company-skill start -->

    <!-- company-skill end -->

    <!-- counter-area start -->

    <!-- counter-area end -->
@endsection
