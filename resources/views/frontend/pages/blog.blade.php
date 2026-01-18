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
<div class="site-content">
    @php
        $headerImage = $metaImagePath ? asset($metaImagePath) : null;
        $headerTitle = $title ?? 'Blog';
        $headerDescription = \Illuminate\Support\Str::limit(strip_tags($desc ?? ''), 120);
        if (empty($headerDescription)) {
            $headerDescription = 'When asked the question';
        }
    @endphp

    <div class="inner-header bg-holder" @if ($headerImage) style="background-image: url('{{ $headerImage }}');" @endif>
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
        <section class="space-ptb ellipse-top ellipse-bottom">
            <div class="container">
                <div class="row justify-content-start">
                    <div class="col-lg-12">
                        <div class="blog-items grid-wrapper grid-xl-3 grid-md-2 grid-sm-1">
                            @forelse($blog as $b)
                                @php
                                    $postTitle = $b->title ?? 'Blog Post';
                                    $postDate = optional($b->created_at)->format('F d, Y');
                                    $postCategory = optional($b->category)->name ?? 'Blog';
                                    $postImage = !empty($b->image)
                                        ? asset($b->image)
                                        : asset('frontend/assets/images/about/about-01.jpg');
                                    $postUrl = !empty($b->slug)
                                        ? route('front.blog_details', [$b->slug])
                                        : 'javascript:void(0);';
                                @endphp
                                <div class="blog-post-wrapper blog-style-1">
                                    <div class="blog-post-info">
                                        <div class="post-meta">
                                            <div class="post-meta-date">{{ $postDate }}</div>
                                        </div>
                                        <h5 class="post-title"><a href="{{ $postUrl }}">{{ $postTitle }}</a></h5>
                                    </div>
                                    <div class="blog-post-img"><img class="img-fluid" src="{{ $postImage }}" alt="{{ $postTitle }}" /></div>
                                    <div class="blog-action-info">
                                        <h5 class="post-category"><a href="javascript:void(0);">{{ $postCategory }}</a></h5>
                                        <div class="post-link">
                                            <a class="btn-arrow" href="{{ $postUrl }}"><svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_923_133)"><path d="M8.70801 0.959961L9.29825 2.7665C10.2512 5.68321 12.8308 7.77453 15.8928 8.1128C12.8468 8.37564 10.2578 10.4348 9.3276 13.3343L8.70801 15.2657" stroke="inherit" stroke-width="2"/><path d="M15.7602 8.12158H0.1875" stroke="inherit" stroke-width="2"/></g><defs><clipPath id="clip0_923_133"><rect width="15.904" height="14.8437" fill="inherit" transform="translate(0.1875 0.578125)"/></clipPath></defs></svg></a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="blog-post-wrapper blog-style-1">
                                    <div class="blog-post-info">
                                        <h5 class="post-title">No blog posts available yet.</h5>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

