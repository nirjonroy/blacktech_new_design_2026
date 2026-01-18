@extends('frontend.app')
@php
    $siteInfo = siteInfo();
    $siteName = optional($siteInfo)->site_name ?? config('app.name', 'Blacktech');
    $siteLogo = optional($siteInfo)->logo;
    $pageTitle = $customPage->meta_title ?: $customPage->page_name;
    $pageDescription = $customPage->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($customPage->description), 180);
    $pageKeywords = $customPage->meta_keywords;
    $canonical = $customPage->canonical_url ?: url()->current();
    $robots = $customPage->meta_robots ?: 'index, follow';
    $defaultMetaImage = $siteLogo ? asset($siteLogo) : asset('frontend/assets/img/page-banner/page-banner.jpg');
    $metaImage = $customPage->meta_image ? asset($customPage->meta_image) : $defaultMetaImage;
@endphp
@section('title', trim(($pageTitle ? $pageTitle . ' | ' : '') . $siteName))
@push('css')

@endpush
@section('seos')
    <meta charset="UTF-8">
    <meta name="robots" content="{{ $robots }}">
    <meta name="title" content="{{ $pageTitle }}">
    <meta name="description" content="{{ $pageDescription }}">
    @if(!empty($pageKeywords))
        <meta name="keywords" content="{{ $pageKeywords }}">
    @endif
    <link rel="canonical" href="{{ $canonical }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">
    <meta property="article:modified_time" content="{{ optional($customPage->updated_at)->toIso8601String() ?? now()->toIso8601String() }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ $canonical }}">
    <meta name="twitter:image" content="{{ $metaImage }}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
@endsection
@section('content')
<div class="site-content">
    <div class="container-fluid">
        <div class="item-efftect">
            <div class="efftect overflow-hidden"></div>
            <div class="efftect overflow-hidden"></div>
            <div class="efftect overflow-hidden"></div>
            <div class="efftect overflow-hidden"></div>
            <div class="efftect overflow-hidden"></div>
        </div>
    </div>

    @php
        $headerImage = $customPage->meta_image ? asset($customPage->meta_image) : null;
        $headerTitle = $pageTitle ?: ($customPage->page_name ?? 'Page');
        $headerDescriptionSource = $pageDescription ?: ($customPage->description ?? '');
        $headerDescription = \Illuminate\Support\Str::limit(strip_tags($headerDescriptionSource), 140);
        if (empty($headerDescription)) {
            $headerDescription = 'Learn more about this page.';
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
        <section class="space-ptb ellipse-bottom">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        @if (!empty($customPage->description))
                            <div class="custom-page-body">
                                {!! $customPage->description !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
