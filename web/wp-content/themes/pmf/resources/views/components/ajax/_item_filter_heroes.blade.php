
  <!-- Col -->
    <div class="heroes-list__list__col">

    <!-- item -->
    <a href="{{ get_permalink() }}" class="heroes__list__item">

      <div class="heroes__list__item__text">
        <small>{{ birth_year() }}</small>
        <h5 class="title">{{ $query->post->post_title }}</h5>
      </div>
    @if( has_post_thumbnail() )
      <!-- Image -->

        <img
          src="{{ get_the_post_thumbnail_url('thumbnail' ) }}"
          alt="{{ get_the_title() }} - photo"
          title="{{ get_the_title() }}"
        >

        <!-- End Image -->
      @else
        <img src="{{get_template_directory_uri() . '/assets/images/default-image.jpg'}}" width="280" height="280">

      @endif


    </a>
    <!-- end item -->

  </div>
  <!-- End Col2 -->
