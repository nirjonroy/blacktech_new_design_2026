@php
    $contact = DB::table('contact_pages')->first();
    $socials = DB::table('footer_social_links')->get();
    $pages = DB::table('custom_pages')->where('status', 1)->get();
    $blogs = DB::table('blogs')->limit(2)->latest()->get();
@endphp

<footer class="site-footer footer-dark">
    <div class="footer-main">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <div class="section-title">
                        <h2 class="title">Feel Free To Contatct Us</h2>
                    </div>
                    <a class="btn btn-effect" href="{{ route('front.contact') }}">
                        <span>Contact Us</span>
                        <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_59_256)"><path d="M19.4854 11.4293L17.0513 12.221C13.1214 13.4993 10.3036 16.9595 9.84784 21.0668C9.49371 16.981 6.71926 13.5081 2.81255 12.2604L0.210283 11.4293" stroke="white" stroke-width="2"/><path d="M9.83594 20.8889L9.83594 0" stroke="white" stroke-width="2"/></g><defs><clipPath id="clip0_59_256"><rect width="21.3333" height="20" fill="white" transform="translate(20) rotate(90)"/></clipPath></defs></svg>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3 col-md-5">
                    <div class="widget widget-address-info">
                        <h5 class="widget-title">Contact Information</h5>
                        <ul class="address-info-list">
                            @if ($contact && $contact->phone)
                                <li><i class="icon"><img class="img-fluid" src="{{ asset('frontend/assets/images/svg/address-info-headphone.svg') }}" alt="" /></i><span class="info"><span>{{ $contact->phone }}</span></span></li>
                            @endif
                            @if ($contact && $contact->email)
                                <li><i class="icon"><img class="img-fluid" src="{{ asset('frontend/assets/images/svg/address-info-email.svg') }}" alt="" /></i><span class="info"><span>{{ $contact->email }}</span></span></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-xl-5 col-md-7">
                    <div class="widget">
                        <h5 class="widget-title">Newsletter</h5>
                        <p class="mb-3">keep up to date - get updates with latest topics.</p>
                        <div class="widget widget-newsletter mb-4 pb-2">
                            <form class="newsletter-form">
                                <input type="text" class="form-control" placeholder="Enter your email address">
                                <button type="submit" class="subscribe-btn">Subscribe Now <i class="fa-solid fa-paper-plane"></i></button>
                            </form>
                        </div>
                        <div class="widget widget-menu">
                            <h6 class="widget-title">Quick Link</h6>
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
                        <div class="widget widget-recent-post mt-4">
                            <h6 class="widget-title">Resent Post</h6>
                            <div class="recent-post-list">
                                @foreach($blogs as $b)
                                    <a href="{{ route('front.blog_details', [$b->slug]) }}" class="d-flex align-items-center mb-3 text-decoration-none">
                                        <div class="me-3">
                                            <img class="img-fluid" src="{{ asset($b->image) }}" alt="{{ $b->title }}">
                                        </div>
                                        <div>
                                            <h6 class="mb-1 text-white">{{ $b->title }}</h6>
                                            <span class="text-white-50 d-flex align-items-center"><i class="fa-regular fa-clock me-2"></i>{{ date('d/m/Y', strtotime($b->created_at)) }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-12 ms-auto">
                    <div class="widget">
                        <a href="{{ route('front.home') }}" class="d-inline-block mb-4">
                            <img class="img-fluid" src="{{ asset(siteInfo()->logo) }}" alt="logo" style="max-width: 120px;">
                        </a>
                    </div>
                    <div class="widget-socail">
                        <ul class="socail-icon">
                            @foreach ($socials as $social)
                                <li><a href="{{ $social->link }}" target="blink"><i class="{{ $social->icon }}"></i></a></li>
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
                    <p><a class="footer-logo" href="{{ route('front.home') }}"><img class="img-fluid" src="{{ asset(siteInfo()->logo) }}" alt="logo" width="15%" /></a></p>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <p>Design By Blacktech Developer</p>
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

@include('sweetalert::alert')
@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
</body>

</html>
