@extends('frontend.app')

@push('css')
    {{-- <link rel="stylesheet" href="{{ asset('frontend/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/blog.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/food.css') }}"> --}}

@endpush
@php
    $SeoSettings = DB::table('seo_settings')->where('page_name', 'Blog')->first();
    $siteName = optional($SeoSettings)->site_name ?? config('app.name', 'Blacktech');
    $title = optional($SeoSettings)->meta_title ?? optional($SeoSettings)->seo_title ?? 'Blog';
    $descriptionSource = optional($SeoSettings)->meta_description ?? optional($SeoSettings)->seo_description ?? '';
    $desc = \Illuminate\Support\Str::limit(strip_tags($descriptionSource), 180);
    $url = url()->current();
    $metaImagePath = optional($SeoSettings)->meta_image;
    $metaImage = $metaImagePath
        ? asset($metaImagePath)
        : (siteInfo()->logo ? asset(siteInfo()->logo) : asset('images/og-default.jpg'));
    $author = optional($SeoSettings)->author ?? 'Blacktech';
    $publisher = optional($SeoSettings)->publisher ?? $siteName;
    $copyright = optional($SeoSettings)->copyright;
    $keywords = optional($SeoSettings)->keywords;
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

<style>
    .active>.page-link, .page-link.active {
    z-index: 3;
    color: var(--bs-pagination-active-color);
    background-color: rgba(13, 110, 253, 0.25);
    border-color: var(--bs-pagination-active-border-color);
}
</style>
<!--

   <!-- page-banner start -->
   <section class="page-banner pt-xs-60 pt-sm-80 overflow-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-banner__content mb-xs-10 mb-sm-15 mb-md-15 mb-20">
                        <div class="transparent-text">Blog </div>
                        <div class="page-title p-2 ">
                            <h1 class="display-4 fw-bold text-uppercase text-white text-center">{{$title}}</h1>
                        </div>
                    </div>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('front.home')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Blog Posts</li>
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

<main class=" my-4">

<!-- <div class="text-content-blog bg-dark text-dark p-4 mb-4">
    <h2 class="text-center fw-bold display-6">Blog Posts</h2>
</div> -->
<div class="container">


    <div class="row">
        <!-- Blog entries-->
        <div class="col-lg-12">
            <!-- Featured blog post-->


            <div class="row">
                @foreach($blog as $b)
                <div class="col-lg-4">
                    <!-- Blog post-->
                    
                    <div class="card mb-4">
                        <a href="{{route('front.blog_details', [$b->slug])}}"><img class="card-img-top"
                                src="{{asset($b->image)}}"
                                alt="..." height="300px" /></a>
                        <div class="card-body">
                            <div class="small text-muted">{{date('m/d/Y', strtotime($b->created_at))}}</div>
                            <a href="{{route('front.blog_details', [$b->slug])}}">
                            <h2 class="card-title h4" style="color: black;">
                                {!! Str::limit($b->title, 90, ' ...') !!}
                                </h2>
                            </a>
                            <!--<p class="card-text">{!! Str::limit($b->description, 100, ' ...') !!}-->
                            </p>
                            <!-- <a class="btn btn-danger" href="{{route('front.blog_details', [$b->slug])}}">Read more →</a> -->
                        </div>
                    </div>
                    
                    <!-- Blog post-->

                </div>
                @endforeach


            </div>
            <!-- Pagination-->

        </div>
        <!-- Side widgets-->
        <div class="col-lg-4">
            <!-- Search widget-->

            <!-- Categories widget-->

        </div>
    </div>
</div>
</main>

<!-- <div class="blog pt-70 pb-100">
    <div class="container">
        <div class="row justify-content-center">
            @foreach($blog as $b)
            <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                <div class="blog-card">
                    <div class="blog-card-img">
                        <a href="{{route('front.blog_details', [$b->slug])}}"><img src="{{asset($b->image)}}" alt="image"></a>
                    </div>
                    <div class="blog-card-text">
                        <span class="blog-date"><i class="flaticon-deadline"></i> {{$b->created_at}}</span>
                        <h4><a href="{{route('front.blog_details', [$b->slug])}}">{{$b->title}}</a></h4>
                        <p>{!! Str::limit($b->description, 100, ' ...') !!}</p>
                        <a class="read-more-btn" href="{{route('front.blog_details', [$b->slug])}}">Read More <i class="flaticon-right-arrow"></i></a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <div class="paginations mt-30">
            <ul>
                <li><a href="posted-by.html"><span><i class="fas fa-angle-left"></i></span></a></li>
                <li class="active"><a href="posted-by.html"><span>1</span></a></li>
                <li><a href="posted-by.html"><span>2</span></a></li>
                <li><a href="posted-by.html"><span>3</span></a></li>
                <li><a href="posted-by.html"><span><i class="fas fa-angle-right"></i></span></a></li>
            </ul>
        </div>
    </div>
</div> -->


@endsection
