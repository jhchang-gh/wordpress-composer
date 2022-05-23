@php
  $flight = get_field('flight');
  if ($flight == 'Flight-77') {
      $line = 'line-1';
      $data_category = 'pentagon';
  }elseif ($flight == 'Flight-175') {
      $line = 'line-2';
      $data_category = 'NYC';
  }elseif ($flight == 'Flight-11') {
      $line = 'line-3';
      $data_category = 'NYC';
  }elseif ($flight == 'Flight-93') {
      $line = 'line-4';
      $data_category = 'shanksville';
  }else {
      $line = 'line-3 common-line';
      $data_category = 'NYC';
  }
  $position = get_field('position') * 80;
@endphp
<div @empty(!get_field( 'is_clickable', get_the_ID() )) tabindex="0" @endempty class="timeline-card  @empty(!get_field( 'is_clickable', get_the_ID() )) clickable @endempty {{ $line }} swiper-slide" style = "left: {{$position}}px" data-category = "all {{ $data_category }}" data-id="{{ get_the_ID() }}" data-post_id="{{ get_the_ID() }}" data-flight="{{ $line }}">
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

