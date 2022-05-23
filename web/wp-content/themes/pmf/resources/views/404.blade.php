@extends('layouts.app')

@section('content')


  @if (! have_posts())
    <!-- Start Component: Intro Text -->
    <section class="intro-text error404__wrapper ">

      <!-- Container -->
      <div class="container grid-container">

        <!-- inner -->
        <div class="intro-text__inner">



            <!-- left -->

          <div class="error404__big">404</div>

          <x-alert type="warning">
                  {!! __('Sorry, but the page you are trying to view does not exist.', 'sage') !!}
          </x-alert>
          <div class="error404__button">
            <a href="/" target="" class="btn">
              <span><i></i>Back to Homepage</span>
            </a>
          </div>






        </div>
        <!-- end inner -->

      </div>
      <!-- End Container -->

    </section>
    <!-- End Component: Intro Text -->



  @endif
@endsection
