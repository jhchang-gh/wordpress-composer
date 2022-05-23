<!doctype html>
<html {!! get_language_attributes() !!}>
@include('partials.head')
<body @php body_class( (isset($body_class)) ? $body_class : '' ) @endphp>
@php do_action('get_header') @endphp
@include('partials.header')
@php do_action('get_header_after') @endphp

<!-- Wrapper -->
<div id="wrapper">

  <!-- Main -->
  <main class="main">
  @yield('content')



      <!-- Start Component: Scroll Top -->
      <a href="#top" class="scroll scroll__top" aria-label="Scroll Top"></a>
      <!-- End Component: Scroll Top -->



  </main>
  <!-- End Main -->

  @isset( $footer_visible )

  @else
    <!-- Footer -->
    @php do_action('get_footer') @endphp
    @include('partials.footer')
    <!-- End Footer -->
  @endisset

</div>
<!-- End Wrapper -->
@php wp_footer() @endphp
@yield('scripts')
</body>
</html>
