@extends('frontend.app')
@section('title', ($service->meta_title ?? $service->seo_title ?? $service->short_name ?? $service->name ?? 'Service'))
@push('css')

@endpush
@section('seos')
@php
    $siteName = $service->site_name ?? config('app.name', 'Blacktech');
    $metaTitle = $service->meta_title ?? $service->seo_title ?? $service->short_name ?? $service->name ?? $siteName;
    $rawDescription = $service->meta_description ?? $service->seo_description ?? $service->short_description ?? $service->long_description ?? '';
    $metaDescription = \Illuminate\Support\Str::limit(trim(strip_tags($rawDescription)), 180);
    if (empty($metaDescription)) {
        $metaDescription = \Illuminate\Support\Str::limit($metaTitle, 160, '');
    }
    $primaryImage = $service->meta_image ? asset($service->meta_image) : ($service->thumb_image ? asset($service->thumb_image) : null);
    $metaImage = $primaryImage ?? asset('images/og-default.jpg');
    $author = $service->author ?? 'Blacktech';
    $publisher = $service->publisher ?? $siteName;
    $copyright = $service->copyright ?? null;
    $keywords = $service->keywords ?? null;
    $canonical = url()->current();
@endphp
   <meta charset="UTF-8">

    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <meta name="title" content="{{ $metaTitle }}">
    <meta name="description" content="{{ $metaDescription }}">
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
    <link rel="canonical" href="{{ $canonical }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:image:secure_url" content="{{ $metaImage }}">
    <meta property="og:image:alt" content="{{ $metaTitle }}">
    <meta property="og:locale" content="en_US">
    @if ($publisher)
    <meta property="article:publisher" content="{{ $publisher }}">
    @endif
    @if ($author)
    <meta property="article:author" content="{{ $author }}">
    @endif
    <meta property="article:modified_time" content="{{ optional($service->updated_at)->toIso8601String() ?? now()->toIso8601String() }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:url" content="{{ $canonical }}">
    <meta name="twitter:image" content="{{ $metaImage }}">
    <meta name="twitter:image:alt" content="{{ $metaTitle }}">

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
                        <div class="transparent-text"> Service Details </div>
                        <div class="page-title">
                            @if(!empty($service->short_name))
                            <h1> {{$service->short_name}}</h1>
                            @endif
                        </div>
                    </div>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('front.home')}}l">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Services</li>
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

    <!-- our-company start -->
    <section class="our-company  pt-xs-80 pb-xs-80 pt-sm-100 pb-sm-100 pt-md-100 pb-md-100 pt-120 pb-120 overflow-hidden">
        <div class="container-fluid" style="max-width:1200px">
            <div class="row g-4">
                <div class="col-md-12">
                    <!--@if(!empty($service->name))-->
                    <!--<h2 class="my-4 p-2 text-center" style="#ff9c00"><blockquote >{{$service->name}}</blockquote>    </h2>-->
                    <!--@endif-->
                    
                    @if(!empty($service->thumb_image))
                    <img width="800px" height="500px"  src="{{asset($service->thumb_image)}}" class="img-fluid p-4 my-4"  alt="{{$service->name}}" style="display: block; margin:0 auto; border-radius:24px;">
                    @endif
                    
                    @if(!empty($service->short_description))
                    <p class="my-4 p-2 ">{!!$service->short_description!!}</p>
                    @endif
                    @if(!empty($service->name))
                    <h2 class="my-4 p-2 text-center"> {{$service->name}}</h2>
                    @endif
                    @if(!empty($service->long_description))
                    <p class="my-4 p-2">{!!$service->long_description!!}</p>
                    @else
                    <h1 class="my-4 p-2">Not Added</h1>
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
