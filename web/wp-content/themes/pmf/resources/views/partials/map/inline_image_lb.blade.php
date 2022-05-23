@if( $item['image'] )

  <!-- Image 360 -->
  <div class="map__modal__content__text__row">

    <!-- Image -->
    <div class="image_inline">

      <a href="{{ wp_get_attachment_image_url($item['image']['ID'], 'full') }}" class="fancyPano">

        {!! wp_get_attachment_image( $item['image']['ID'], '465x350' ) !!}

      </a>

    </div>
    <!-- end Image -->

@endif
