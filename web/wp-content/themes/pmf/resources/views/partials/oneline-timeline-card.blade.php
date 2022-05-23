@php

  $time = strtotime(get_field('time'));
  $month = date('m',$time);
  $year = date ('Y', $time);
@endphp
<div class="timeline-card  clickable line @empty(!get_field('next_month')) nextmonth @endempty @empty(!get_field('next_year')) nextyear @endempty swiper-slide"  data-id="{{ get_the_ID() }}" data-post_id="{{ get_the_ID() }}" data-flight="line" tabindex="0">
@if( has_post_thumbnail() )
  <!-- Image -->
    <div class="timeline-card__img">
      <img
        src="{{ get_the_post_thumbnail_url(get_the_ID(),'92x92' ) }}"
        alt="{{ get_the_title() }} - photo"
        title="{{ get_the_title() }}"
      >
    </div>
  @endif
  <div class="timeline-card__info" >
    @empty( !get_field( 'time', get_the_ID() ) )
      <div class="timeline-card__info__time">
        {{ get_field('time', get_the_ID()) }}
      </div>
    @endempty
    <div class="timeline-card__info__title">
      {{ get_the_title() }}
    </div>

  </div>



</div>

