
<div class="timeline-card__content flight-info" id="fl-11" tabindex="0">
  <div class="timeline-card__content__wrapper">
    <div class="timeline-card__content__title">
      <span class="timeline-card__close" tabindex="0"></span>
      @empty( !get_field( 'flight11_caption', get_the_ID() ) )
        <div class="timeline-card__content__time">
          {{ get_field('flight11_caption', get_the_ID()) }}
        </div>
      @endempty

      <h2>{{ get_field('flight11_title') }}</h2>

    </div>
    <div class="timeline-card__content__blocks">
      @if(!empty(get_field('flight11_content')))
        @foreach(get_field('flight11_content') as $field)
          @include('components.timeline.'.$field['acf_fc_layout'])
        @endforeach
      @endif

    </div>

  </div>
</div>
