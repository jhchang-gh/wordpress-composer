
      <div class="timeline-card__content modal-content"  data-id="{{ get_the_ID() }}" tabindex="0">
        <div class="timeline-card__content__wrapper" id="timelineContentWrapper">
          <div class="timeline-card__content__title">

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


        </div>
      </div>

