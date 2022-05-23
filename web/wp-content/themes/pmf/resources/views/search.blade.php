@extends('layouts.app')

@section('content')

  <!-- Start Component: Intro Default -->
  <section class="intro-default  no-hero  ">

    <!-- Text -->
    <div class="intro-default__text">

      <!-- Container -->
      <div class="container grid-container global-offset-1 ">

        <!-- Title -->
        <h1 class="intro-default__text__title border-bottom">
          {!! App::title() !!}
        </h1>
        <!-- End Title -->


      </div>
      <!-- End Container -->

    </div>
    <!-- End Text -->



  </section>
  <!-- End Component: Intro Default -->

  <!-- Start Component: Intro Text -->
  <section class="intro-text search-results">

    <!-- Container -->
    <div class="container grid-container global-offset-1">

      <!-- inner -->
      <div class="intro-text__inner">

        <!-- row -->
        <div class="intro-text__inner__row">

          <!-- left -->
          <div>


            @if (! have_posts())
              <x-alert type="warning">
                {!! __('Sorry, no results were found.', 'sage') !!}
              </x-alert>


            @endif

            @while(have_posts())
                @php
                  global $wp_query;
                  the_post();
                $max_num_pages = $wp_query->max_num_pages;
                @endphp
            @include('partials.content-search')
            @endwhile
              <div class="newposts"></div>
              <div id="max-pages" data-maxpages="{{$max_num_pages}}"></div>
              @if($max_num_pages > 1)
                <div class="show_more">
                  Show More Results
                </div>
                @endif
          </div>
          <!-- end left -->



        </div>
        <!-- end row -->

      </div>
      <!-- end inner -->

    </div>
    <!-- End Container -->

  </section>
  <!-- End Component: Intro Text -->




@endsection
