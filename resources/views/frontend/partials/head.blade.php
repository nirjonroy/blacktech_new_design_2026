<head>
    <!-- ========== Meta Tags ========== -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Blacktech">
    <!-- ======== Page title ============ -->
    <title>@yield('title', 'Black Tech Consultancy')</title>
    <!-- ========== Favicon Icon ========== -->
    @php
        $faviconPath = optional(siteInfo())->favicon ?: 'frontend/assets/images/favicon.ico';
    @endphp
    <link rel="shortcut icon" href="{{ asset($faviconPath) }}" type="image/x-icon">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..900;1,100..900&family=Russo+One&display=swap" rel="stylesheet">
    <!-- CSS Global Compulsory (Do not remove) -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/font-awesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap/bootstrap.min.css') }}">
    <!-- Page CSS Implementing Plugins (Remove the plugin CSS here if site does not use that feature) -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/owl-carousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/swiper/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/magnific-popup/magnific-popup.css') }}">
    <!-- Template Style -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    
     <!--<meta name="google-site-verification" content="wAw4hUVvSKTBeG8hb1WH9Gl37n2wS_BtK5vxVHzhVMg" />-->
    <meta name="google-site-verification" content="S4DjR59vkUiva1rzFZWrvVhAAH8_dZs6tEGFpiGiOvk"/>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-4H1YT8J4CJ"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-4H1YT8J4CJ');
    </script>
    
    <!-- Start Microsoft Clarity Tracking Code -->

<script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "udkz3w5hpk");
</script>
    <!-- ENd Microsoft Clarity Tracking Code -->
    @yield('seos')

</head>
