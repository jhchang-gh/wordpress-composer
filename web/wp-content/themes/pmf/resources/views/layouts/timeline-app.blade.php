<!doctype html>
<html {!! get_language_attributes() !!}>
@include('partials.head')
<body @php body_class('timeline') @endphp>
@php do_action('get_header') @endphp
@include('partials.header-timeline')

<!-- Wrapper -->
<div id="wrapper">

  <!-- Main -->
  <main class="main timeline">
  @yield('content')








  </main>
  <!-- End Main -->



</div>
<!-- End Wrapper -->
@php wp_footer() @endphp
@yield('scripts')
</body>
</html>
