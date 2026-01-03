@extends('frontend.app')
@section('title', $project->meta_title ?? $project->name)
@push('css')

@endpush
@section('seos')
@php
    $siteName = $project->site_name ?? config('app.name', 'Blacktech');
    $title = $project->meta_title ?? $project->name;
    $rawDescription = $project->meta_description ?? $project->description ?? '';
    $desc = \Illuminate\Support\Str::limit(strip_tags($rawDescription), 180);
    $url = url()->current();
    $metaImage = $project->meta_image
        ? asset($project->meta_image)
        : ($project->image ? asset($project->image) : asset('images/og-default.jpg'));
    $author = $project->author ?? 'Blacktech';
    $publisher = $project->publisher ?? $siteName;
    $copyright = $project->copyright ?? null;
    $keywords = $project->keywords ?? null;
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

<meta property="og:type" content="article">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $desc }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:image" content="{{ $metaImage }}">
<meta property="og:image:secure_url" content="{{ $metaImage }}">
<meta property="og:image:alt" content="{{ $title }}">
<meta property="og:locale" content="en_US">
@if ($publisher)
<meta property="article:publisher" content="{{ $publisher }}">
@endif
@if ($author)
<meta property="article:author" content="{{ $author }}">
@endif
<meta property="article:modified_time" content="{{ optional($project->updated_at)->toIso8601String() ?? now()->toIso8601String() }}">

<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $desc }}">
<meta name="twitter:url" content="{{ $url }}">
<meta name="twitter:image" content="{{ $metaImage }}">
@endsection

@section('content')
<div class="offcanvas-overlay"></div>

<section class="page-banner pt-xs-60 pt-sm-80 overflow-hidden">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-banner__content mb-xs-10 mb-sm-15 mb-md-15 mb-20">
                    <div class="transparent-text">Project</div>
                    <div class="page-title">
                        <h1 class="display-4 text-center">{{ $project->name }}</h1>
                    </div>
                </div>

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('front.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('front.our-project') }}">Projects</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $project->name }}</li>
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

<section class="pt-xs-60 pb-xs-60 pt-sm-80 pb-sm-100 pt-md-100 pb-md-120 pt-120 pb-120 overflow-hidden">
    <div class="container">
        <div class="row g-5 align-items-start">
            <div class="col-lg-6">
                <div class="project-media shadow-sm rounded overflow-hidden">
                    <img src="{{ $project->image ? asset($project->image) : asset('frontend/assets/img/page-banner/page-banner.jpg') }}" class="img-fluid" alt="{{ $project->name }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="project-details font-la">
                    <h2 class="mb-4">{{ $project->name }}</h2>
                    <div class="project-description">
                        {!! $project->description !!}
                    </div>

                    @if (! empty($project->link))
                        <div class="mt-4">
                            <a href="{{ $project->link }}" target="_blank" rel="noopener" class="theme-btn btn-yellow fw-600">
                                View Live Project <i class="fas fa-external-link-alt"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
