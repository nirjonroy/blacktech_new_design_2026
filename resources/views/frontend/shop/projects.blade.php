@extends('frontend.app')

@push('css')

@endpush

@php
    $SeoSettings = DB::table('seo_settings')->where('page_name', 'Project')->first();
    $siteName = optional($SeoSettings)->site_name ?? config('app.name', 'Blacktech');
    $title = optional($SeoSettings)->meta_title ?? optional($SeoSettings)->seo_title ?? $siteName;
    $descriptionSource = optional($SeoSettings)->meta_description ?? optional($SeoSettings)->seo_description ?? '';
    $desc = \Illuminate\Support\Str::limit(strip_tags($descriptionSource), 180);
    $url = url()->current();
    $fallbackLogo = siteInfo()->logo ?? null;
    $firstItemImage = isset($projects) && $projects->count() ? optional($projects->first())->image : null;
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
                            <h2 class="display-4 text-center"> Projects </h1>
                        </div>
                    </div>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('front.home')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Explore Project</li>
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
        <div class="row g-4">

            @foreach($projects as $project)
            <div class="col-12 col-sm-6 col-4 col-lg-3">
                <div class="similar-work__item mb-30 d-flex justify-content-between flex-column wow fadeInUp" data-wow-delay=".3s">
                    <div class="top d-flex align-items-center">

                        <h4 class="title color-secondary"><a href="{{ route('front.project.show', $project->slug) }}">{{$project->name}}</a></h4>
                    </div>

                    <div class="bottom">
                        <div class="media overflow-hidden">
                            <img style="max-width:20rem" src="{{asset($project->image)}}" class="img-fluid" alt="">
                        </div>

                        <div class="text-card p-2 my-2   ">
                        <p class="card-body fw-bold">{!!$project->description!!}</p>
                        </div>

                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('front.project.show', $project->slug) }}" class="theme-btn text-center fw-bold btn-yellow">View Details <i class="fas fa-long-arrow-alt-right"></i></a>
                            @if(!empty($project->link))
                                <a href="{{ $project->link }}" target="_blank" rel="noopener" class="theme-btn text-center fw-bold btn-outline-secondary">Visit Live Site <i class="fas fa-external-link-alt"></i></a>
                            @endif
                        </div>
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
