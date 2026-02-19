@extends('frontend.app')

@php
    $siteName = config('app.name', 'Blacktech');
    $metaTitle = $member->meta_title ?? $member->name ?? 'Team Member';
    $rawDescription = $member->meta_description ?? $member->biography ?? '';
    $metaDescription = \Illuminate\Support\Str::limit(trim(strip_tags($rawDescription)), 180);
    if (empty($metaDescription)) {
        $metaDescription = \Illuminate\Support\Str::limit($metaTitle, 160, '');
    }
    $primaryImage = !empty($member->image)
        ? asset($member->image)
        : (!empty($member->meta_image) ? asset($member->meta_image) : null);
    $metaImage = $primaryImage ?? asset('images/og-default.jpg');
    $author = $member->author ?? 'Blacktech';
    $publisher = $member->publisher ?? $siteName;
    $copyright = $member->copyright ?? null;
    $keywords = $member->keywords ?? null;
    $canonical = url()->current();
@endphp

@section('title', $metaTitle)

@section('seos')
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

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ $canonical }}">
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

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:url" content="{{ $canonical }}">
    <meta name="twitter:image" content="{{ $metaImage }}">
@endsection

@section('content')
<div class="site-content">
    @php
        $headerImage = 'frontend/assets/images/banner/inner-header/page-header-01.jpg';
        if (!file_exists(public_path($headerImage))) {
            $headerImage = 'frontend/assets/images/banner/banner-01/banner-bg-01.png';
        }
        $headerImage = !empty($member->meta_image) ? $member->meta_image : $headerImage;
        $memberName = $member->name ?? 'Team Member';
        $memberRole = $member->designation ?? null;
        $fallbackImagePath = $teamFallbackImage ?? 'frontend/assets/images/team/01.jpg';
        $memberImage = !empty($member->image) ? asset($member->image) : asset($fallbackImagePath);
        $memberBio = $member->biography ?? null;
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

    <div class="inner-header bg-holder" style="background-image: url('{{ asset($headerImage) }}');">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <h1 class="title">{{ $memberName }}</h1>
                    @if (!empty($memberRole))
                        <p>{{ $memberRole }}</p>
                    @endif
                    @include('frontend.partials.banner-cta')
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
                            <h3 class="title mb-2">{{ $memberName }}</h3>
                            @if (!empty($memberRole))
                                <p>{{ $memberRole }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-5">
                        <div class="team-style-1">
                            <img class="img-fluid rounded" src="{{ $memberImage }}" alt="{{ $memberName }}" />
                            @if (!empty($socialLinks))
                                <div class="team-social d-flex justify-content-end">
                                    <ul>
                                        @foreach ($socialLinks as $link)
                                            <li><a href="{{ $link['url'] }}" target="_blank" rel="noopener">{{ $link['label'] }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-7 ps-3 ps-md-5 mt-5 mt-md-0">
                        <h4 class="title">Biography</h4>
                        @if (!empty($memberBio))
                            <p>{!! nl2br(e($memberBio)) !!}</p>
                        @else
                            <p>Biography is not available yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
