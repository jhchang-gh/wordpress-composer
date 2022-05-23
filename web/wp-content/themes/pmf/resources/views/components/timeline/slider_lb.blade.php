<!-- Start Component: Card Slider -->
<section class="card-slider lightbox" >

  @empty( !$field['images'] )
    <!-- Swiper -->
      <div class="swiper-container">

        <!-- wrapper -->
        <div class="swiper-wrapper">
          @foreach($field['images'] as $img)
            <a href="{{ $img['url'] }}" data-fancybox="gallery" rel="gallery" class="swiper-slide fb_slide">

              <img src="{{$img['sizes']['w460']}}" alt="Timeline card image">

            </a>

          @endforeach
        </div>
        <div class="swiper-pagination"></div>
      </div>
  @endempty

</section>
<!-- End Component: Card Slider -->
