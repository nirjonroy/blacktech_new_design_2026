@extends('frontend.app')
@section('title', 'Sub Category List')

@section('content')
<style>
    .service-card {
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: box-shadow 0.3s ease-in-out;
    margin-bottom: 30px;
}

.service-card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.services-two__single-inner {
    padding: 20px;
    text-align: center;
}

.services-two__title {
    margin-top: 15px;
    margin-bottom: 0;
}

.services-two__title a {
    text-decoration: none;
    color: inherit;
}

.services-two__title a:hover {
    color: #FFC107;
}

</style>
<div class="uni-banner" style="background: url('{{asset("forntend/assets/images/inner-images/uni-banner-bg-1.jpg")}}')">
    <div class="container-fluid container-large">
        <div class="uni-banner-text-area">
            <h1>{{ $categories[0]->category->name }}</h1>
            <p style="color:#ffffff">{{ $categories[0]->category->short_description }} </p>
            <ul>
                <li><a href="{{route('front.home')}}">Home</a></li>
                <li>{{ $categories[0]->category->name }}</li>
            </ul>
        </div>
    </div>
</div>

<!--Page Header End-->

<!--Services Two Start-->
<section class="services-two pt-70 pb-100">
    <div class="container">
       
        <div class="row">

            <!--Services Two Single Start-->
            @forelse($categories as $key => $subCategory)

            <div class="col-xl-3 col-lg-3 col-md-3 wow fadeInUp" data-wow-delay="100ms">
                <a href="{{ route('front.shop', [
                            'slug'=> $subCategory->slug
                            ] ) }}">
                <div class="services-two__single service-card">
                    <div class="services-two__single-inner" style="text-align: center">
                        <div class="">
                            <span class="">
                                @if($subCategory)
                                <img src="{{ asset($subCategory->image) }}" class="img-responsive" style="width: 140px; height: 200px; display: block; margin: 0 auto;">
                                @else
                                <!--<img class="img-responsive" src="img_chania.jpg" alt="Chania" />-->
                                <img src="{{ asset('frontend/nothing.png') }}" class="img-responsive" style="width: 61px; height: 71px; display: block; margin: 0 auto;">
                                @endif
                            </span>
                        </div>
                        <h3 class="services-two__title"><a href="{{ route('front.shop', [
                            'slug'=> $subCategory->slug
                            ] ) }}">
                            {{ $subCategory->name }}
                        </a></h3>
                        {{-- <p class="services-two__text">Duis aute irure dolor in repreh enderit in volup tate velit esse cillum dolore fugiat nulla dolor atur</p> --}}
                    </div>
                </div>
            </a>
            </div>

            @endforeach

            <!--Services Two Single End-->
        </div>
    </div>
</section>
@endsection

@push('js')
    <!--<script src="{{ asset('frontend/silck/slick.min.js') }}"></script>-->
@endpush
