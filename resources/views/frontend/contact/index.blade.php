@extends('frontend.app')
@section('title', 'Contact Us | Blacktech')
@push('css')
    {{-- <link rel="stylesheet" href="{{ asset('frontend/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/food.css') }}"> --}}
@endpush
@section('seos')
@php
    $SeoSettings = DB::table('seo_settings')->where('page_name', 'Contact Us')->first();
    $siteName = optional($SeoSettings)->site_name ?? config('app.name', 'Blacktech');
    $title = optional($SeoSettings)->meta_title ?? optional($SeoSettings)->seo_title ?? ($contacts->title ?? 'Contact');
    $rawDescription = optional($SeoSettings)->meta_description ?? optional($SeoSettings)->seo_description ?? ($contacts->description ?? '');
    $desc = \Illuminate\Support\Str::limit(strip_tags($rawDescription), 180);
    $url = url()->current();
    $metaImagePath = optional($SeoSettings)->meta_image;
    $metaImage = $metaImagePath ? asset($metaImagePath) : (siteInfo()->logo ? asset(siteInfo()->logo) : asset('images/og-default.jpg'));
    $author = optional($SeoSettings)->author ?? 'Blacktech';
    $publisher = optional($SeoSettings)->publisher ?? $siteName;
    $copyright = optional($SeoSettings)->copyright;
    $keywords = optional($SeoSettings)->keywords;
@endphp
   <meta charset="UTF-8">

    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

    <meta name="title" content="{{$title}}">

    <meta name="description" content="{{$desc}}">
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
    <meta property="og:title" content="{{$title}}">
    <meta property="og:description" content="{{$desc}}">
    <meta property="og:url" content="{{ $url }}">
    <meta property="og:site_name" content="{{$siteName}}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">


    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $desc }}">
    <meta name="twitter:url" content="{{ $url }}">
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
        $headerImage = $metaImagePath ? asset($metaImagePath) : null;
        $headerTitle = $title ?? ($contacts->title ?? 'Contact Us');
        $headerDescriptionSource = $desc ?: ($contacts->description ?? '');
        $headerDescription = \Illuminate\Support\Str::limit(strip_tags($headerDescriptionSource), 120);
        if (empty($headerDescription)) {
            $headerDescription = 'Let success motivate you.';
        }
        $contactDescription = $contacts->description ?? '';
        $locationItems = [
            [
                'name' => $contacts->title ?? 'Blacktech',
                'image' => 'frontend/assets/images/about/about-03.jpg',
            ],
            [
                'name' => $contacts->title ?? 'Blacktech',
                'image' => 'frontend/assets/images/about/about-01.jpg',
            ],
            [
                'name' => $contacts->title ?? 'Blacktech',
                'image' => 'frontend/assets/images/case-studies/01.png',
            ],
            [
                'name' => $contacts->title ?? 'Blacktech',
                'image' => 'frontend/assets/images/case-studies/02.png',
            ],
        ];
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
        <section class="space-ptb z-index-2">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-5">
                        <div class="section-title is-sticky">
                            <span class="sub-title"><img class="img-fluid" src="{{ asset(optional(siteInfo())->favicon ?? 'frontend/assets/images/favicon.ico') }}" alt=""> Our Direction</span>
                            <h2 class="title">Get in touch with us. We love talking about digital strategy</h2>
                            @if (!empty($contactDescription))
                                <p>{!! $contactDescription !!}</p>
                            @else
                                <p>So, make the decision to move forward. Commit your decision to paper, just to bring it into focus. Then, go for it!</p>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-7">
                        <div class="location-items grid-wrapper grid-xl-2 grid-lg-2 grid-md-2 grid-sm-2 grid-xs-1">
                            @foreach ($locationItems as $item)
                                <div class="location-wrapper location-style-1 bg-black">
                                    <div class="location-inner">
                                        <div class="location-info">
                                            <div class="city-image">
                                                <img class="img-fluid" src="{{ asset($item['image']) }}" alt="">
                                            </div>
                                            <div class="city-info">
                                                <h5 class="city-name"><a href="javascript:void(0);">{{ $item['name'] }}</a></h5>
                                                <div class="city-location">
                                                    @if (!empty($contacts->address))
                                                        <div class="location-item">
                                                            <i class="icon"><img class="img-fluid" src="{{ asset('frontend/assets/images/svg/address-info-contacts.svg') }}" alt=""></i>
                                                            <div class="list-label">{{ $contacts->address }}</div>
                                                        </div>
                                                    @endif
                                                    @if (!empty($contacts->phone))
                                                        <div class="location-item">
                                                            <i class="icon"><img class="img-fluid" src="{{ asset('frontend/assets/images/svg/address-info-headphone.svg') }}" alt=""></i>
                                                            <div class="list-label">{{ $contacts->phone }}</div>
                                                        </div>
                                                    @endif
                                                    @if (!empty($contacts->email))
                                                        <div class="location-item">
                                                            <i class="icon"><img class="img-fluid" src="{{ asset('frontend/assets/images/svg/address-info-email.svg') }}" alt=""></i>
                                                            <div class="list-label">{{ $contacts->email }}</div>
                                                        </div>
                                                    @endif
                                                </div>
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

        <section class="space-pt ellipse-top bg-black">
            <div class="space-pb ellipse-bottom">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="section-title text-center">
                                <span class="sub-title d-flex justify-content-center"><img class="img-fluid" src="{{ asset(optional(siteInfo())->favicon ?? 'frontend/assets/images/favicon.ico') }}" alt=""> contact us</span>
                                <h2 class="title">Need assistance? please fill the form</h2>
                            </div>
                            <div class="form-wrapper">
                                <form class="contact-form form-style-border" action="{{ route('front.direct-message') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Name" name="name" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="email" class="form-control" placeholder="Email" name="email" required>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control" placeholder="Phone" name="phone" required>
                                        </div>
                                        <div class="col-lg-12">
                                            <input type="text" class="form-control" placeholder="Subject" name="subject" required>
                                        </div>
                                        <div class="col-lg-12">
                                            <textarea class="form-control" rows="6" placeholder="Message" name="message" required></textarea>
                                        </div>
                                        <div class="col-lg-12">
                                            <button type="submit" class="btn btn-effect">
                                                <span>Send Message</span>
                                                <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_59_253)"><path d="M19.4854 11.4293L17.0513 12.221C13.1214 13.4993 10.3036 16.9595 9.84784 21.0668C9.49371 16.981 6.71926 13.5081 2.81255 12.2604L0.210283 11.4293" stroke="white" stroke-width="2"/><path d="M9.83594 20.8889L9.83594 0" stroke="white" stroke-width="2"/></g><defs><clipPath id="clip0_59_253"><rect width="21.3333" height="20" fill="white" transform="translate(20) rotate(90)"/></clipPath></defs></svg>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

