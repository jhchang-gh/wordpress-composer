<!-- Col -->
<div class="heroes-list__list__col">

  <!-- item -->
  <a href="{{ $hero['post_permalink'] }}" class="heroes__list__item">

    <div class="heroes__list__item__text">
      <small>{{ $hero['post_birth_year'] }}</small>
      <h5 class="title">{{$hero['post_title']}}</h5>
    </div>

  @if( !empty($hero['post_thumbnail_id']) )
    <!-- Image -->

      <!--<img
        src="{{ wp_get_attachment_url($hero['post_thumbnail_id'] ) }}"
        alt="{{ get_the_title() }} - photo"
        title="{{ get_the_title() }}"
      >-->
      <div class="heroes__list__item__image" style = "background-image: url({{ wp_get_attachment_url($hero['post_thumbnail_id'] ) }})"></div>

      <!-- End Image -->
  @else
      <div class="heroes__list__item__image" style = "background-image: url({{ get_template_directory_uri() . '/assets/images/default-image.jpg' }})"></div>
      <!--<img src="{{get_template_directory_uri() . '/assets/images/default-image.jpg'}}" width="280" height="280">-->
  @endif


  </a>
  <!-- end item -->

</div>
<!-- End Col -->




