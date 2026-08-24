@extends('frontend.app')
@php
    $SeoSettings = $SeoSettings
        ?? DB::table('seo_settings')->where('id', 15)->first()
        ?? DB::table('seo_settings')->whereRaw('LOWER(page_name) = ?', ['affiliate'])->first();

    $siteName = optional($SeoSettings)->site_name ?? config('app.name', 'Blacktech');
    $title = optional($SeoSettings)->meta_title
        ?? optional($SeoSettings)->seo_title
        ?? 'Become an Affiliate | Blacktech';
    $rawDesc = optional($SeoSettings)->meta_description
        ?? optional($SeoSettings)->seo_description
        ?? 'Partner with Blacktech and earn by referring businesses that need digital services.';
    $desc = \Illuminate\Support\Str::limit(strip_tags($rawDesc), 180);
    $url = url()->current();

    $siteInfo = siteInfo();
    $fallbackLogo = $siteInfo->logo ?? null;
    $defaultImage = $fallbackLogo ? asset($fallbackLogo) : asset('images/og-default.jpg');
    $metaImage = optional($SeoSettings)->meta_image ? asset($SeoSettings->meta_image) : $defaultImage;

    $updatedIso = optional(optional($SeoSettings)->updated_at ? \Illuminate\Support\Carbon::parse($SeoSettings->updated_at) : null)->toIso8601String() ?? now()->toIso8601String();
    $twitter = optional($SeoSettings)->twitter_site ?? '@blacktech';
    $indexable = isset($SeoSettings->indexable) ? (bool) $SeoSettings->indexable : true;
    $author = optional($SeoSettings)->author ?? 'Blacktech';
    $publisher = optional($SeoSettings)->publisher ?? $siteName;
    $copyright = optional($SeoSettings)->copyright;
    $keywords = optional($SeoSettings)->keywords;
@endphp
@section('title', $title)
@section('seos')
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $title }}</title>
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
<meta name="robots" content="{{ $indexable ? 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' : 'noindex, nofollow' }}">

<meta property="og:type" content="website">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $desc }}">
<meta property="og:url" content="{{ $url }}">
<meta property="og:image" content="{{ $metaImage }}">
<meta property="og:image:secure_url" content="{{ $metaImage }}">
<meta property="og:image:alt" content="{{ $siteName }}">
<meta property="og:updated_time" content="{{ $updatedIso }}">
<meta property="og:locale" content="en_US">
@if ($publisher)
<meta property="article:publisher" content="{{ $publisher }}">
@endif
@if ($author)
<meta property="article:author" content="{{ $author }}">
@endif

<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="{{ $twitter }}">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $desc }}">
<meta name="twitter:image" content="{{ $metaImage }}">
<meta name="twitter:url" content="{{ $url }}">
<meta property="article:modified_time" content="{{ $updatedIso }}">
<style>
    .affiliate-action-stack {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        margin-top: 34px;
    }

    .affiliate-action-stack .btn-effect {
        flex: 0 0 auto;
    }

    .affiliate-login-circle {
        color: #fff;
        text-decoration: none;
    }

    .affiliate-login-circle:hover,
    .affiliate-login-circle:focus {
        color: #ffd700;
        text-decoration: none;
    }

    @media (max-width: 575px) {
        .affiliate-action-stack {
            flex-direction: column;
            justify-content: center;
        }
    }
</style>
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

    <div class="inner-header bg-holder">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <h1 class="title">Become an Affiliate</h1>
                    <p>Refer businesses that need digital services and start a partnership with Blacktech.</p>
                    @include('frontend.partials.banner-cta')
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <section class="space-ptb z-index-2">
            <div class="container">
                <div class="row align-items-start">
                    <div class="col-xl-5 col-lg-5">
                        <div class="section-title is-sticky">
                            <span class="sub-title"><img class="img-fluid" src="{{ asset(optional(siteInfo())->favicon ?? 'frontend/assets/images/favicon.ico') }}" alt=""> Affiliate Program</span>
                            <h2 class="title">Bring the right clients. We handle the service delivery.</h2>
                            <p>Use this form to propose an affiliate partnership. Tell us about your audience, channels, and how you plan to promote Blacktech services.</p>
                            <ul class="list-unstyled mt-4">
                                <li class="mb-3"><i class="fa-solid fa-check me-2"></i> Good fit for marketers, creators, agencies, and community owners.</li>
                                <li class="mb-3"><i class="fa-solid fa-check me-2"></i> Promote web design, development, branding, SEO, and digital marketing services.</li>
                                <li class="mb-3"><i class="fa-solid fa-check me-2"></i> We review each application before starting the partnership.</li>
                            </ul>
                            <a href="{{ route('front.affiliate.rules') }}" class="btn btn-effect mt-4">
                                <span>Rules & Prices</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-7">
                        <div class="form-wrapper">
                            <form class="contact-form form-style-border" action="{{ route('front.affiliate.submit') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Your Name *" name="name" value="{{ old('name') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control" placeholder="Email Address *" name="email" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-4 pe-1">
                                                <input type="text" class="form-control" placeholder="+1" name="phone_country_code" value="{{ old('phone_country_code') }}" pattern="^\+[0-9]{1,4}$" title="Enter country code. Example: +1">
                                            </div>
                                            <div class="col-8 ps-1">
                                                <input type="tel" class="form-control" placeholder="Phone / WhatsApp" name="phone" value="{{ old('phone') }}" pattern="^[0-9\s().-]{6,20}$" title="Enter phone number without country code">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Company / Brand Name" name="company_name" value="{{ old('company_name') }}">
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="url" class="form-control" placeholder="Website or Social Profile Link" name="website" value="{{ old('website') }}">
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control" placeholder="Your audience or niche *" name="audience" value="{{ old('audience') }}" required>
                                    </div>
                                    <div class="col-lg-12">
                                        <textarea class="form-control" rows="5" placeholder="How will you promote our services? *" name="promotion_plan" required>{{ old('promotion_plan') }}</textarea>
                                    </div>
                                    <div class="col-lg-12">
                                        <textarea class="form-control" rows="4" placeholder="Additional message" name="message">{{ old('message') }}</textarea>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="affiliate-action-stack">
                                            <button type="submit" class="btn btn-effect">
                                                <span>Submit Application</span>
                                                <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_affiliate)"><path d="M19.4854 11.4293L17.0513 12.221C13.1214 13.4993 10.3036 16.9595 9.84784 21.0668C9.49371 16.981 6.71926 13.5081 2.81255 12.2604L0.210283 11.4293" stroke="white" stroke-width="2"/><path d="M9.83594 20.8889L9.83594 0" stroke="white" stroke-width="2"/></g><defs><clipPath id="clip0_affiliate"><rect width="21.3333" height="20" fill="white" transform="translate(20) rotate(90)"/></clipPath></defs></svg>
                                            </button>
                                            <a href="{{ route('front.affiliate.login') }}" class="btn btn-effect affiliate-login-circle">
                                                <span>Affiliate Login</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>
    </div>
</div>
@endsection
