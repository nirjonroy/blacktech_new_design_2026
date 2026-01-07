@extends('frontend.app')

@php
    $pageTitle = $career->meta_title ?: ($career->title ?? 'Career Details');
    $rawDescription = $career->meta_description ?: ($career->short_description ?? '');
    $pageDescription = \Illuminate\Support\Str::limit(strip_tags($rawDescription), 180);
    $pageKeywords = $career->meta_keywords ?? '';
    $pageUrl = url()->current();
    $metaImagePath = !empty($career->image) ? $career->image : (siteInfo()->logo ?? null);
    $metaImage = $metaImagePath ? asset($metaImagePath) : asset('images/og-default.jpg');
    $siteName = config('app.name', 'Blacktech');
@endphp

@section('title', $pageTitle)

@section('seos')
    <meta charset="UTF-8">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="title" content="{{ $pageTitle }}">
    <meta name="description" content="{{ $pageDescription }}">
    @if (!empty($pageKeywords))
        <meta name="keywords" content="{{ $pageKeywords }}">
    @endif
    <link rel="canonical" href="{{ $pageUrl }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ $pageUrl }}">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="website">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="628">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    <meta name="twitter:url" content="{{ $pageUrl }}">
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
        $jobTitle = $career->title ?? 'Career Details';
        $jobType = $career->employment_type ?? 'Full Time';
        $jobLocation = $career->location ?? 'Remote';
        $jobExperience = $career->experience ?? 'N/A';
        $jobSalary = $career->salary ?? 'Negotiable';
        $jobDeadline = $career->deadline ? $career->deadline->format('d M Y') : 'Open';
        $jobImage = !empty($career->image) ? asset($career->image) : asset('frontend/assets/images/about/about-01.jpg');
        $shortDescription = $career->short_description ?? '';
        $applyUrl = $career->apply_url ?? null;
        $applyEmail = $career->apply_email ?? null;
        $applyDetails = $career->apply_details ?? null;
        $keywords = array_values(array_filter(array_map('trim', explode(',', $career->meta_keywords ?? ''))));
        $responsibilities = preg_split('/\r\n|\r|\n/', $career->key_responsibilities ?? '');
        $requirements = preg_split('/\r\n|\r|\n/', $career->requirements ?? '');
        $whyJoin = preg_split('/\r\n|\r|\n/', $career->why_join_us ?? '');
    @endphp

    <div class="inner-header bg-holder" style="background-image: url('{{ asset($headerImage) }}');">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <h1 class="title">{{ $jobTitle }}</h1>
                    <p>{{ $jobType }} • {{ $jobLocation }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <section class="space-ptb ellipse-bottom">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="section-title mb-4">
                            <h3 class="title mb-2">{{ $jobTitle }}</h3>
                            <p>{{ $shortDescription }}</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-5 mb-4 mb-md-0">
                        <img class="img-fluid rounded" src="{{ $jobImage }}" alt="{{ $jobTitle }}" />
                        <div class="mt-4">
                            <div class="job-time mb-2">{{ $jobType }}</div>
                            <div class="job-location mb-2">Location : <span>{{ $jobLocation }}</span></div>
                            <div class="job-info">
                                <div class="info-item info-experience mb-2">Experience : <span>{{ $jobExperience }}</span></div>
                                <div class="info-item info-salary mb-2">Salary : <span>{{ $jobSalary }}</span></div>
                                <div class="info-item info-deadline mb-2">Deadline : <span>{{ $jobDeadline }}</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-7 ps-3 ps-md-5">
                        <div class="mb-4">
                            <h4 class="title">Key Responsibilities</h4>
                            @if (!empty(array_filter($responsibilities)))
                                <div class="list-wrapper list-style-2">
                                    <ul class="list">
                                        @foreach ($responsibilities as $item)
                                            @if (!empty(trim($item)))
                                                <li><i class="fa-solid fa-check"></i>{{ trim($item) }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <p>No responsibilities listed yet.</p>
                            @endif
                        </div>
                        <div class="mb-4">
                            <h4 class="title">Requirements</h4>
                            @if (!empty(array_filter($requirements)))
                                <div class="list-wrapper list-style-2">
                                    <ul class="list">
                                        @foreach ($requirements as $item)
                                            @if (!empty(trim($item)))
                                                <li><i class="fa-solid fa-check"></i>{{ trim($item) }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <p>No requirements listed yet.</p>
                            @endif
                        </div>
                        <div class="mb-4">
                            <h4 class="title">Why Join Us</h4>
                            @if (!empty(array_filter($whyJoin)))
                                <div class="list-wrapper list-style-2">
                                    <ul class="list">
                                        @foreach ($whyJoin as $item)
                                            @if (!empty(trim($item)))
                                                <li><i class="fa-solid fa-check"></i>{{ trim($item) }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <p>We offer a collaborative environment and meaningful growth opportunities.</p>
                            @endif
                        </div>
                        @if (!empty($keywords))
                            <div class="mb-4">
                                <h4 class="title">Keywords</h4>
                                <div class="list-wrapper list-style-2">
                                    <ul class="list">
                                        @foreach ($keywords as $keyword)
                                            <li><i class="fa-solid fa-check"></i>{{ $keyword }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        <div class="mb-4">
                            <h4 class="title">Apply Now</h4>
                            @if (!empty($applyDetails))
                                <p>{{ $applyDetails }}</p>
                            @endif
                            <div class="d-flex flex-wrap gap-3">
                                @if (!empty($applyUrl))
                                    <a class="btn btn-effect" href="{{ $applyUrl }}" target="_blank" rel="noopener">
                                        <span>Apply via Link</span>
                                        <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_59_253)"><path d="M19.4854 11.4293L17.0513 12.221C13.1214 13.4993 10.3036 16.9595 9.84784 21.0668C9.49371 16.981 6.71926 13.5081 2.81255 12.2604L0.210283 11.4293" stroke="white" stroke-width="2"/><path d="M9.83594 20.8889L9.83594 0" stroke="white" stroke-width="2"/></g><defs><clipPath id="clip0_59_253"><rect width="21.3333" height="20" fill="white" transform="translate(20) rotate(90)"/></clipPath></defs></svg>
                                    </a>
                                @endif
                                @if (!empty($applyEmail))
                                    <a class="btn btn-effect" href="mailto:{{ $applyEmail }}">
                                        <span>Apply via Email</span>
                                        <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_59_253)"><path d="M19.4854 11.4293L17.0513 12.221C13.1214 13.4993 10.3036 16.9595 9.84784 21.0668C9.49371 16.981 6.71926 13.5081 2.81255 12.2604L0.210283 11.4293" stroke="white" stroke-width="2"/><path d="M9.83594 20.8889L9.83594 0" stroke="white" stroke-width="2"/></g><defs><clipPath id="clip0_59_253"><rect width="21.3333" height="20" fill="white" transform="translate(20) rotate(90)"/></clipPath></defs></svg>
                                    </a>
                                @endif
                                @if (empty($applyUrl) && empty($applyEmail))
                                    <a class="btn btn-effect" href="{{ route('front.contact') }}">
                                        <span>Contact Us</span>
                                        <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_59_253)"><path d="M19.4854 11.4293L17.0513 12.221C13.1214 13.4993 10.3036 16.9595 9.84784 21.0668C9.49371 16.981 6.71926 13.5081 2.81255 12.2604L0.210283 11.4293" stroke="white" stroke-width="2"/><path d="M9.83594 20.8889L9.83594 0" stroke="white" stroke-width="2"/></g><defs><clipPath id="clip0_59_253"><rect width="21.3333" height="20" fill="white" transform="translate(20) rotate(90)"/></clipPath></defs></svg>
                                    </a>
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
