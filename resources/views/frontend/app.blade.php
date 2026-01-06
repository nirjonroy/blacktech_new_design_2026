
<!DOCTYPE html>
<html lang="en">
    @include('frontend.partials.head')
    <body>
    <div id="cursor">
      <div class="cursor__circle"></div>
    </div>

    <div id="page" class="main">
    @include('frontend.partials.header')

    @yield('content')
    <template id="consultation-cta-template">
        @include('frontend.partials.consultation-cta')
    </template>

    <style>
  /* Style for the floating button */
  .call-button {
    position: fixed;
    bottom: 110px;
    right: 20px;
    background-color: #007bff;
    color: #FFD700;
    border: none;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    font-size: 24px;
    text-align: center;
    line-height: 60px;
    cursor: pointer;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 99999; /* Increased z-index value */
  }

  /* Style for the button icon */
  .call-button i {
    font-size: 24px;
  }
</style>
    <a href="tel:+1 571-478-2431" class="call-button">
      <i class="fa-solid fa-phone"></i>
    </a>

    @include('frontend.partials.footer')
