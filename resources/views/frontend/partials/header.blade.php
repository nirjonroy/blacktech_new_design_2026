@php
    $isHome = request()->routeIs('front.home');
    $isService = request()->routeIs('front.all.service', 'front.shop', 'front.single.service', 'front.repair', 'front.industry', 'front.industry.all');
    $isProject = request()->routeIs('front.our-project', 'front.project.show');
    $isAbout = request()->routeIs('front.about-us');
    $isContact = request()->routeIs('front.contact', 'front.contact_us');
    $isBlog = request()->routeIs('front.blog', 'front.blog_details');
    $navServices = \App\Models\Product::where('status', 1)
        ->orderBy('id', 'desc')
        ->get(['id', 'name', 'slug']);
    $currentSlug = request()->route('slug');
@endphp
<header class="header header-default header-sticky header-absolute fixed-top">
    <div class="header-inner">
        <div class="site-logo">
            <a class="navbar-brand" href="{{ route('front.home') }}">
                <img class="img-fluid" src="{{ asset(siteInfo()->logo) }}" alt="logo" style="width: 150px;" />
            </a>
        </div>
        <div class="site-menu d-none d-xl-block">
            <ul class="main-menu">
                <li class="nav-item {{ $isHome ? 'active' : '' }}"><a class="nav-link {{ $isHome ? 'active' : '' }}" href="{{ route('front.home') }}">Home</a></li>
                <li class="nav-item {{ $isService ? 'active' : '' }}"><a class="nav-link" href="{{ route('front.all.service') }}">Our Services <i class="fa-solid fa-chevron-down"></i></a>
                    <ul class="submenu">
                        @foreach($navServices as $service)
                            <li>
                                <a class="nav-link {{ request()->routeIs('front.shop') && $currentSlug === $service->slug ? 'active' : '' }}" href="{{ route('front.shop', $service->slug) }}">
                                    {{ $service->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item {{ $isProject ? 'active' : '' }}"><a class="nav-link" href="{{ route('front.our-project') }}">Our Project</a></li>
                <li class="nav-item {{ $isAbout ? 'active' : '' }}"><a class="nav-link" href="{{ route('front.about-us') }}">About</a></li>
                <li class="nav-item {{ $isContact ? 'active' : '' }}"><a class="nav-link" href="{{ route('front.contact') }}">Contact</a></li>
                <li class="nav-item {{ $isBlog ? 'active' : '' }}"><a class="nav-link" href="{{ route('front.blog') }}">Blog</a></li>
            </ul>
        </div>

        <div class="site-action d-none d-xl-block">
            <div class="action-hamburger">
                <a class="hamburger" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                    <span class="hamburger-container">
                        <span class="hamburger-inner"></span>
                        <span class="hamburger-hidden"></span>
                    </span>
                </a>
            </div>
        </div>

        <div class="mobile-action d-block d-xl-none">
            <div class="mobile-hamburger">
                <a class="hamburger" href="#" data-bs-toggle="offcanvas" data-bs-target="#menuOffcanvas" aria-controls="menuOffcanvas">
                    <span class="hamburger-container">
                        <span class="hamburger-inner"></span>
                        <span class="hamburger-hidden"></span>
                    </span>
                </a>
            </div>
        </div>
    </div>
</header>

<div class="offcanvas main-menu-offcanvas offcanvas-end" tabindex="-1" id="menuOffcanvas" aria-labelledby="menuOffcanvasLabel">
    <div class="offcanvas-header">
        <a id="menuOffcanvasLabel" class="navbar-brand" href="{{ route('front.home') }}">
            <img class="img-fluid" src="{{ asset(siteInfo()->logo) }}" alt="logo" />
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="offcanvas-body lenis-scroll-disable">
        <div class="body-inner">
            <nav class="navbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ $isHome ? 'active' : '' }}" href="{{ route('front.home') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ $isService ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Our Services</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ request()->routeIs('front.all.service') ? 'active' : '' }}" href="{{ route('front.all.service') }}">All Services</a></li>
                            @foreach($navServices as $service)
                                <li>
                                    <a class="dropdown-item {{ request()->routeIs('front.shop') && $currentSlug === $service->slug ? 'active' : '' }}" href="{{ route('front.shop', $service->slug) }}">
                                        {{ $service->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link {{ $isProject ? 'active' : '' }}" href="{{ route('front.our-project') }}">Our Project</a></li>
                    <li class="nav-item"><a class="nav-link {{ $isAbout ? 'active' : '' }}" href="{{ route('front.about-us') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link {{ $isContact ? 'active' : '' }}" href="{{ route('front.contact') }}">Contact</a></li>
                    <li class="nav-item"><a class="nav-link {{ $isBlog ? 'active' : '' }}" href="{{ route('front.blog') }}">Blog</a></li>
                </ul>
            </nav>
            <div class="bottom-info">
                <div class="contact-info">
                    @php
                        $contact = DB::table('contact_pages')->first();
                    @endphp
                    @if ($contact && $contact->phone)
                        <span class="number">{{ $contact->phone }}</span>
                    @endif
                    @if ($contact && $contact->email)
                        <a class="mail" href="mailto:{{ $contact->email }}"><i class="fa-regular fa-envelope"></i>{{ $contact->email }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end sidepanel-offcanvas" tabindex="-1" id="offcanvasRight">
    <div class="offcanvas-header">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
    </div>

    <div class="offcanvas-body lenis-scroll-disable">
        <div class="body-inner">
            @php
                $socials = DB::table('footer_social_links')->get();
                $contact = $contact ?? DB::table('contact_pages')->first();
                $aboutPanel = DB::table('about_us')->first();
            @endphp
            @if ($aboutPanel && !empty($aboutPanel->about_us))
                <div class="about-info">
                    <h4 class="title mb-3">About Us</h4>
                    <p>{{ \Illuminate\Support\Str::limit(strip_tags($aboutPanel->about_us), 160) }}</p>
                </div>
            @endif
            <div class="socail-info">
                <ul class="socail-list-item">
                    @foreach ($socials as $social)
                        @php
                            $iconClass = trim($social->icon ?? '');
                            $iconLower = strtolower($iconClass);
                            $label = 'Social';

                            if (\Illuminate\Support\Str::contains($iconLower, 'facebook')) {
                                $label = 'Facebook';
                            } elseif (\Illuminate\Support\Str::contains($iconLower, 'instagram')) {
                                $label = 'Instagram';
                            } elseif (\Illuminate\Support\Str::contains($iconLower, 'twitter') || \Illuminate\Support\Str::contains($iconLower, 'x-')) {
                                $label = 'Twitter';
                            } elseif (\Illuminate\Support\Str::contains($iconLower, 'dribbble')) {
                                $label = 'Dribbble';
                            } elseif (\Illuminate\Support\Str::contains($iconLower, 'linkedin')) {
                                $label = 'LinkedIn';
                            } elseif (\Illuminate\Support\Str::contains($iconLower, 'youtube')) {
                                $label = 'YouTube';
                            } elseif (!empty($social->link)) {
                                $host = parse_url($social->link, PHP_URL_HOST);
                                if (!empty($host)) {
                                    $host = preg_replace('/^www\\./', '', $host);
                                    $label = ucfirst(preg_replace('/\\..*/', '', $host));
                                }
                            }
                        @endphp
                        <li><a href="{{ $social->link }}" target="blink"><i class="{{ $iconClass }}"></i>{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="contact-info">
                @if ($contact && $contact->phone)
                    <span class="number">{{ $contact->phone }}</span>
                @endif
                @if ($contact && $contact->email)
                    <a class="mail" href="mailto:{{ $contact->email }}"><i class="fa-regular fa-envelope"></i>{{ $contact->email }}</a>
                @endif
            </div>
        </div>
    </div>
</div>
