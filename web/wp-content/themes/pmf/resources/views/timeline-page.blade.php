{{--
  Template Name: Timeline Page
  Template Post Type: page
--}}

@extends('layouts.timeline-app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
  @php
    global $post;
    $slides = get_posts([
          'numberposts' => -1,
          'post_type'   => 'timeline',
          'order' => 'ASC'
      ])
  @endphp
  <!-- Start timeline wrapper -->

  <div class="timeline__wrapper">

    <div class="timeline__text">
      @if ($fields['title'])
        <h1>{{$fields['title']}}</h1>
      @endif
      @if ($fields['text'])
        {!! $fields['text'] !!}
      @endif
    </div>
    <!-- Start timeline container -->
    <div id="timelineLegendDesctop">

    </div>
    <div class="timeline__container swiperTimeline" id="timelineContainer">
      <div class="swiper-wrapper " >
      <div class="timeline__container__left swiper-slide" >
        <div class="date">
          <span>Tuesday</span>
          September 11, 2001
        </div>
      </div>
      <div class="timeline__container__center swiper-slide">
        <div class="timeline__legend" id="legend">
          <img src="{{ get_template_directory_uri() . '/assets/images/legend-lines.svg' }}" alt="Timeline Legend">
          <img src="{{ get_template_directory_uri() . '/assets/images/legend-dotes.svg' }}" alt="Timeline Legend" class="timeline__legend__dotes">
          <img src="{{ get_template_directory_uri() . '/assets/images/flight-lines-mob.svg' }}" alt="Timeline Legend" class="timeline__legend__mob">
          <ul class="timeline__legend__flights sticky-left">
            <li class="timeline__legend__flights-item" data-id="fl-77" tabindex="0">
              Flight 77
              <span class="timeline__legend__info-icon"> <img src="{{ get_template_directory_uri() . '/assets/images/info-icon.svg' }}" alt="Timeline Legend"></span>
              <div class="timeline__legend__location">Pentagon</div>
            </li>
            <li class="timeline__legend__flights-item" data-id="fl-175" tabindex="0">
              Flight 175
              <span class="timeline__legend__info-icon"> <img src="{{ get_template_directory_uri() . '/assets/images/info-icon.svg' }}" alt="Timeline Legend"></span>
              <div class="timeline__legend__location">New York City</div>
            </li>
            <li class="timeline__legend__flights-item" data-id="fl-11" tabindex="0">
              Flight 11
              <span class="timeline__legend__info-icon"> <img src="{{ get_template_directory_uri() . '/assets/images/info-icon.svg' }}" alt="Timeline Legend"></span>
              <div class="timeline__legend__location">New York City</div>
            </li>
            <li class="timeline__legend__flights-item" data-id="fl-93" tabindex="0">
              Flight 93
              <span class="timeline__legend__info-icon"> <img src="{{ get_template_directory_uri() . '/assets/images/info-icon.svg' }}" alt="Timeline Legend"></span>
              <div class="timeline__legend__location">Shanksville, Pennsylvania</div>
            </li>
          </ul>
        </div>
      </div>
      <div class="timeline__container__right swiper-slide" >

        <div class="swiperTimline-nested">
          <div class="timeline__container__cards-wrapper swiper-wrapper" >

            <hr>
            <hr>
            <hr>
            <hr>
            <hr>
            <span class="timeline__container__line-dot"></span>
            <span class="timeline__container__line-dot"></span>
            <span class="timeline__container__line-dot"></span>
            <span class="timeline__container__line-dot"></span>
            <img src = "{{ get_template_directory_uri() . '/assets/images/line-1-end.svg' }}" alt="timeline" class="timeline__line-1-end">
            <img src = "{{ get_template_directory_uri() . '/assets/images/line-2-end.svg' }}" alt="timeline" class="timeline__line-2-end">
            <img src = "{{ get_template_directory_uri() . '/assets/images/line-2-end.svg' }}" alt="timeline" class="timeline__line-3-end">
            <img src = "{{ get_template_directory_uri() . '/assets/images/line-4-end.svg' }}" alt="timeline" class="timeline__line-4-end">
            @foreach($slides as $post)
              @php setup_postdata($post) @endphp

              @include('partials.timeline-card')

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
        <div class="swiper-button-prev disabled" id="timelinePrev" tabindex="0"></div>
        <div class="swiper-button-next" id="timelineNext" tabindex="0"></div>
      </div>
      <!-- end buttons -->



    </div>
    <!-- end controls -->

    <!-- Start Timeline-cards content -->
    {{--
  @foreach($slides as $post)
    @php setup_postdata($post) @endphp
    @if( get_field( 'is_clickable', get_the_ID() ) )
      @include('partials.timeline-card-content')
    @endif
  @endforeach
  @php wp_reset_postdata(); @endphp--}}
    <!-- End Timeline-cards content -->


  </div>



  <!-- End timeline wrapper -->



  @endwhile
@endsection
