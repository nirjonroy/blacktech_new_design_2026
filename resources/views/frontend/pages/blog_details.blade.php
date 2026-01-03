
@extends('frontend.app')
@section('title', $blog->meta_title ?? $blog->seo_title ?? $blog->title)
@push('css')
    {{-- <link rel="stylesheet" href="{{ asset('frontend/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/food.css') }}"> --}}
@endpush

@section('seos')
@php
    $siteName = $blog->site_name ?? config('app.name', 'Blacktech');
    $metaTitle = $blog->meta_title ?? $blog->seo_title ?? $blog->title;
    $rawDescription = $blog->meta_description ?? $blog->seo_description ?? $blog->description;
    $metaDescription = \Illuminate\Support\Str::limit(strip_tags($rawDescription), 180);
    $metaImage = $blog->meta_image ? asset($blog->meta_image) : asset($blog->image);
    $author = $blog->author ?? 'Blacktech';
    $publisher = $blog->publisher ?? $siteName;
    $copyright = $blog->copyright ?? null;
    $keywords = $blog->keywords ?? null;
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
<meta property="og:type" content="article">
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
<meta property="article:modified_time" content="{{ optional($blog->updated_at)->toIso8601String() ?? now()->toIso8601String() }}">

<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:url" content="{{ $canonical }}">
<meta name="twitter:image" content="{{ $metaImage }}">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
@endsection

@section('content')

<!--Page Header End-->


<style>
    ul{
        list-style-type: auto !important;
    }
    li{
        list-style: auto !important;
    }
</style>
<section class="page-banner pt-xs-60 pt-sm-80 overflow-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-banner__content mb-xs-10 mb-sm-15 mb-md-15 mb-20">
                        <div class="transparent-text">Blog Details </div>
                        <div class="page-title p-2 ">
                            <h2 class="display-4 fw-bold text-uppercase text-white text-center">Blog Details</h2>
                        </div>
                    </div>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('front.home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('front.blog')}}">Blog</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Blog Details</li>
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

<!--About Two Start-->
<section class="pt-xs-40 pb-xs-40 pt-sm-60 pb-sm-100 pt-md-60 pb-md-60 pt-80 pb-80 overflow-hidden">
    <div class="container" style="max-width:800px">
        <div class="row g-4" >

            <div class="col-xl-12 col-lg-12 col-12">

                <div class="about-two__right">
                    <div class="section-title text-left">
                        <h1 class="section-title__title" style="text-align: center;
    margin-bottom: 20px;
    color: #ff9c00;">{{$blog->title}}</h1>
                        <img src="{{asset($blog->image)}}" alt="" class="img-fluid rounded float-left" style="width: 100%; height:360px; margin-bottom:25px">
                        
                    </div>
                    <p class="about-two__text-1">
                        <p>{!! $blog->description !!}</p>
                    </p>


                </div>

            </div>
        </div>
    </div>
</section>
<!--About Two End-->
@endsection
