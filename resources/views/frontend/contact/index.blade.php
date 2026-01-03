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

    <!-- page-banner start -->
    <section class="page-banner pt-xs-60 pt-sm-80 overflow-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-banner__content mb-xs-10 mb-sm-15 mb-md-15 mb-20">
                        <div class="transparent-text">Contact Us</div>
                        <div class="page-title p-2 ">
                            <h2 class="display-4 fw-bold text-uppercase text-white text-center">Contact Us</h2>
                        </div>
                    </div>

                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('front.home')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
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

<div class="contact ptb-100">
    <div class="container">
        <div class="row align-items-center g-4">
<div class="col-12 col-sm-12 col-md-6 col-lg-6">
  <div class="contact-box p-4">
  <!-- <h4>{{$contacts->title}}</h4>
    <p>{!!$contacts->description!!}</p> -->

    <h2 class="h2 fs-2 fw-bold text-start mb-4 text-uppercase "> Contacs us</h2>

  <form id="contactForm" action="{{route('front.direct-message')}}"  method="post">


                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Name" id="name" name="name" required data-error="Please enter your name" >
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email" id="email"  required data-error="Please enter your Email">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" name="phone" class="form-control" placeholder="Phone Number" id="phone_number" required data-error="Please enter your phone number">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" name="subject" class="form-control" placeholder="Subject" id="msg_subject" required data-error="Please enter your subject">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <textarea name="message" id="message" class="form-control" placeholder="Your Messages.." cols="30" rows="5" required data-error="Please enter your message"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-12">
                                <button class="btn btn-warning px-4" type="submit"><span class="text-center text-white fw-bold">Send</span></button>
                                <div id="msgSubmit" class="h6 text-center hidden"></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
  </div>
</div>
<div class="col-12 col-sm-12 col-md-6 col-lg-6">
   <div class="map p-4 border border-1 rounded">
    <h1>{{$contacts->title}}</h1>
    <p>{!!$contacts->description!!}</p>
   </div>
</div>

        </div>





        <!-- <div class="row g-5">
            <div class="col-lg-6">
                <div class="contact-form-text-area">
                    <form id="contactForm" action="{{route('front.direct-message')}}"  method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Name" id="name" name="name" required data-error="Please enter your name" >
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email" id="email"  required data-error="Please enter your Email">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" name="phone" class="form-control" placeholder="Phone Number" id="phone_number" required data-error="Please enter your phone number">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <input type="text" name="subject" class="form-control" placeholder="Subject" id="msg_subject" required data-error="Please enter your subject">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <textarea name="message" id="message" class="form-control" placeholder="Your Messages.." cols="30" rows="5" required data-error="Please enter your message"></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12 col-sm-12 col-12">
                                <button class="default-button" type="submit"><span>Send Message</span></button>
                                <div id="msgSubmit" class="h6 text-center hidden"></div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="customer-support-area">


                </div>
            </div>
        </div> -->
    </div>
</div>


<!-- <div class="contact-google-map">
    <iframe class="g-map" src="{{$contacts->map}}"></iframe>
</div> -->




@endsection
