@extends('frontend.app')
@php
    $siteName = config('app.name', 'Blacktech');
    $title = optional($rule)->title ?? 'Affiliate Marketing Rules & Regulations';
    $desc = \Illuminate\Support\Str::limit(strip_tags(optional($rule)->description ?? 'Review Blacktech affiliate program rules, regulations, and service prices.'), 180);
    $url = url()->current();
    $siteInfo = siteInfo();
    $metaImage = !empty($siteInfo->logo) ? asset($siteInfo->logo) : asset('images/og-default.jpg');
@endphp
@section('title', $title)
@section('seos')
<meta name="title" content="{{ $title }}">
<meta name="description" content="{{ $desc }}">
<link rel="canonical" href="{{ $url }}">
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $desc }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:image" content="{{ $metaImage }}">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $desc }}">
<meta name="twitter:image" content="{{ $metaImage }}">
@endsection
@section('content')
<div class="site-content">
    <div class="inner-header bg-holder">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <h1 class="title">{{ $title }}</h1>
                    <p>Review the program terms before applying or submitting clients.</p>
                    <a href="{{ route('front.affiliate') }}" class="btn btn-effect mt-3"><span>Apply Now</span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <section class="space-ptb z-index-2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="section-title is-sticky">
                            <span class="sub-title"><img class="img-fluid" src="{{ asset(optional(siteInfo())->favicon ?? 'frontend/assets/images/favicon.ico') }}" alt=""> Affiliate Program</span>
                            <h2 class="title">Rules & Regulations</h2>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="mb-5">
                            @if ($rule && !empty($rule->description))
                                {!! clean($rule->description) !!}
                            @else
                                <p>No affiliate rules have been added yet.</p>
                            @endif
                        </div>

                        <div class="section-title mb-4">
                            <h3 class="title">Service Price Categories</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-dark table-striped">
                                <thead>
                                    <tr>
                                        <th>Service</th>
                                        <th>Basic</th>
                                        <th>Intermediate</th>
                                        <th>Complex</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($prices as $price)
                                        <tr>
                                            <td>
                                                {{ $price->service_name }}
                                                @if ($price->note)
                                                    <br><small>{{ $price->note }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $price->basic_price }}</td>
                                            <td>{{ $price->intermediate_price }}</td>
                                            <td>{{ $price->complex_price }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No service prices have been added yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
