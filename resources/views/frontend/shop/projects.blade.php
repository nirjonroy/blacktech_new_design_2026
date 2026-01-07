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
<div class="site-content">
    @php
        $headerImage = 'frontend/assets/images/banner/inner-header/page-header-01.jpg';
        if (!file_exists(public_path($headerImage))) {
            $headerImage = 'frontend/assets/images/banner/banner-01/banner-bg-01.png';
        }
        $fallbackCaseImages = [
            'frontend/assets/images/case-studies/01.png',
            'frontend/assets/images/case-studies/02.png',
            'frontend/assets/images/case-studies/03.png',
        ];
    @endphp
    <div class="inner-header bg-holder" style="background-image: url('{{ asset($headerImage) }}');">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <h1 class="title">{{ $title }}</h1>
                    @if (!empty($desc))
                        <p>{{ $desc }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <section class="space-ptb z-index-2">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-5 col-lg-5">
                        <div class="section-title mb-4 mb-lg-0">
                            <span class="sub-title"><img class="img-fluid" src="{{ asset(optional(siteInfo())->favicon ?? 'frontend/assets/images/favicon.ico') }}" alt=""> Projects</span>
                            <h2 class="title">Projects For Our Amazing Clients</h2>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-4">
                        @if (!empty($desc))
                            <p>{{ $desc }}</p>
                        @endif
                    </div>
                    <div class="col-xl-2 col-lg-3 text-end">
                        <a class="btn btn-effect" href="{{ route('front.about-us') }}">
                            <span>About Us</span>
                            <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_59_255)"><path d="M19.4854 11.4293L17.0513 12.221C13.1214 13.4993 10.3036 16.9595 9.84784 21.0668C9.49371 16.981 6.71926 13.5081 2.81255 12.2604L0.210283 11.4293" stroke="white" stroke-width="2"/><path d="M9.83594 20.8889L9.83594 0" stroke="white" stroke-width="2"/></g><defs><clipPath id="clip0_59_255"><rect width="21.3333" height="20" fill="white" transform="translate(20) rotate(90)"/></clipPath></defs></svg>
                        </a>
                    </div>
                </div>

                <div class="row mt-5">
                    @foreach ($projects as $index => $project)
                        @php
                            $projectUrl = route('front.project.show', $project->slug);
                            $projectImage = !empty($project->image)
                                ? asset($project->image)
                                : asset($fallbackCaseImages[$index % count($fallbackCaseImages)]);
                            $projectCategory = optional($project->category)->name ?? 'Project';
                            $projectDescription = \Illuminate\Support\Str::limit(strip_tags($project->description ?? ''), 140);
                        @endphp
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="case-studies-wrapper case-studies-style-1">
                                <div class="case-studies-img">
                                    <img class="img-fluid" src="{{ $projectImage }}" alt="{{ $project->name }}">
                                    <a class="category" href="{{ $projectUrl }}">{{ $projectCategory }}</a>
                                </div>
                                <div class="case-studies-info">
                                    <div class="case-studies-info-inner">
                                        <h4 class="case-studies-title"><a href="{{ $projectUrl }}">{{ $project->name }}</a></h4>
                                        <div class="case-studies-content">
                                            @if (!empty($projectDescription))
                                                <div class="case-studies-description">{{ $projectDescription }}</div>
                                            @endif
                                            <a class="btn-arrow" href="{{ $projectUrl }}"><svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_923_133)"><path d="M8.70801 0.959961L9.29825 2.7665C10.2512 5.68321 12.8308 7.77453 15.8928 8.1128C12.8468 8.37564 10.2578 10.4348 9.3276 13.3343L8.70801 15.2657" stroke="inherit" stroke-width="2"/><path d="M15.7602 8.12158H0.1875" stroke="inherit" stroke-width="2"/></g><defs><clipPath id="clip0_923_133"><rect width="15.904" height="14.8437" fill="inherit" transform="translate(0.1875 0.578125)"/></clipPath></defs></svg></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
