@extends('frontend.app')

@php
    $SeoSettings = DB::table('seo_settings')
        ->whereRaw('LOWER(page_name) = ?', ['team'])
        ->first();
    $siteName = optional($SeoSettings)->site_name ?? config('app.name', 'Blacktech');
    $title = optional($SeoSettings)->meta_title ?? optional($SeoSettings)->seo_title ?? 'Our Team';
    $descriptionSource = optional($SeoSettings)->meta_description ?? optional($SeoSettings)->seo_description ?? '';
    $desc = \Illuminate\Support\Str::limit(strip_tags($descriptionSource), 180);
    $url = url()->current();
    $metaImagePath = optional($SeoSettings)->meta_image;
    $metaImage = $metaImagePath
        ? asset($metaImagePath)
        : (siteInfo()->logo ? asset(siteInfo()->logo) : asset('images/og-default.jpg'));
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

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $desc }}">
    <meta property="og:url" content="{{ $url }}">
    <meta property="og:image" content="{{ $metaImage }}">
    <meta property="og:image:secure_url" content="{{ $metaImage }}">
    <meta property="og:image:alt" content="{{ $title }}">
    <meta property="og:locale" content="en_US">
    @if ($publisher)
    <meta property="article:publisher" content="{{ $publisher }}">
    @endif
    @if ($author)
    <meta property="article:author" content="{{ $author }}">
    @endif

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $title }}">
    <meta name="twitter:description" content="{{ $desc }}">
    <meta name="twitter:url" content="{{ $url }}">
    <meta name="twitter:image" content="{{ $metaImage }}">
@endsection

@section('content')
<div class="site-content">
    @php
        $headerImage = $metaImagePath ? asset($metaImagePath) : null;
        $headerTitle = $title ?? 'Our Team';
        $headerDescription = \Illuminate\Support\Str::limit(strip_tags($desc ?? ''), 120);
        if (empty($headerDescription)) {
            $headerDescription = 'Meet the experts who help brands grow with confidence.';
        }
        $teamMembers = collect($teamMembers ?? []);
        $teamFallbackImage = $teamFallbackImage ?? 'frontend/assets/images/team/01.jpg';
        $teamFallbackImage = asset($teamFallbackImage);
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
        <section class="space-ptb bg-black z-index-2">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="section-title text-center">
                            <span class="sub-title justify-content-center"><img class="img-fluid" src="{{ asset(optional(siteInfo())->favicon ?? 'frontend/assets/images/favicon.ico') }}" alt=""> Our Experts</span>
                            <h2 class="title">Meet the people behind the results.</h2>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="grid-wrapper grid-xl-3 grid-lg-3 grid-md-2 grid-sm-1">
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
                                <h2 class="title">Trusted by teams who value results.</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-start">
                        <div class="col-md-11">
                            @if (!empty($testimonials) && $testimonials->isNotEmpty())
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
