@extends('frontend.app')
@section('title', $industry->meta_title ?? $industry->name)
@push('css')

@endpush
@section('seos')
@php
    $siteName = $industry->site_name ?? config('app.name', 'Blacktech');
    $metaTitle = $industry->meta_title ?? $industry->name;
    $rawDescription = $industry->meta_description ?? $industry->short_description_1 ?? $industry->description_1 ?? $industry->description_2 ?? $industry->name;
    $metaDescription = \Illuminate\Support\Str::limit(strip_tags($rawDescription), 180);
    $primaryImage = $industry->meta_image ? asset($industry->meta_image) : ($industry->image ? asset($industry->image) : null);
    $metaImage = $primaryImage ?? asset('images/og-default.jpg');
    $author = $industry->author ?? 'Blacktech';
    $publisher = $industry->publisher ?? $siteName;
    $copyright = $industry->copyright ?? null;
    $keywords = $industry->keywords ?? null;
    $canonical = url()->current();
@endphp

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

<meta property="og:title" content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:type" content="website">
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
<meta property="article:modified_time" content="{{ optional($industry->updated_at)->toIso8601String() ?? now()->toIso8601String() }}">

<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:url" content="{{ $canonical }}">
<meta name="twitter:image" content="{{ $metaImage }}">

<meta http-equiv="X-UA-Compatible" content="IE=edge">
@endsection
@section('content')

<style>
    .top-banner{
padding-bottom:10px;
        margin-top: 12%;
    padding-top: 110px;
    }
</style>

 <div style="background:url('https://images.pexels.com/photos/255379/pexels-photo-255379.jpeg?auto=compress&cs=tinysrgb&w=600');" class="top-banner shadow-lg">
    <div class="container-fluid"></div>
 </div>
<main class="bg-light container">
    <div class="p-4">
        <h1 class="my-4 fw-bold text-center fs-22" style="color:#FF9C00"> {{$industry->name}}</h1>
        <img src="{{asset($industry->image)}}" class="img-fluid "; style="
    height: 371px;
    display: block;
    margin: 0 auto;"/>    
    </div>
    

<section class="secetion-electronics-repair pt-xs-80 pb-xs-80 pt-sm-100 pb-sm-100 pt-md-100 pb-md-100 pt-120 pb-120 overflow-hidden">
    <div class="container" style="max-width:1200px">
        <div class="row g-4 align-items-center">
        <div class="col-12 col-md-12 col-lg-12">
       <div class="text-content p-4">
       <p class="text-danger fw-bold ">Industry</p>
       

       <p class="my-2 text-dark pt-5">{!!$industry->description_1!!}</p>
       </div>
      
    </div>
    
    </div>
    </div>

</section>

<section class="section-repair-life pt-xs-80 pb-xs-80 pt-sm-100 pb-sm-100 pt-md-100 pb-md-100 pt-120 pb-120 overflow-hidden">
    <div class="container" style="max-width:1200px">
        
        <div class="row g-3 align-items-center g-4">
            <div class="col-12 col-md-12 col-lg-12">
            <div class="text-contet p-4 my-2">
            {!!$industry->description_2!!}
            </div>
            </div>


        </div>
    </div>
</section>

</main>

@endsection
