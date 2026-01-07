
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
<div class="site-content">
    @php
        $headerImage = 'frontend/assets/images/banner/inner-header/page-header-01.jpg';
        if (!file_exists(public_path($headerImage))) {
            $headerImage = 'frontend/assets/images/banner/banner-01/banner-bg-01.png';
        }
        $headerTitle = $blog->title ?? 'Blog Details';
        $headerDescription = \Illuminate\Support\Str::limit(strip_tags($metaDescription ?? $blog->description ?? ''), 120);
        if (empty($headerDescription)) {
            $headerDescription = 'Success is that it is a process';
        }
        $categoryName = optional($blog->category)->name ?? 'Blog';
        $postDate = optional($blog->created_at)->format('M d, Y') ?? now()->format('M d, Y');
        $authorName = $blog->author ?? optional($blog->admin)->name ?? 'admin';
        $authorImage = optional($blog->admin)->image
            ? asset($blog->admin->image)
            : asset('frontend/assets/images/team/01.jpg');
        $postImage = !empty($blog->image)
            ? asset($blog->image)
            : asset('frontend/assets/images/about/about-01.jpg');
        $postUrl = !empty($blog->slug)
            ? route('front.blog_details', [$blog->slug])
            : 'javascript:void(0);';
    @endphp

    <div class="inner-header bg-holder" style="background-image: url('{{ asset($headerImage) }}');">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <h1 class="title">{{ $headerTitle }}</h1>
                    @if (!empty($headerDescription))
                        <p>{{ $headerDescription }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <section class="space-ptb ellipse-bottom">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="blog-single format-standard">
                            <div class="post-content-header">
                                <div class="post-meta">
                                    <ul>
                                        <li class="post-meta-category"><a href="javascript:void(0);">{{ $categoryName }}</a></li>
                                        <li class="post-meta-date">{{ $postDate }}</li>
                                    </ul>
                                </div>
                                <h3 class="post-title"><a href="{{ $postUrl }}">{{ $blog->title }}</a></h3>

                                <div class="blog-single-info">
                                    <div class="blog-author">
                                        <img class="author-image img-fluid" src="{{ $authorImage }}" alt="{{ $authorName }}">
                                        <div class="blog-info">
                                            <h6 class="author-name">Written by</h6>
                                            <p>{{ $authorName }}</p>
                                        </div>
                                    </div>
                                    <div class="social-icon">
                                        <p class="mb-0 me-2 me-sm-4">Share</p>
                                        <ul>
                                            <li><a href="#">Fb</a></li>
                                            <li><a href="#">IN</a></li>
                                            <li><a href="#">X</a></li>
                                            <li><a href="#">YT</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="blog-post-img">
                                <img class="img-fluid radius-10" src="{{ $postImage }}" alt="{{ $blog->title }}" />
                            </div>
                            <div class="blog-post-content">
                                <div class="post-content-body">
                                    {!! $blog->description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

