@extends('frontend.app')

@section('title', ($service->meta_title ?? $service->seo_title ?? $service->short_name ?? $service->name ?? 'Service'))

@push('css')



@endpush

@section('seos')

@php

    $siteName = $service->site_name ?? config('app.name', 'Blacktech');

    $metaTitle = $service->meta_title ?? $service->seo_title ?? $service->short_name ?? $service->name ?? $siteName;

    $rawDescription = $service->meta_description ?? $service->seo_description ?? $service->short_description ?? $service->long_description ?? '';

    $metaDescription = \Illuminate\Support\Str::limit(trim(strip_tags($rawDescription)), 180);

    if (empty($metaDescription)) {

        $metaDescription = \Illuminate\Support\Str::limit($metaTitle, 160, '');

    }

    $primaryImage = $service->meta_image ? asset($service->meta_image) : ($service->thumb_image ? asset($service->thumb_image) : null);

    $metaImage = $primaryImage ?? asset('images/og-default.jpg');

    $author = $service->author ?? 'Blacktech';

    $publisher = $service->publisher ?? $siteName;

    $copyright = $service->copyright ?? null;

    $keywords = $service->keywords ?? null;

    $canonical = url()->current();

@endphp

   <meta charset="UTF-8">



    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">



    <meta name="title" content="{{ $metaTitle }}">

    <meta name="description" content="{{ $metaDescription }}">

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

    <link rel="canonical" href="{{ $canonical }}">

    <meta property="og:title" content="{{ $metaTitle }}">

    <meta property="og:description" content="{{ $metaDescription }}">

    <meta property="og:url" content="{{ $canonical }}">

    <meta property="og:site_name" content="{{ $siteName }}">

    <meta property="og:type" content="website">

    <meta property="og:image" content="{{ $metaImage }}">

    <meta property="og:image:secure_url" content="{{ $metaImage }}">

    <meta property="og:image:alt" content="{{ $metaTitle }}">

    <meta property="og:locale" content="en_US">

    @if ($publisher)

    <meta property="article:publisher" content="{{ $publisher }}">

    @endif

    @if ($author)

    <meta property="article:author" content="{{ $author }}">

    @endif

    <meta property="article:modified_time" content="{{ optional($service->updated_at)->toIso8601String() ?? now()->toIso8601String() }}">

    <meta name="twitter:card" content="summary_large_image">

    <meta name="twitter:title" content="{{ $metaTitle }}">

    <meta name="twitter:description" content="{{ $metaDescription }}">

    <meta name="twitter:url" content="{{ $canonical }}">

    <meta name="twitter:image" content="{{ $metaImage }}">

    <meta name="twitter:image:alt" content="{{ $metaTitle }}">



    <meta http-equiv="X-UA-Compatible" content="IE=edge">

@endsection

@section('content')

<div class="site-content">

    @php

        $headerImage = 'frontend/assets/images/banner/inner-header/page-header-01.jpg';

        if (!file_exists(public_path($headerImage))) {

            $headerImage = 'frontend/assets/images/banner/banner-01/banner-bg-01.png';

        }

        $headerTitle = $service->short_name ?? $service->name ?? 'Service Detail';

        $headerDescription = $metaDescription ?? '';

        $serviceTitle = $headerTitle;

        $contact = DB::table('contact_pages')->first();

        $faqItems = \App\Models\Faq::where('status', 1)->get();

    @endphp

    <div class="inner-header bg-holder" style="background-image: url('{{ asset($headerImage) }}');">

        <div class="container">

            <div class="row justify-content-center">

                <div class="col-md-12 text-center">

                    <h1 class="title">{{ $headerTitle }}</h1>

                    {{-- intentionally no description in the header --}}

                </div>

            </div>

        </div>

    </div>



    <div class="content-wrapper">

        <section class="space-ptb ellipse-bottom">

            <div class="container">

                <div class="row justify-content-start">

                    <div class="col-lg-4">

                        <div class="sidebar is-sticky">

                            @if (!empty($relatedServices) && $relatedServices->count())
                                <div class="widget widget-categories">
                                    <h5 class="widget-title">Related Services</h5>
                                    <ul class="categories-list">
                                        @foreach ($relatedServices as $relatedService)
                                            <li>
                                                <a href="{{ route('front.shop', $relatedService->slug) }}">
                                                    {{ $relatedService->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="widget categories-widget">

                                <h5 class="widget-title">{{ $serviceTitle }}</h5>

                                <ul class="address-info-list mb-0">

                                    @if ($contact && $contact->phone)

                                        <li>

                                            <h6><img class="img-fluid" src="{{ asset('frontend/assets/images/svg/address-info-headphone.svg') }}" alt="">{{ $contact->phone }}</h6>

                                        </li>

                                    @endif

                                    @if ($contact && $contact->email)

                                        <li>

                                            <h6><img class="img-fluid" src="{{ asset('frontend/assets/images/svg/address-info-email.svg') }}" alt="">{{ $contact->email }}</h6>

                                        </li>

                                    @endif

                                </ul>

                            </div>

                        </div>

                    </div>



                    <div class="col-lg-8 mt-5 mt-lg-0">

                        <div class="service-single">

                            @if (!empty($service->thumb_image))

                                <div class="service-img">

                                    <img class="img-fluid" src="{{ asset($service->thumb_image) }}" alt="{{ $serviceTitle }}">

                                </div>

                            @endif

                            <div class="service-content ps-0 ps-md-5 mt-5">

                                <h5 class="service-title">{{ $service->name ?? $serviceTitle }}</h5>

                                <div class="description">

                                    @if (!empty($service->short_description))

                                        {!! $service->short_description !!}

                                    @endif

                                    @if (!empty($service->long_description))

                                        {!! $service->long_description !!}

                                    @endif

                                    @if (empty($service->short_description) && empty($service->long_description))

                                        <p>Not Added</p>

                                    @endif

                                </div>

                                @if ($faqItems && $faqItems->count())

                                    <div class="section-title mt-5">

                                        <span class="sub-title"><img class="img-fluid" src="{{ asset(optional(siteInfo())->favicon ?? 'frontend/assets/images/favicon.ico') }}" alt=""> FAQ</span>

                                        <h5 class="title mb-0">Frequently Asked Questions</h5>

                                    </div>

                                    <div class="accordion" id="serviceFaq">

                                        @foreach ($faqItems as $index => $faq)

                                            <div class="accordion-item">

                                                <h5 class="accordion-header" id="serviceFaqHeading{{ $index }}">

                                                    <button class="accordion-button {{ $index ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#serviceFaqCollapse{{ $index }}" aria-expanded="{{ $index ? 'false' : 'true' }}" aria-controls="serviceFaqCollapse{{ $index }}">

                                                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}. {{ $faq->question }}

                                                    </button>

                                                </h5>

                                                <div id="serviceFaqCollapse{{ $index }}" class="accordion-collapse collapse {{ $index ? '' : 'show' }}" aria-labelledby="serviceFaqHeading{{ $index }}" data-bs-parent="#serviceFaq">

                                                    <div class="accordion-body">{!! $faq->answer !!}</div>

                                                </div>

                                            </div>

                                        @endforeach

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </div>

</div>

@endsection

