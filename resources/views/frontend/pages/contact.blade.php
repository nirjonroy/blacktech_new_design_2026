@extends('frontend.app')

@push('css')
    <!--<link rel="stylesheet" href="{{ asset('frontend/css/home.css') }}">-->
    <!--<link rel="stylesheet" href="{{ asset('frontend/css/food.css') }}">-->
@endpush
    @php
        $SeoSettings = DB::table('seo_settings')->where('id', 3)->first();
        $siteName = $SeoSettings->site_name ?? config('app.name', 'Blacktech');
        $title = $SeoSettings->meta_title ?? $SeoSettings->seo_title ?? $siteName;
        $desc = \Illuminate\Support\Str::limit(strip_tags($SeoSettings->meta_description ?? $SeoSettings->seo_description ?? ''), 180);
        $url = url()->current();
        $fallbackLogo = siteInfo()->logo ?? null;
        $metaImage = $SeoSettings->meta_image ? asset($SeoSettings->meta_image) : ($fallbackLogo ? asset($fallbackLogo) : asset('images/og-default.jpg'));
        $author = $SeoSettings->author ?? 'Blacktech';
        $publisher = $SeoSettings->publisher ?? $siteName;
        $copyright = $SeoSettings->copyright ?? null;
        $keywords = $SeoSettings->keywords ?? null;
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
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $desc }}">
    <meta property="og:url" content="{{ $url }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:image" content="{{ $metaImage }}">

    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">
    <meta property="article:modified_time" content="{{ optional($SeoSettings->updated_at)->toIso8601String() ?? now()->toIso8601String() }}">
    @if ($publisher)
    <meta property="article:publisher" content="{{ $publisher }}">
    @endif
    @if ($author)
    <meta property="article:author" content="{{ $author }}">
    @endif
    <meta name="twitter:card" content="summary">
    <meta name="twitter:url" content="{{ $url }}">
    <meta name="twitter:image" content="{{ $metaImage }}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
@endsection
@section('content')
<div class="main-wrapper">






        <section class="bodyTable">
            <div>
                <div class="landingPage2" style="margin-left:2%; margin-right:2%; text-align:justify">
                  <h2 style="text-align:center">{{$contact->title}} </h2>
                  <iframe src="{{$contact->map}} " width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                  <p> Phone : {{$contact->phone}} </p>
                  <p> Email : {{$contact->email}} </p>
                  <p> Address : {{$contact->address}}</p>
                  <p>  {{$contact->description}}</p>


                </div>
            </div>
        </section>
    </div>
@endsection
