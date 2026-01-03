@extends('frontend.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/food.css') }}">
@endpush
@php
        $SeoSettings = DB::table('seo_settings')->where('id', 2)->first();
        $siteName = $SeoSettings->site_name ?? config('app.name', 'Blacktech');
        $title = $SeoSettings->meta_title ?? $SeoSettings->seo_title ?? $siteName;
        $desc = \Illuminate\Support\Str::limit(strip_tags($SeoSettings->meta_description ?? $SeoSettings->seo_description ?? ''), 180);
        $url = url()->current();
        $metaImage = $SeoSettings->meta_image ? asset($SeoSettings->meta_image) : asset($about_us->video_background);
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
<div class="container mx-4 p-4" >
<div class="offcanvas-overlay" ></div>
</div>

    <!-- offcanvas-overlay -->
    <!-- header end -->

   
    <!-- header end -->

    <!-- page-banner start -->
    <section class="page-banner overflow-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-banner__content mb-xs-10 mb-sm-15 mb-md-15 mb-20">
                        <div class="transparent-text">About Us</div>
                        <div class="page-title p-2 ">
                            <h2 class="display-4 fw-bold text-uppercase text-white text-center">About Blacktech</h2>
                        </div>
                    </div>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('front.home')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">About Us</li>
                        </ol>
                    </nav>
                </div>

                <div class="col-md-6">
                    <div class="page-banner__media mt-xs-30 mt-sm-40">
                        <img src="{{asset('frontend/assets/img/page-banner/page-banner-start.svg')}}" class="img-fluid start" alt="">
                        <img src="{{asset('frontend/assets/img/page-banner/page-banner.jpg" class="img-fluid')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- page-banner end -->

    <!-- our-company start -->
    <section class="our-company  pt-xs-80 pb-xs-80 pt-sm-100 pb-sm-100 pt-md-100 pb-md-100 pt-120 pb-120 overflow-hidden">
        <div class="container mx-auto">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="our-company__midea wow fadeInUp" data-wow-delay=".3s">
                        <img src="assets/img/about/our-company-1.png" alt="" class="img-fluid">

                        <div class="years-experience overflow-hidden mt-20 mt-sm-10 mt-xs-10 text-center">
                            <div class="number mb-5 color-white">
                                <span class="counter">5</span><sup>+</sup>
                            </div>

                            <h5 class="title color-white">Years Experience</h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="our-company__meida border-radius wow fadeInUp" data-wow-delay=".5s">
                        <img src="{{ asset($about_us->video_background) }}" alt="" class="img-fluid">

                        <div class="horizental-bar"></div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="our-company__content mt-md-50 mt-sm-40 mt-xs-35 wow fadeInUp" data-wow-delay=".3s">
                        <span class="sub-title fw-500 color-primary text-uppercase mb-sm-10 mb-xs-5 mb-20 d-block"><img src="assets/img/team-details/badge-line.svg" class="img-fluid mr-10" alt="" class="text-uppercase"> Know About Our Company</span>
                        <!--<h2 class="title color-d_black mb-20 mb-sm-15 mb-xs-10">Our Company Provide High Quality Idea</h2>-->

                        <div class="descriiption font-la mb-30 mb-md-25 mb-sm-20 mb-xs-15">
                            <p>
                                {!!$about_us->about_us!!}
                            </p>
                        </div>

                        <div class="client-feedback d-flex flex-column flex-sm-row">
                            <div class="client-feedback__item text-center">
                                <div class="client-feedback__item-header">
                                    <span class="color-primary font-la fw-600 text-uppercase">Success Project</span>
                                </div>

                                <div class="client-feedback__item-body">
                                    <div class="number mb-10 mb-xs-5 color-d_black fw-600">+<span class="counter">95</span>%</div>
                                    <div class="description font-la mb-10 mb-xs-5">
                                        
                                    </div>
                                    <div class="starts">
                                        <ul>
                                            <li><span></span></li>
                                            <li><span></span></li>
                                            <li><span></span></li>
                                            <li><span></span></li>
                                            <li><span></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="client-feedback__item text-center">
                                <div class="client-feedback__item-header">
                                    <span class="color-primary font-la fw-600 text-uppercase">Customer Review</span>
                                </div>

                                <div class="client-feedback__item-body">
                                    <div class="number mb-10 mb-xs-5 color-d_black fw-600">+<span class="counter">4.7</span></div>
                                    <div class="description font-la mb-10 mb-xs-5">
                                        
                                    </div>
                                    <div class="starts">
                                        <ul>
                                            <li><span></span></li>
                                            <li><span></span></li>
                                            <li><span></span></li>
                                            <li><span></span></li>
                                            <li><span></span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- our-company end -->

   

    <!-- company-skill start -->
    <section class="company-skill pt-xs-80 pb-xs-80 pt-sm-100 pt-md-100 pt-120 pb-100 overflow-hidden">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="company-skill__content wow fadeInUp" data-wow-delay=".3s">
                        <span class="sub-title d-block fw-500 color-primary text-uppercase mb-sm-10 mb-xs-5 mb-md-15 mb-20"><img src="assets/img/team-details/badge-line.svg" class="img-fluid mr-10" alt="">Company Skills</span>
                        <h2 class="title text-uppercase "><span class="text-warning fw-bold">Our Company Provide</span></h2>

                        <div class="description font-la">
                            
                        </div>

                        <div class="progress-bar__wrapper mt-40 mt-sm-35 mt-xs-30">
                            <div class="single-progress-bar mb-30 wow fadeInUp" data-wow-delay=".3s">
                                <h6 class="title color-d_black mb-10">Web Design</h6>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="max-width: 100%">
                                        <span class="placeholder" style="left: 100%">100%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="single-progress-bar mb-30 wow fadeInUp" data-wow-delay=".5s">
                                <h6 class="title color-d_black mb-10">Web Development</h6>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100" style="max-width: 100%">
                                        <span class="placeholder" style="left: 100%">100%</span>
                                    </div>
                                </div>
                            </div>

                            <div class="single-progress-bar mb-30 wow fadeInUp" data-wow-delay=".7s">
                                <h6 class="title color-d_black mb-10">SEO</h6>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="max-width: 90%">
                                        <span class="placeholder" style="left: 90%">90%</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="single-progress-bar mb-30 wow fadeInUp" data-wow-delay=".7s">
                                <h6 class="title color-d_black mb-10">Graphics Design</h6>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="max-width: 90%">
                                        <span class="placeholder" style="left: 90%">90%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <!-- <div class="company-skill__media-wrapper d-flex flex-column mt-lg-60 mt-md-50 mt-sm-45 mt-xs-40 align-items-center wow fadeInUp" data-wow-delay=".3s">
                        <a href="https://www.youtube.com/watch?v=9xwazD5SyVg" class="popup-video" data-effect="mfp-move-from-top"><i class="icon-play"></i></a>

                        <div class="company-skill__media">
                            <img src="assets/img/about/company-skill-meida.png" alt="" class="img-fluid">
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
    <!-- company-skill end -->

    <!-- counter-area start -->
    <div class="counter-area pb-xs-80 pb-sm-120 pb-md-120 pb-lg-120 pb-xl-140 pb-170 overflow-hidden">
        <div class="container">
            <div class="row mb-minus-30">
                <div class="col-xl-6 col-lg-4 col-sm-6">
                    <div class="counter-area__item d-flex align-items-center wow fadeInUp" data-wow-delay=".3s">
                        <div class="icon color-primary">
                            <i class="icon-process-1"></i>
                        </div>

                        <div class="text text-center">
                            <div class="number fw-600 color-primary"><span class="counter">5620</span>+</div>
                            <div class="description font-la">Successful Project</div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="counter-area__item d-flex align-items-center wow fadeInUp" data-wow-delay=".5s">
                        <div class="icon color-primary">
                            <i class="icon-support-2"></i>
                        </div>

                        <div class="text text-center">
                            <div class="number fw-600 color-primary"><span class="counter">150</span>+</div>
                            <div class="description font-la">Expert Consulter</div>
                        </div>
                    </div>
                </div>

               

                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="counter-area__item d-flex align-items-center wow fadeInUp" data-wow-delay=".9s">
                        <div class="icon color-primary">
                            <i class="icon-teamwork-1"></i>
                        </div>

                        <div class="text text-center">
                            <div class="number fw-600 color-primary"><span class="counter">3225</span>+</div>
                            <div class="description font-la">Client Satisfaction</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- counter-area end -->

   
@endsection
