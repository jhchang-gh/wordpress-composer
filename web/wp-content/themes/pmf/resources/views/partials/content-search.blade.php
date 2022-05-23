@if(get_post_type() == 'integrations')
  <li class="integrations__item">
    <a target="_blank" href="{{get_field('link', get_the_ID())}}" class="integrations__item__image-wrap">
      <img src="{{ get_the_post_thumbnail_url(get_the_ID(), 'download') }}" alt="" class="integrations__item__image">
    </a>
    <a target="_blank" href="{{get_field('link', get_the_ID())}}"
       class="h6 integrations__item__title">{{ get_the_title() }}</a>
    <p class="integrations__item__text">{{get_field('excerpt', get_the_ID())}}</p>
  </li>
@else
  <div class="search-page__item">
    <a href="{{ get_permalink() }}" class="search-page__item__inner">
      <h4> {!! get_the_title() !!}</h4>
      {!! get_the_excerpt() !!}

    </a>
  </div>
@endif
