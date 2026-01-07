@php
    $contactCta = $contactCta ?? DB::table('contact_pages')->first();
    $siteInfo = $siteInfo ?? siteInfo();
    $ctaTitleSource = trim(html_entity_decode(strip_tags(optional($contactCta)->title ?? ''), ENT_QUOTES, 'UTF-8'));
    $ctaTitleSource = preg_replace('/\s+/', ' ', $ctaTitleSource);
    $ctaTitle = $ctaTitleSource;
    if ($ctaTitle === '' || preg_match('/^contact( information| us)?$/i', $ctaTitleSource)) {
        $ctaTitle = 'Schedule A Free Consultation Today.';
    }
    $ctaSubtitleSource = trim(html_entity_decode(strip_tags(optional($contactCta)->description ?? ''), ENT_QUOTES, 'UTF-8'));
    $ctaSubtitleSource = preg_replace('/\s+/', ' ', $ctaSubtitleSource);
    $ctaSubtitle = $ctaSubtitleSource
        ? \Illuminate\Support\Str::limit($ctaSubtitleSource, 120)
        : 'No Fee Unless You Win.';
    $ctaPhone = optional($contactCta)->phone ?? optional($siteInfo)->topbar_phone ?? null;
    $ctaPhoneHref = $ctaPhone ? preg_replace('/[^0-9+]/', '', $ctaPhone) : null;
@endphp

@if (!empty($ctaTitle) || !empty($ctaSubtitle) || !empty($ctaPhone))
    <section class="consultation-cta">
        <div class="container">
            <div class="consultation-cta__content">
                <p class="consultation-cta__text">
                    @if (!empty($ctaTitle))
                        <span>{{ $ctaTitle }}</span>
                    @endif
                    @if (!empty($ctaPhone))
                        <span class="consultation-cta__call">
                            Call
                            <a href="tel:{{ $ctaPhoneHref }}">{{ $ctaPhone }}</a>
                        </span>
                    @endif
                </p>
            </div>
        </div>
    </section>
@endif
