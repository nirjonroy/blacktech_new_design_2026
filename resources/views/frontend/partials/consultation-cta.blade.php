@php
    $contactCta = $contactCta ?? DB::table('contact_pages')->first();
    $siteInfo = $siteInfo ?? siteInfo();
    $ctaTitle = trim(optional($contactCta)->title ?? '') ?: 'Schedule A Free Consultation Today.';
    $ctaSubtitleSource = trim(strip_tags(optional($contactCta)->description ?? ''));
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
                    @if (!empty($ctaSubtitle))
                        <span class="consultation-cta__subtitle">{{ $ctaSubtitle }}</span>
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
