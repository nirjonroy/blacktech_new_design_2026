@extends('frontend.app')
@php
    $siteInfo = siteInfo();
    $siteName = optional($siteInfo)->site_name ?? config('app.name', 'Blacktech');
    $siteLogo = optional($siteInfo)->logo;
    $pageTitle = $customPage->meta_title ?: $customPage->page_name;
    $pageDescription = $customPage->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($customPage->description), 180);
    $pageKeywords = $customPage->meta_keywords;
    $canonical = $customPage->canonical_url ?: url()->current();
    $robots = $customPage->meta_robots ?: 'index, follow';
    $defaultMetaImage = $siteLogo ? asset($siteLogo) : asset('frontend/assets/img/page-banner/page-banner.jpg');
    $metaImage = $customPage->meta_image ? asset($customPage->meta_image) : $defaultMetaImage;
@endphp
@section('title', trim(($pageTitle ? $pageTitle . ' | ' : '') . $siteName))
@push('css')

@endpush
@section('seos')
    <meta charset="UTF-8">
    <meta name="robots" content="{{ $robots }}">
    <meta name="title" content="{{ $pageTitle }}">
    <meta name="description" content="{{ $pageDescription }}">
    @if(!empty($pageKeywords))
        <meta name="keywords" content="{{ $pageKeywords }}">
    @endif
    <link rel="canonical" href="{{ $canonical }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">
    <meta property="article:modified_time" content="{{ optional($customPage->updated_at)->toIso8601String() ?? now()->toIso8601String() }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ $canonical }}">
    <meta name="twitter:image" content="{{ $metaImage }}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
@endsection
@section('content')

    <!-- offcanvas-overlay -->
    <!-- header end -->


    <!-- header end -->

    <!-- page-banner start -->
    <section class="page-banner ">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-banner__content mb-xs-10 mb-sm-15 mb-md-15 mb-20">
                        <div class="transparent-text"> {{$customPage->page_name}} </div>
                        <div class="page-title">
                            @if(!empty($customPage->page_name))

                            <h1> {{$customPage->page_name}}</h1>
                            @endif
                        </div>
                    </div>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('front.home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$customPage->page_name}}</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-md-6">
                    <div class="page-banner__media mt-xs-30 mt-sm-40">
                        <img src="{{ asset('frontend/assets/img/page-banner/page-banner-start.svg') }}" class="img-fluid start" alt="">
                        <img src="{{ asset('frontend/assets/img/page-banner/page-banner.jpg') }}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- page-banner end -->

    <!-- our-company start -->
    <section class="our-company  pt-xs-80 pb-xs-80 pt-sm-100 pb-sm-100 pt-md-100 pb-md-100 pt-120 pb-120 overflow-hidden">
        <div class="container-fluid" style="max-width:1200px">
            <div class="row g-4">
                <div class="col-md-12">
                    @if(!empty($customPage->page_name))

                    <h2 class="my-4 p-2 text-center">{{ $customPage->page_name }}</h2>
                    @endif

                    @if(!empty($customPage->description))
                    <div class="my-4 p-2 wsus__custom_pages">
                        {!! $customPage->description !!}
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </section>
    <!-- our-company end -->



    <!-- company-skill start -->
    {{-- <section class="company-skill pt-xs-80 pb-xs-80 pt-sm-100 pt-md-100 pt-120 pb-100 overflow-hidden">
        <div class="container">
            <div class="row">

            </div>
        </div>
    </section> --}}
    <!-- company-skill end -->

    <!-- counter-area start -->
    {{-- <div class="counter-area pb-xs-80 pb-sm-120 pb-md-120 pb-lg-120 pb-xl-140 pb-170 overflow-hidden">
        <div class="container">
            <div class="row mb-minus-30">

            </div>
        </div>
    </div> --}}
    <!-- counter-area end -->
@endsection
