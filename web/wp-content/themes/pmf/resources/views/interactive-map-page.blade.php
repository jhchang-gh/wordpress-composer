{{--
  Template Name: Interactive Map Page
  Template Post Type: page
--}}

@extends('layouts.app', ['body_class' => 'map', 'footer_visible' => false])

@section('content')

  <!-- Container -->
  <div class="map__container">

    <!-- Map -->
    <div id="map" class="map__mapa"></div>
    <!-- End Map -->

  </div>
  <!-- End Container -->

@endsection
