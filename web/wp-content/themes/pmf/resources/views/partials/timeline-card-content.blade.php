
<div class="timeline-card__content " id="tlc-{{ get_the_ID() }}" >
  <div class="timeline-card__content__wrapper">
    <div class="timeline-card__content__title">
      <span class="timeline-card__close"></span>
      @empty( !get_field( 'time', get_the_ID() ) )
        <div class="timeline-card__content__time">
          {{ get_field('time', get_the_ID()) }}
        </div>
      @endempty

      <h2>{{ get_the_title() }}</h2>

    </div>
    <div class="timeline-card__content__blocks">
      @if(!empty(get_field('content')))
        @foreach(get_field('content') as $field)
          @include('components.timeline.'.$field['acf_fc_layout'])
        @endforeach
      @endif

    </div>
    <div class="timeline-card__nav">


      <div class="swiper-controls-buttons">
        <div  class="timeline-card__nav__btn-wrapper btn-prev">
          <div class="swiper-button-prev"></div>
          <span>Previous</span>
        </div>
        <div  class="timeline-card__nav__btn-wrapper btn-next">
          <span>Next</span>
          <div class="swiper-button-next"></div>

        </div>

      </div>


    </div>

  </div>
</div>
