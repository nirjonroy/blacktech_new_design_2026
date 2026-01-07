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
<div class="site-content">
    @php
        $headerImage = 'frontend/assets/images/banner/inner-header/page-header-01.jpg';
        if (!file_exists(public_path($headerImage))) {
            $headerImage = 'frontend/assets/images/banner/banner-01/banner-bg-01.png';
        }
        $headerTitle = $project->name ?? 'Project Details';
        $headerDescription = \Illuminate\Support\Str::limit(strip_tags($desc ?? $project->description ?? ''), 120);
        if (empty($headerDescription)) {
            $headerDescription = 'See how we delivered results for our clients.';
        }
        $projectImage = $project->image
            ? asset($project->image)
            : asset('frontend/assets/images/case-studies/01.png');
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
                <div class="row justify-content-start">
                    <div class="col-lg-6">
                        <div class="service-single">
                            <div class="service-img">
                                <img class="img-fluid" src="{{ $projectImage }}" alt="{{ $project->name }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-5 mt-lg-0">
                        <div class="section-title">
                            <span class="sub-title"><img class="img-fluid" src="{{ asset(optional(siteInfo())->favicon ?? 'frontend/assets/images/favicon.ico') }}" alt=""> Project</span>
                            <h2 class="title">{{ $project->name }}</h2>
                        </div>
                        <div class="description">
                            {!! $project->description !!}
                        </div>

                        @if (! empty($project->link))
                            <div class="mt-4">
                                <a href="{{ $project->link }}" target="_blank" rel="noopener" class="btn btn-effect">
                                    <span>View Live Project</span>
                                    <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_59_253)"><path d="M19.4854 11.4293L17.0513 12.221C13.1214 13.4993 10.3036 16.9595 9.84784 21.0668C9.49371 16.981 6.71926 13.5081 2.81255 12.2604L0.210283 11.4293" stroke="white" stroke-width="2"/><path d="M9.83594 20.8889L9.83594 0" stroke="white" stroke-width="2"/></g><defs><clipPath id="clip0_59_253"><rect width="21.3333" height="20" fill="white" transform="translate(20) rotate(90)"/></clipPath></defs></svg>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

