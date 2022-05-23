
<div class="timeline-card__content flight-info" id="fl-175" tabindex="0">
  <div class="timeline-card__content__wrapper">
    <div class="timeline-card__content__title">
      <span class="timeline-card__close" tabindex="0"></span>
      @empty( !get_field( 'flight175_caption', get_the_ID() ) )
        <div class="timeline-card__content__time">
          {{ get_field('flight175_caption', get_the_ID()) }}
        </div>
      @endempty

      <h2>{{ get_field('flight177_title') }}</h2>

    </div>
    <div class="timeline-card__content__blocks">
      @if(!empty(get_field('flight175_content')))
        @foreach(get_field('flight175_content') as $field)
          @include('components.timeline.'.$field['acf_fc_layout'])
        @endforeach
      @endif

    </div>

  </div>
</div>
