@php
    $contact = DB::table('contact_pages')->first();
    $footer = DB::table('footers')->first();
    $socials = DB::table('footer_social_links')->get();
    $pages = DB::table('custom_pages')->where('status', 1)->get();
    $siteInfo = siteInfo();

    $contactDescription = optional($contact)->description;
    $contactDescription = $contactDescription
        ? preg_replace(
            '/\\s+/u',
            ' ',
            trim(strip_tags(html_entity_decode($contactDescription, ENT_QUOTES, 'UTF-8')))
        )
        : null;
    $contactAddress = optional($contact)->address
        ?? optional($footer)->address
        ?? trim((optional($siteInfo)->address_1 ?? '') . ' ' . (optional($siteInfo)->address_2 ?? ''));
    $contactPhone = optional($contact)->phone
        ?? optional($footer)->phone
        ?? (optional($siteInfo)->topbar_phone ?? null);
    $contactEmail = optional($contact)->email
        ?? optional($footer)->email
        ?? (optional($siteInfo)->contact_email ?? optional($siteInfo)->topbar_email ?? null);
    $callCenterTitle = optional($footer)->third_column ?? 'Call Center';
    $callCenterNote = !empty($contactDescription)
        ? \Illuminate\Support\Str::limit($contactDescription, 80)
        : 'and get a free estimate';
    $footerCopyright = optional($footer)->copyright ?? 'Design By Blacktech Developer';
@endphp

<footer class="site-footer footer-dark">
    <div class="footer-main">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-md-5">
                    <div class="widget widget-address-info">
                        <h5 class="widget-title">Where To Find Us</h5>
                        <ul class="address-info-list">
                            @if (!empty($contactAddress))
                                <li><i class="icon"><img class="img-fluid" src="{{ asset('frontend/assets/images/svg/address-info-contacts.svg') }}" alt="" /></i><span class="info"><span>{{ $contactAddress }}</span></span></li>
                            @endif
                            @if (!empty($contactPhone))
                                <li><i class="icon"><img class="img-fluid" src="{{ asset('frontend/assets/images/svg/address-info-headphone.svg') }}" alt="" /></i><span class="info"><span>{{ $contactPhone }}</span></span></li>
                            @endif
                            @if (!empty($contactEmail))
                                <li><i class="icon"><img class="img-fluid" src="{{ asset('frontend/assets/images/svg/address-info-email.svg') }}" alt="" /></i><span class="info"><span>{{ $contactEmail }}</span></span></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-xl-5 col-md-7">
                    <div class="widget">
                        <h5 class="widget-title">Newsletter</h5>
                        <div class="widget widget-newsletter mb-4 pb-2">
                            <form class="newsletter-form">
                                <input type="text" class="form-control" placeholder="Enter Your Email">
                                <button type="submit" class="subscribe-btn"><i class="fa-solid fa-paper-plane"></i></button>
                            </form>
                        </div>
                        <div class="widget widget-menu">
                            <h6 class="widget-title">Quick Links</h6>
                            <ul class="list-unstyled list-col-3 mb-0">
                                <li><a href="{{ route('front.home') }}">Home</a></li>
                                <li><a href="{{ route('front.about-us') }}">About us</a></li>
                                <li><a href="{{ route('front.our-project') }}">Our Project</a></li>
                                <li><a href="{{ route('front.all.service') }}">Our Services</a></li>
                                <li><a href="{{ route('front.blog') }}">Blog</a></li>
                                <li><a href="{{ route('front.contact') }}">Contact</a></li>
                                @foreach($pages as $p)
                                    <li><a href="{{ route('front.customPages', [$p->slug]) }}">{{ $p->page_name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-12 ms-auto">
                    <div class="widget widget-info">
                        <h5 class="widget-title">{{ $callCenterTitle }}</h5>
                        @if (!empty($contactPhone))
                            <a class="number" href="tel:{{ $contactPhone }}">{{ $contactPhone }}</a>
                        @endif
                        @if (!empty($callCenterNote))
                            <h6 class="title">{{ $callCenterNote }}</h6>
                        @endif
                    </div>
                    <div class="widget-socail">
                        <ul class="socail-icon">
                            @foreach ($socials as $social)
                                <li><a href="{{ $social->link }}" target="_blank" rel="noopener"><i class="{{ $social->icon }}"></i></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <p><a class="footer-logo" href="{{ route('front.home') }}"><img class="img-fluid" src="{{ asset(optional($siteInfo)->logo ?? 'frontend/assets/images/logo.png') }}" alt="logo" width="15%" /></a></p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <p>{{ $footerCopyright }}</p>
                    <ul class="list-unstyled d-inline-flex gap-3 mb-0">
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="back-to-top">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
</div>
</div>

<script src="{{ asset('frontend/assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.appear.js') }}"></script>
<script src="{{ asset('frontend/assets/js/popper/popper.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/bootstrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/owl-carousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/swiper/swiper.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/swiperanimation/SwiperAnimation.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/shuffle/shuffle.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/magnific-popup/jquery.magnific-popup.js') }}"></script>
<script src="{{ asset('frontend/assets/js/counter/jquery.countTo.js') }}"></script>
<script src="{{ asset('frontend/assets/js/gsap.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/attractHover.js') }}"></script>
<script src="{{ asset('frontend/assets/js/lenis.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/custom.js') }}"></script>
<script>
    (function() {
        function insertConsultationCta() {
            var template = document.getElementById('consultation-cta-template');
            if (!template || !template.content) {
                return;
            }

            var wrappers = document.querySelectorAll('.content-wrapper, .main-wrapper');
            wrappers.forEach(function(wrapper) {
                var sections = Array.prototype.filter.call(wrapper.children, function(child) {
                    return child.tagName === 'SECTION' && !child.classList.contains('consultation-cta');
                });

                for (var index = 1; index < sections.length; index += 2) {
                    var insertAfter = sections[index];
                    var nextElement = insertAfter.nextElementSibling;
                    if (nextElement && nextElement.classList.contains('consultation-cta')) {
                        continue;
                    }
                    insertAfter.after(template.content.cloneNode(true));
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', insertConsultationCta);
        } else {
            insertConsultationCta();
        }
    })();
</script>

@include('sweetalert::alert')
@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
</body>

</html>
