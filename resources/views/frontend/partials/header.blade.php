<header class="header header-default header-sticky header-absolute fixed-top">
    <div class="header-inner">
        <div class="site-logo">
            <a class="navbar-brand" href="{{ route('front.home') }}">
                <img class="img-fluid" src="{{ asset(siteInfo()->logo) }}" alt="logo" style="width: 150px;" />
            </a>
        </div>
        <div class="site-menu d-none d-xl-block">
            <ul class="main-menu">
                <li class="nav-item active"><a class="nav-link" href="{{ route('front.home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('front.all.service') }}">Our Services <i class="fa-solid fa-chevron-down"></i></a>
                    <ul class="submenu">
                        @foreach(categories() as $item)
                            <li><a class="nav-link" href="{{ route('front.shop', $item->slug) }}">{{ $item->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('front.industry.all') }}">Industries <i class="fa-solid fa-chevron-down"></i></a>
                    <ul class="submenu">
                        @php
                            $industries = DB::table('child_categories')->where('status', 1)->get();
                        @endphp
                        @foreach ($industries as $indu)
                            <li><a class="nav-link" href="{{ route('front.industry', $indu->slug) }}">{{ $indu->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('front.our-project') }}">Our Project</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('front.about-us') }}">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('front.blog') }}">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('front.contact') }}">Contact</a></li>
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
                        <a class="nav-link" href="{{ route('front.home') }}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Our Services</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('front.all.service') }}">All Services</a></li>
                            @foreach(categories() as $item)
                                <li><a class="dropdown-item" href="{{ route('front.shop', $item->slug) }}">{{ $item->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Industries</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('front.industry.all') }}">All Industries</a></li>
                            @php
                                $industries = DB::table('child_categories')->where('status', 1)->get();
                            @endphp
                            @foreach ($industries as $indu)
                                <li><a class="dropdown-item" href="{{ route('front.industry', $indu->slug) }}">{{ $indu->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('front.our-project') }}">Our Project</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('front.about-us') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('front.blog') }}">Blog</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('front.contact') }}">Contact</a></li>
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
            <div class="socail-info">
                <ul class="socail-list-item">
                    @php
                        $socials = DB::table('footer_social_links')->get();
                    @endphp
                    @foreach ($socials as $social)
                        <li><a href="{{ $social->link }}" target="blink"><i class="{{ $social->icon }}"></i></a></li>
                    @endforeach
                </ul>
            </div>
            <div class="contact-info">
                @php
                    $contact = $contact ?? DB::table('contact_pages')->first();
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
