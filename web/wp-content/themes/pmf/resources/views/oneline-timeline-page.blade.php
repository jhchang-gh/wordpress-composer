{{--
  Template Name: One-line Timeline Page
  Template Post Type: page
--}}

@extends('layouts.timeline-app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
  @php
    global $post;
    $slides = get_posts([
          'numberposts' => -1,
          'post_type'   => 'pentagon-renovation',
          'order' => 'ASC'
      ])
  @endphp
  <!-- Start timeline wrapper -->

  <div class="timeline__wrapper oneline">

    <div class="timeline__text">
      @if ($fields['title'])
        <h1>{{$fields['title']}}</h1>
      @endif
      @if ($fields['text'])
        {!! $fields['text'] !!}
      @endif
    </div>
    <!-- Start timeline container -->
    <div class="timeline__container swiperTimeline" id="timelineContainer">
      <div class="swiper-wrapper " >
        <div class="timeline__container__left swiper-slide" >
          <div class="date">
            @if ($fields['timeline_caption'])
              <span>{{$fields['timeline_caption']}}</span>
            @endif
            @if ($fields['timeline_title'])
              {{ $fields['timeline_title'] }}
            @endif

          </div>
        </div>

        <div class="timeline__container__right swiper-slide" >

          <div class="swiperTimline-nested">
            <div class="timeline__container__cards-wrapper swiper-wrapper" >
              <span class="oneline__line-dot"></span>
              <hr>
              @foreach($slides as $post)
                @php setup_postdata($post) @endphp

                @include('partials.oneline-timeline-card')
              @endforeach
              @php wp_reset_postdata(); @endphp
            </div>
            <div class="swiper-pagination swiper-pagination-v"></div>
          </div>
        </div>
      </div>

    </div>
    <!-- End timeline container -->
    <!-- controls -->
    <div class="timeline__swiper-controls container">

      <!-- buttons -->
      <div class="swiper-controls-buttons">
        <div class="swiper-button-prev disabled" id="timelinePrev"></div>
        <div class="swiper-button-next" id="timelineNext"></div>
      </div>
      <!-- end buttons -->



    </div>
    <!-- end controls -->

    <!-- Start Timeline-cards content -->
     {{-- @foreach($slides as $post)
        @php setup_postdata($post) @endphp

        @include('partials.timeline-card-content')
      @endforeach
      @php wp_reset_postdata(); @endphp--}}
  <!-- End Timeline-cards content -->


  </div>



  <!-- End timeline wrapper -->



  @endwhile
@endsection
