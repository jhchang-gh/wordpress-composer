@if( $item['images'] )

  <!-- Slider -->
  <div class="map__modal__content__text__row slider_lb">
    <!-- container -->
    <div class="swiper-container">
      <!-- wrapper -->
      <div class="swiper-wrapper">
        @foreach( $item['images'] as $image )
          <!-- slide -->
          <div class="swiper-slide">

            <a href="{{ wp_get_attachment_image_url($image['ID'], 'full') }}" data-fancybox="gallery" data-src="{{ wp_get_attachment_image_url($image['ID'], 'full') }}">

              {!! wp_get_attachment_image( $image['ID'], '465x350' ) !!}

            </a>

          </div>
          <!-- end slide -->
        @endforeach
      </div>
      <!-- end wrapper -->
      <!-- pagination -->
      <div class="swiper-pagination"></div>
      <!-- end pagination -->
    </div>
    <!-- end container -->
  </div>
  <!-- End Slider -->

@endif
