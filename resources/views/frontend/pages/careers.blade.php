@extends('frontend.app')

@php
    $SeoSettings = DB::table('seo_settings')->where('page_name', 'Careers')->first();
    $siteName = optional($SeoSettings)->site_name ?? config('app.name', 'Blacktech');
    $title = optional($SeoSettings)->meta_title ?? optional($SeoSettings)->seo_title ?? 'Careers';
    $rawDescription = optional($SeoSettings)->meta_description ?? optional($SeoSettings)->seo_description ?? '';
    $desc = \Illuminate\Support\Str::limit(strip_tags($rawDescription), 180);
    $url = url()->current();
    $metaImagePath = optional($SeoSettings)->meta_image;
    $metaImage = $metaImagePath ? asset($metaImagePath) : (siteInfo()->logo ? asset(siteInfo()->logo) : asset('images/og-default.jpg'));
    $author = optional($SeoSettings)->author ?? 'Blacktech';
    $publisher = optional($SeoSettings)->publisher ?? $siteName;
    $copyright = optional($SeoSettings)->copyright;
    $keywords = optional($SeoSettings)->keywords;
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

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $desc }}">
    <meta name="twitter:url" content="{{ $url }}">
    <meta name="twitter:image" content="{{ $metaImage }}">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
@endsection

@section('content')
<div class="site-content">
    @php
        $headerImage = 'frontend/assets/images/banner/inner-header/page-header-01.jpg';
        if (!file_exists(public_path($headerImage))) {
            $headerImage = 'frontend/assets/images/banner/banner-01/banner-bg-01.png';
        }
        $headerTitle = 'Careers';
        $headerDescription = 'Give yourself the power of responsibility.';

        $aboutImagePath = !empty(optional($about_us)->video_background)
            ? optional($about_us)->video_background
            : (!empty(optional($about_us)->image_two) ? optional($about_us)->image_two : 'frontend/assets/images/about/about-03.jpg');
        if (!file_exists(public_path($aboutImagePath))) {
            $aboutImagePath = 'frontend/assets/images/about/about-01.jpg';
        }
        $aboutImage = asset($aboutImagePath);
        $aboutTitle = 'We enable constant enterprise transformation at speed and scale.';
        $aboutText = !empty(optional($about_us)->about_us)
            ? \Illuminate\Support\Str::limit(strip_tags(optional($about_us)->about_us), 600)
            : 'We focus on purposeful growth and meaningful outcomes that help teams do their best work.';
        $aboutList = [
            'Success is something of which we all want more',
            'Most people believe that success is difficult',
            'There are key areas to higher achievement',
            'Believing in yourself and those around you',
            'Making a decision to do something',
        ];

        $steps = [
            [
                'number' => 'Step 01',
                'title' => 'We Know Your Business Already',
                'description' => 'We help you shape clear goals and build momentum with simple, focused steps.',
                'list' => [
                    'E-commerce strategy',
                    'Business intelligence',
                    'Custom design',
                    'Android',
                    'Brand collateral',
                    'Front-end development',
                ],
            ],
            [
                'number' => 'Step 02',
                'title' => 'Building Context, Not Just Code',
                'description' => 'We learn your users and workflows first, then deliver solutions that fit.',
                'list' => [
                    'E-commerce strategy',
                    'Business intelligence',
                ],
            ],
            [
                'number' => 'Step 03',
                'title' => 'We Are Responsive And Flexible',
                'description' => 'We collaborate closely and stay adaptable as needs evolve.',
                'list' => [
                    'Digital PR',
                    'Technical operations',
                    'Accounting outsourcing',
                ],
            ],
            [
                'number' => 'Step 04',
                'title' => '10 Years Experience And Counting',
                'description' => 'Experience helps us move faster while keeping quality high.',
                'list' => [
                    'Digital PR',
                    'Technical operations',
                    'Accounting outsourcing',
                ],
            ],
        ];
    @endphp

    <div class="inner-header bg-holder" style="background-image: url('{{ asset($headerImage) }}');">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <h1 class="title">{{ $headerTitle }}</h1>
                    <p>{{ $headerDescription }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <section class="space-ptb ellipse-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 mb-5 mb-md-0">
                        <img class="img-fluid mx-lg-5 radius-10" src="{{ $aboutImage }}" alt="About">
                    </div>
                    <div class="col-md-7">
                        <div class="section-title pe-xl-5">
                            <span class="sub-title"><img class="img-fluid" src="{{ asset('frontend/assets/images/subtitle-icon.png') }}" alt=""> About Us</span>
                            <h2 class="title">{{ $aboutTitle }}</h2>
                        </div>
                        <div class="ps-sm-5">
                            <p class="mb-4">{{ $aboutText }}</p>
                            <div class="list-wrapper list-style-2">
                                <ul class="list">
                                    @foreach ($aboutList as $item)
                                        <li><i class="fa-solid fa-check"></i>{{ $item }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="space-ptb">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="section-title text-center">
                            <span class="sub-title justify-content-center"><img class="img-fluid" src="{{ asset('frontend/assets/images/subtitle-icon.png') }}" alt=""> Open Positions</span>
                            <h2 class="title">Find Your Job Here</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="find-job-wrapper">
                                @forelse ($careers as $career)
                                    @php
                                        $careerImage = !empty($career->image)
                                            ? asset($career->image)
                                            : asset('frontend/assets/images/about/about-01.jpg');
                                        $careerType = $career->employment_type ?? 'Full Time';
                                        $careerLocation = $career->location ?? 'Remote';
                                        $careerDescription = $career->short_description ?? 'We are looking for someone who is ready to grow with us.';
                                        $careerExperience = $career->experience ?? 'N/A';
                                        $careerSalary = $career->salary ?? 'Negotiable';
                                        $careerDeadline = $career->deadline ? $career->deadline->format('d M Y') : 'Open';
                                        $applyUrl = !empty($career->apply_url) ? $career->apply_url : route('front.contact');
                                    @endphp
                                    <div class="find-job-item">
                                        <div class="job-title">
                                            <h4 class="awards-name">{{ $career->title }}</h4>
                                        </div>
                                        <div class="job-details">
                                            <div class="job-image"><img class="img-fluid" src="{{ $careerImage }}" alt="{{ $career->title }}" /></div>
                                            <div class="job-content">
                                                <div class="job-time">{{ $careerType }}</div>
                                                <div class="job-location">Location : <span>{{ $careerLocation }}</span></div>
                                                <div class="job-desc">{{ $careerDescription }}</div>
                                                <div class="job-info">
                                                    <div class="info-item info-experience">Experience : <span>{{ $careerExperience }}</span></div>
                                                    <div class="info-item info-salary">Salary : <span>{{ $careerSalary }}</span></div>
                                                    <div class="info-item info-deadline">Deadline : <span>{{ $careerDeadline }}</span></div>
                                                </div>
                                            </div>
                                            <div class="job-action">
                                                <a class="btn btn-effect" href="{{ $applyUrl }}">
                                                    <span>Apply Now</span>
                                                    <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_59_253)"><path d="M19.4854 11.4293L17.0513 12.221C13.1214 13.4993 10.3036 16.9595 9.84784 21.0668C9.49371 16.981 6.71926 13.5081 2.81255 12.2604L0.210283 11.4293" stroke="white" stroke-width="2"/><path d="M9.83594 20.8889L9.83594 0" stroke="white" stroke-width="2"/></g><defs><clipPath id="clip0_59_253"><rect width="21.3333" height="20" fill="white" transform="translate(20) rotate(90)"/></clipPath></defs></svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="find-job-item">
                                        <div class="job-title">
                                            <h4 class="awards-name">No open positions right now</h4>
                                        </div>
                                        <div class="job-details">
                                            <div class="job-content">
                                                <div class="job-desc">Check back soon or reach out via the contact page for future opportunities.</div>
                                            </div>
                                            <div class="job-action">
                                                <a class="btn btn-effect" href="{{ route('front.contact') }}">
                                                    <span>Contact Us</span>
                                                    <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_59_253)"><path d="M19.4854 11.4293L17.0513 12.221C13.1214 13.4993 10.3036 16.9595 9.84784 21.0668C9.49371 16.981 6.71926 13.5081 2.81255 12.2604L0.210283 11.4293" stroke="white" stroke-width="2"/><path d="M9.83594 20.8889L9.83594 0" stroke="white" stroke-width="2"/></g><defs><clipPath id="clip0_59_253"><rect width="21.3333" height="20" fill="white" transform="translate(20) rotate(90)"/></clipPath></defs></svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="space-pt ellipse-top">
            <div class="space-pb ellipse-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="sticky-top" style="top: 80px;">
                                <div class="section-title mb-0">
                                    <span class="sub-title"><img class="img-fluid" src="{{ asset('frontend/assets/images/subtitle-icon.png') }}" alt="" /> How It Works</span>
                                    <h2 class="title">Four reasons why you should choose our service</h2>
                                </div>
                                <div class="ps-xxl-5 ms-0 ms-md-5 pb-5 pb-lg-0">
                                    <p class="mb-5">We help you stay focused on what matters and keep progress moving forward.</p>
                                    <a class="btn btn-effect" href="{{ route('front.contact') }}">
                                        <span>Get Started</span>
                                        <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_59_256)"><path d="M19.4854 11.4293L17.0513 12.221C13.1214 13.4993 10.3036 16.9595 9.84784 21.0668C9.49371 16.981 6.71926 13.5081 2.81255 12.2604L0.210283 11.4293" stroke="white" stroke-width="2"/><path d="M9.83594 20.8889L9.83594 0" stroke="white" stroke-width="2"/></g><defs><clipPath id="clip0_59_256"><rect width="21.3333" height="20" fill="white" transform="translate(20) rotate(90)"/></clipPath></defs></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="steps-wrapper">
                                @foreach ($steps as $step)
                                    <div class="steps-item">
                                        <div class="step-arrow">
                                            <a class="btn-arrow" href="#"><svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_923_133)"><path d="M8.70801 0.959961L9.29825 2.7665C10.2512 5.68321 12.8308 7.77453 15.8928 8.1128C12.8468 8.37564 10.2578 10.4348 9.3276 13.3343L8.70801 15.2657" stroke="inherit" stroke-width="2"/><path d="M15.7602 8.12158H0.1875" stroke="inherit" stroke-width="2"/></g><defs><clipPath id="clip0_923_133"><rect width="15.904" height="14.8437" fill="inherit" transform="translate(0.1875 0.578125)"/></clipPath></defs></svg></a>
                                        </div>
                                        <div class="step-info">
                                            <span class="step-number">{{ $step['number'] }}</span>
                                            <h3 class="step-title">{{ $step['title'] }}</h3>
                                            <p>{{ $step['description'] }}</p>
                                            <div class="list-wrapper list-style-2">
                                                <ul class="step-list list col-2">
                                                    @foreach ($step['list'] as $item)
                                                        <li><i class="fa-solid fa-check"></i>{{ $item }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
