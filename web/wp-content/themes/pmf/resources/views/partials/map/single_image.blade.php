@if( $item['image'] )

  <!-- Row -->
  <div class="map__modal__content__text__row">

    <!-- Image -->
    <div class="single_image">

      <a href="{{ wp_get_attachment_image_url($item['image'], 'full') }}" data-fancybox="gallery-single">

        {!! wp_get_attachment_image( $item['image'], 'full' ) !!}

      </a>

    </div>
    <!-- end Image -->

  </div>
  <!-- End Row -->

@endif
