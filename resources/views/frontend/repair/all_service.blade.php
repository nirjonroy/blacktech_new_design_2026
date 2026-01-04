@extends('frontend.app')

@push('css')

@endpush
@php
    $SeoSettings = DB::table('seo_settings')->where('page_name', 'Service')->first();
    $siteName = optional($SeoSettings)->site_name ?? config('app.name', 'Blacktech');
    $title = optional($SeoSettings)->meta_title ?? optional($SeoSettings)->seo_title ?? $siteName;
    $descriptionSource = optional($SeoSettings)->meta_description ?? optional($SeoSettings)->seo_description ?? '';
    $desc = \Illuminate\Support\Str::limit(strip_tags($descriptionSource), 180);
    $url = url()->current();
    $fallbackLogo = siteInfo()->logo ?? null;
    $firstItemImage = isset($all_service) && $all_service->count() ? optional($all_service->first())->image : null;
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
        <section class="space-ptb ellipse-bottom">
            <div class="container">
                <div class="row justify-content-start">
                    <div class="col-lg-12">
                        @php
                            $serviceIcons = [
                                'Information-Security.svg',
                                'Data-Synchronization.svg',
                                'Mobile-Platforms.svg',
                                'Process-Automation.svg',
                                'Event-Processing.svg',
                                'Content-Management.svg',
                            ];
                            $serviceIndex = 0;
                        @endphp
                        <div class="services grid-wrapper grid-xl-4 grid-lg-3 grid-md-2 grid-sm-1">
                            @foreach ($all_service as $item)
                                @php
                                    $serviceSlug = optional($item->category)->slug ?? $item->slug;
                                    $serviceUrl = $serviceSlug ? route('front.shop', $serviceSlug) : 'javascript:void(0);';
                                    $icon = $serviceIcons[$serviceIndex % count($serviceIcons)];
                                    $serviceIndex++;
                                    $serviceDescription = \Illuminate\Support\Str::limit(strip_tags($item->short_description ?? ''), 140);
                                @endphp
                                <div class="service-wrapper service-style-1">
                                    <div class="service-inner">
                                        <div class="service-icon">
                                            <img class="img-fluid" src="{{ asset('frontend/assets/images/svg/services/' . $icon) }}" alt="">
                                        </div>
                                        <div class="bg-icon">
                                            <img class="img-fluid" src="{{ asset('frontend/assets/images/svg/services/color-icon/' . $icon) }}" alt="">
                                        </div>
                                        <div class="service-content">
                                            <h5 class="service-title"><a href="{{ $serviceUrl }}">{{ $item->name }}</a></h5>
                                            @if (!empty($serviceDescription))
                                                <p>{{ $serviceDescription }}</p>
                                            @endif
                                            <div class="service-links">
                                                <a class="btn-arrow" href="{{ $serviceUrl }}"><svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_923_133)"><path d="M8.70801 0.959961L9.29825 2.7665C10.2512 5.68321 12.8308 7.77453 15.8928 8.1128C12.8468 8.37564 10.2578 10.4348 9.3276 13.3343L8.70801 15.2657" stroke="inherit" stroke-width="2"/><path d="M15.7602 8.12158H0.1875" stroke="inherit" stroke-width="2"/></g><defs><clipPath id="clip0_923_133"><rect width="15.904" height="14.8437" fill="inherit" transform="translate(0.1875 0.578125)"/></clipPath></defs></svg></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
