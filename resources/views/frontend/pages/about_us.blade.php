@extends('frontend.app')

@push('css')
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
        $headerImage = 'frontend/assets/images/banner/inner-header/page-header-01.jpg';
        if (!file_exists(public_path($headerImage))) {
            $headerImage = 'frontend/assets/images/banner/banner-01/banner-bg-01.png';
        }
        $headerTitle = 'About ' . ($siteName ?? 'Blacktech');
        $headerDescription = \Illuminate\Support\Str::limit(strip_tags($about_us->description_three ?? $desc ?? ''), 140);
        if (empty($headerDescription)) {
            $headerDescription = 'Our Expertise. Know more about what we do';
        }
        $aboutImagePath = !empty($about_us->video_background)
            ? $about_us->video_background
            : optional(\App\Models\Slider::select('image')->where('status', 1)->first())->image;
        $aboutImage = $aboutImagePath ? asset($aboutImagePath) : null;
        $aboutTextColClass = $aboutImage ? 'col-lg-7' : 'col-12';
        $historyIntro = \Illuminate\Support\Str::limit(strip_tags($about_us->description_three ?? $about_us->about_us ?? ''), 240);
        $now = now();
        $historyItems = [];
        if (!empty($about_us->description_three)) {
            $historyItems[] = [
                'year' => $now->year,
                'content' => \Illuminate\Support\Str::limit(strip_tags($about_us->description_three), 320),
            ];
        }
        if (!empty($about_us->about_us)) {
            $historyItems[] = [
                'year' => $now->copy()->subYear()->year,
                'content' => \Illuminate\Support\Str::limit(strip_tags($about_us->about_us), 320),
            ];
        }
        if (empty($historyItems)) {
            $historyItems[] = [
                'year' => $now->year,
                'content' => 'We are focused on delivering measurable results and long-term partnerships.',
            ];
        }
        $teamMembers = collect($teamMembers ?? []);
        $teamFallbackImagePath = $teamFallbackImage ?? 'frontend/assets/images/team/01.jpg';
        $teamFallbackImage = asset($teamFallbackImagePath);
        $staffMembers = [
            [
                'name' => 'Blacktech Team',
                'role' => 'Strategy',
                'image' => 'frontend/assets/images/team/01.jpg',
            ],
            [
                'name' => 'Blacktech Team',
                'role' => 'Design',
                'image' => 'frontend/assets/images/team/02.jpg',
            ],
            [
                'name' => 'Blacktech Team',
                'role' => 'Development',
                'image' => 'frontend/assets/images/team/03.jpg',
            ],
            [
                'name' => 'Blacktech Team',
                'role' => 'Marketing',
                'image' => 'frontend/assets/images/team/04.jpg',
            ],
        ];
        $testimonials = $testimonials ?? \App\Models\Testimonial::where('status', 1)->get();
        $normalizeSocialUrl = function ($value, $type = null) {
            if (empty($value)) {
                return null;
            }
            $value = trim($value);
            if ($type === 'whatsapp') {
                if (preg_match('/^https?:\/\//i', $value)) {
                    return $value;
                }
                $number = preg_replace('/[^0-9]/', '', $value);
                return $number ? 'https://wa.me/' . $number : null;
            }
            if (!preg_match('/^https?:\/\//i', $value)) {
                return 'https://' . ltrim($value, '/');
            }
            return $value;
        };
    @endphp

    <div class="inner-header bg-holder" style="background-image: url('{{ asset($headerImage) }}');">
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
        <section class="space-pt z-index-2">
            <div class="container">
                <div class="section-title pb-0 pb-lg-4">
                    <span class="sub-title"><img class="img-fluid" src="{{ asset(optional(siteInfo())->favicon ?? 'frontend/assets/images/favicon.ico') }}" alt=""> About Us</span>
                    <h2 class="title">Your Experience Is Everything To Us</h2>
                </div>
                <div class="row justify-content-between">
                    <div class="{{ $aboutTextColClass }} mb-5 mb-lg-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="mt-3">
                                    {!! $about_us->about_us !!}
                                </div>
                                <div class="d-flex justify-content-center mt-5 ms-sm-5 ms-0">
                                    <a class="btn btn-effect" href="{{ route('front.about-us') }}">
                                        <span>About Us</span>
                                        <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_59_253)"><path d="M19.4854 11.4293L17.0513 12.221C13.1214 13.4993 10.3036 16.9595 9.84784 21.0668C9.49371 16.981 6.71926 13.5081 2.81255 12.2604L0.210283 11.4293" stroke="white" stroke-width="2"/><path d="M9.83594 20.8889L9.83594 0" stroke="white" stroke-width="2"/></g><defs><clipPath id="clip0_59_253"><rect width="21.3333" height="20" fill="white" transform="translate(20) rotate(90)"/></clipPath></defs></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4 mt-sm-5">
                            <div class="col-sm-6">
                                <div class="counter counter-style-1">
                                    <div class="counter-number"><span class="timer mb-0" data-to="240" data-speed="2000">240</span><span class="suffix">+</span></div>
                                    <div class="counter-info"><span class="counter-title">Business Peoples</span></div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="counter counter-style-1">
                                    <div class="counter-number"><span class="timer mb-0" data-to="100" data-speed="2000">100</span><span class="suffix">%</span></div>
                                    <div class="counter-info"><span class="counter-title">Customer Satisfaction</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($aboutImage)
                        <div class="col-lg-5">
                            <img class="img-fluid ps-lg-5 mt-3" src="{{ $aboutImage }}" alt="Blacktech Team">
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <div class="space-ptb">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-md-12">
                        <div class="marquee-wrapper">
                            @php
                                $marqueeServices = collect($services ?? []);
                                $marqueeFallback = collect([
                                    ['name' => 'Web Design', 'image' => 'frontend/assets/images/client-logo/brand-icon1.png'],
                                    ['name' => 'UI/UX Design', 'image' => 'frontend/assets/images/client-logo/brand-icon2.png'],
                                    ['name' => 'Developer', 'image' => 'frontend/assets/images/client-logo/brand-icon3.png'],
                                    ['name' => 'ISO Developer', 'image' => 'frontend/assets/images/client-logo/brand-icon4.png'],
                                    ['name' => 'Digital Agency', 'image' => 'frontend/assets/images/client-logo/brand-icon5.png'],
                                ]);
                                $marqueeItems = $marqueeServices->isNotEmpty() ? $marqueeServices : $marqueeFallback;
                            @endphp
                            <div class="marquee-inner">
                                @for ($repeat = 0; $repeat < 2; $repeat++)
                                    @foreach ($marqueeItems as $service)
                                        @php
                                            $serviceName = $service->name ?? ($service['name'] ?? 'Service');
                                            $serviceImagePath = $service->thumb_image ?? $service->image ?? ($service['image'] ?? null);
                                            $serviceImage = $serviceImagePath
                                                ? asset($serviceImagePath)
                                                : asset('frontend/assets/images/client-logo/brand-icon1.png');
                                        @endphp
                                        <div class="marquee-item">
                                            <span class="icon"><img class="img-fluid" src="{{ $serviceImage }}" alt="{{ $serviceName }}" /></span>
                                            <span class="title">{{ $serviceName }}</span>
                                        </div>
                                    @endforeach
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="space-pt bg-black ellipse-top">
            <div class="space-pb ellipse-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="sticky-top" style="top: 80px;">
                                <div class="section-title mb-0">
                                    <span class="sub-title"><img class="img-fluid" src="{{ asset(optional(siteInfo())->favicon ?? 'frontend/assets/images/favicon.ico') }}" alt="" /> Our History</span>
                                    <h2 class="title">Our History</h2>
                                </div>
                                @if (!empty($historyIntro))
                                    <p class="mb-5 mb-lg-0 ms-lg-5">{{ $historyIntro }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-7">
                            @foreach ($historyItems as $index => $item)
                                <div class="history-wrapper{{ $index ? ' mt-4 mb-4' : '' }}">
                                    <div class="history-year-sm">{{ $item['year'] }}</div>
                                    <div class="history-info">
                                        <div class="history-year-lg">{{ $item['year'] }}</div>
                                        <div class="history-content">
                                            <p>{{ $item['content'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="space-ptb bg-black z-index-2">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-6 col-lg-8">
                        <div class="section-title mb-lg-0">
                            <span class="sub-title"><img class="img-fluid" src="{{ asset(optional(siteInfo())->favicon ?? 'frontend/assets/images/favicon.ico') }}" alt=""> Our Staff</span>
                            <h2 class="title mb-0">Our team is friendly, talkative, and fully reliable.</h2>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-lg-4 align-self-end">
                        <p class="mb-0 ps-xxl-5">We build partnerships that grow with your business.</p>
                    </div>
                </div>

                <div class="row mt-xl-5 pt-5">
                    <div class="col-md-12">
                        <div class="team-boxs grid-wrapper grid-xl-4 grid-lg-3 grid-md-2 grid-sm-2 grid-xs-1">
                            @if ($teamMembers->isNotEmpty())
                                @foreach ($teamMembers as $member)
                                    @php
                                        $memberName = $member->name ?? 'Team Member';
                                        $memberRole = $member->designation ?? 'Team Member';
                                        $memberBio = !empty($member->biography)
                                            ? \Illuminate\Support\Str::limit(strip_tags($member->biography), 120)
                                            : null;
                                        $memberImage = !empty($member->image) ? asset($member->image) : $teamFallbackImage;
                                        $memberSlug = $member->slug ?? null;
                                        $memberUrl = !empty($memberSlug)
                                            ? route('front.team.member', $memberSlug)
                                            : 'javascript:void(0);';
                                        $socialLinks = [
                                            ['label' => 'Fb', 'url' => $normalizeSocialUrl($member->facebook ?? null)],
                                            ['label' => 'Ig', 'url' => $normalizeSocialUrl($member->instagram ?? null)],
                                            ['label' => 'Wa', 'url' => $normalizeSocialUrl($member->whatsapp ?? null, 'whatsapp')],
                                            ['label' => 'Web', 'url' => $normalizeSocialUrl($member->website ?? null)],
                                            ['label' => 'In', 'url' => $normalizeSocialUrl($member->linkedin ?? null)],
                                        ];
                                        $socialLinks = array_values(array_filter($socialLinks, function ($link) {
                                            return !empty($link['url']);
                                        }));
                                @endphp
                                    <div class="team-item team-style-1">
                                        <div class="team-img">
                                            <a href="{{ $memberUrl }}" aria-label="{{ $memberName }}">
                                                <img class="img-fluid" src="{{ $memberImage }}" alt="{{ $memberName }}" />
                                            </a>
                                        </div>
                                        <div class="team-info">
                                            <a href="{{ $memberUrl }}" class="team-title">{{ $memberName }}</a>
                                        <span class="team-destination">{{ $memberRole }}</span>
                                        @if (!empty($memberBio))
                                            <p class="team-bio">{{ $memberBio }}</p>
                                        @endif
                                        @if (!empty($socialLinks))
                                            <div class="team-social">
                                                <ul>
                                                    @foreach ($socialLinks as $link)
                                                        <li><a href="{{ $link['url'] }}" target="_blank" rel="noopener">{{ $link['label'] }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                @foreach ($staffMembers as $member)
                                    <div class="team-item team-style-1">
                                        <div class="team-img">
                                            <img class="img-fluid" src="{{ asset($member['image']) }}" alt="{{ $member['name'] }}" />
                                        </div>
                                        <div class="team-info">
                                            <a href="javascript:void(0);" class="team-title">{{ $member['name'] }}</a>
                                            <span class="team-destination">{{ $member['role'] }}</span>
                                            <div class="team-social">
                                                <ul>
                                                    <li><a href="javascript:void(0);">Fb</a></li>
                                                    <li><a href="javascript:void(0);">Dr</a></li>
                                                    <li><a href="javascript:void(0);">Tw</a></li>
                                                    <li><a href="javascript:void(0);">Be</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="space-pt testimonial-section overflow-hidden bg-black ellipse-top">
            <div class="space-pb ellipse-bottom">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="section-title text-center">
                                <span class="sub-title justify-content-center"><img class="img-fluid" src="{{ asset(optional(siteInfo())->favicon ?? 'frontend/assets/images/favicon.ico') }}" alt=""> Our Testimonial</span>
                                <h2 class="title">Over 500 clients and 5,000 projects across the globe.</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-start">
                        <div class="col-md-11">
                            @if ($testimonials->isNotEmpty())
                                <div class="owl-carousel slider-overflow" data-cursor-type="text" data-custom-text="Drag" data-nav-arrow="false" data-items="2" data-lg-items="1" data-md-items="1" data-sm-items="1" data-space="50">
                                    @foreach ($testimonials as $testimonial)
                                        @php
                                            $rating = (int) round($testimonial->rating ?? 0);
                                            $rating = max(0, min(5, $rating));
                                            $authorName = $testimonial->name ?? 'Client';
                                            $authorRole = $testimonial->designation ?? 'Client';
                                            $authorImage = !empty($testimonial->image) ? asset($testimonial->image) : $teamFallbackImage;
                                        @endphp
                                        <div class="item">
                                            <div class="testimonial-wrapper testimonial-style-2">
                                                <div class="testimonial-ratings">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="fa-{{ $i <= $rating ? 'solid' : 'regular' }} fa-star"></i>
                                                    @endfor
                                                </div>
                                                <div class="testimonial-quote"><img class="img-fluid" src="{{ asset('frontend/assets/images/quote-icon-01.png') }}" alt="" /></div>
                                                <div class="testimonial-content">
                                                    <p>{{ $testimonial->comment }}</p>
                                                </div>
                                                <div class="testimonial-author">
                                                    <div class="author-image">
                                                        <img class="img-fluid" src="{{ $authorImage }}" alt="{{ $authorName }}">
                                                    </div>
                                                    <div class="author-info">
                                                        <h6 class="author-name">{{ $authorName }}</h6>
                                                        <span class="author-position">{{ $authorRole }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

