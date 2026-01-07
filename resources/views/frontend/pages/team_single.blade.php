@extends('frontend.app')

@section('title', $member->name ?? 'Team Member')

@section('content')
<div class="site-content">
    @php
        $headerImage = 'frontend/assets/images/banner/inner-header/page-header-01.jpg';
        if (!file_exists(public_path($headerImage))) {
            $headerImage = 'frontend/assets/images/banner/banner-01/banner-bg-01.png';
        }
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
