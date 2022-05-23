<!-- Start Component: Heroes -->
@php
    global $post;
    $slides = get_posts([
          'numberposts' => 8,
          'post_type'   => 'biographies',
          'orderby'      => 'rand'
      ]);
    $field = get_field('heroes_slider','options');

@endphp
<section class="heroes biography-heroes">

  <!-- Container -->
  <div class="container grid-container container-fluid">

    <!-- Inner -->
    <div class="heroes__inner">

      <!-- header -->
      <div class="heroes__header">

        <!-- subtitle -->
        @empty (!$field['label'])
          <span class="heroes__header__subtitle">
              {{ $field['label'] }}
        </span>
        @endempty
      <!-- end subtitle -->

        <!-- title -->
        @empty (!$field['text'])
          <h2 class="heroes__header__title biography-heroes__heroes__header__title">
            {{ $field['title'] }}
          </h2>
        @endempty
      <!-- end title -->

        <!-- text -->
        @empty (!$field['text'])
          <div class="heroes__header__text">
            <p>
              {{ $field['text'] }}
            </p>
          </div>
          <!-- end text -->
        @endempty

      </div>
      <!-- end header -->

    </div>
    <!-- End Inner -->

  </div>
  <!-- End Container -->

@empty(!$slides)
  <!-- Slider -->
    <div class="heroes__list slider swiperHeroes">

      <!-- Swiper -->
      <div class="swiper-container">

        <!-- wrapper -->
        <div class="swiper-wrapper">

        @foreach($slides as $post)
          @php setup_postdata($post) @endphp
          <!-- Slide -->
            <div class="swiper-slide">

              <a href="{{ get_permalink() }}" class="heroes__list__item">

                <div class="heroes__list__item__text">
                  <small>{{ birth_year() }}</small>
                  <h5 class="title">{{ get_the_title() }}</h5>
                </div>
              @if( has_post_thumbnail() )
                <!-- Image -->
                  {!! the_post_thumbnail('thumbnail') !!}


                  <!-- End Image -->
                @else
                  <img src="{{get_template_directory_uri() . '/assets/images/default-image.jpg'}}" width="280" height="280">

                @endif

              </a>

            </div>
            <!-- End Slide -->
          @endforeach
          @php wp_reset_postdata(); @endphp

        </div>
        <!-- end wrapper -->

        <!-- Container -->
        <div class="container grid-container container-fluid" id="swiperHeroesContainer">

          <!-- Inner -->
          <div class="heroes__inner border-bottom">
            <!-- controls -->
            <div class="swiper-controls container">

              <!-- buttons -->
              <div class="swiper-controls-buttons">
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
              </div>
              <!-- end buttons -->

              <!-- right -->
              @empty (!$field['link'])
                <a href="{{ $field['link']['url'] }}" target="{{ $field['link']['target'] }}" class="btn">
                  <span><i></i>{{ $field['link']['title'] }}</span>
                </a>
            @endempty
            <!-- end right -->

            </div>
            <!-- end controls -->
          </div>
          <!-- End Inner -->

        </div>
        <!-- End Container -->

      </div>
      <!-- End Swiper -->

    </div>
    <!-- End Slider -->
  @endempty

</section>
<!-- End Component: Heroes -->
