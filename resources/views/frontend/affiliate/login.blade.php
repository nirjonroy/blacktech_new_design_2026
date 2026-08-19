@extends('frontend.app')
@section('title', 'Affiliate Login | Blacktech')
@section('content')
<div class="site-content">
    <div class="inner-header bg-holder">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <h1 class="title">Affiliate Login</h1>
                    <p>Access your affiliate dashboard and submit client details.</p>
                    <a href="{{ route('front.affiliate.rules') }}" class="btn btn-effect mt-3"><span>Rules & Prices</span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <section class="space-ptb z-index-2">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        @if (Session::has('messege'))
                            <div class="alert alert-{{ Session::get('alert-type') === 'error' ? 'danger' : 'success' }}">
                                {{ Session::get('messege') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                        <div class="form-wrapper">
                            <form class="contact-form form-style-border" action="{{ route('front.affiliate.login.submit') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input type="email" class="form-control" placeholder="Email Address" name="email" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <label class="d-flex align-items-center gap-2">
                                            <input type="checkbox" name="remember" value="1">
                                            <span>Remember me</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-effect">
                                            <span>Login</span>
                                            <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_affiliate_login)"><path d="M19.4854 11.4293L17.0513 12.221C13.1214 13.4993 10.3036 16.9595 9.84784 21.0668C9.49371 16.981 6.71926 13.5081 2.81255 12.2604L0.210283 11.4293" stroke="white" stroke-width="2"/><path d="M9.83594 20.8889L9.83594 0" stroke="white" stroke-width="2"/></g><defs><clipPath id="clip0_affiliate_login"><rect width="21.3333" height="20" fill="white" transform="translate(20) rotate(90)"/></clipPath></defs></svg>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
