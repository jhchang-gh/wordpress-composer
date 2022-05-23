<!-- Start Component: Follow Us -->
<section class="follow-us">

  <!-- Container -->
  <div class="container grid-container container-fluid">

    <!-- Inner -->
    <div class="follow-us__inner">

      <!-- Header -->
      <div class="follow-us__header">
        <span>{{ $field['label'] }}</span>
        <h2 class="follow-us__header__title">{{ $field['title'] }}</h2>
      </div>
      <!-- End Header -->

    </div>
    <!-- End Inner -->

  </div>
  <!-- End Container -->

  <!-- Slider -->
  <div class="follow-us__list slider swiperFollowUs">

    <!-- Swiper -->
    <div class="swiper-container">

      <!-- wrapper -->
      <div class="swiper-wrapper">

        <!-- Slide -->
        <div class="swiper-slide">

          <!-- Item -->
          <a href="#" class="follow-us__list__item">

            <!-- Image -->
            <div class="follow-us__list__item__image">
              <img src="{{get_template_directory_uri() . '/assets/images/follow_us_img_1.png'}}" width="300" height="180" alt="social share image">
            </div>
            <!-- End Image -->

            <span>Date Label</span>

            <p>The 9/11 Pentagon Memorial is a place of solace, peace, and healing.</p>

          </a>
          <!-- End Item -->

        </div>
        <!-- End Slide -->

        <!-- Slide -->
        <div class="swiper-slide">

          <!-- Item -->
          <a href="#" class="follow-us__list__item">

            <!-- Image -->
            <div class="follow-us__list__item__image">
              <img src="{{get_template_directory_uri() . '/assets/images/follow_us_img_2.png'}}" width="300" height="300" alt="social share image">
            </div>
            <!-- End Image -->

            <span>Date Label</span>

            <p>The 9/11 Pentagon Memorial is a place of solace, peace, and healing.</p>

          </a>
          <!-- End Item -->

        </div>
        <!-- End Slide -->

        <!-- Slide -->
        <div class="swiper-slide">

          <!-- Item -->
          <a href="#" class="follow-us__list__item">

            <!-- Image -->
            <div class="follow-us__list__item__image">
              <img src="{{get_template_directory_uri() . '/assets/images/follow_us_img_1.png'}}" width="300" height="180" alt="social share image">
            </div>
            <!-- End Image -->

            <span>Date Label</span>

            <p>The 9/11 Pentagon Memorial is a place of solace, peace, and healing.</p>

          </a>
          <!-- End Item -->

        </div>
        <!-- End Slide -->

        <!-- Slide -->
        <div class="swiper-slide">

          <!-- Item -->
          <a href="#" class="follow-us__list__item">

            <!-- Image -->
            <div class="follow-us__list__item__image">
              <img src="{{get_template_directory_uri() . '/assets/images/follow_us_img_2.png'}}" width="300" height="300" alt="social share image">
            </div>
            <!-- End Image -->

            <span>Date Label</span>

            <p>The 9/11 Pentagon Memorial is a place of solace, peace, and healing.</p>

          </a>
          <!-- End Item -->

        </div>
        <!-- End Slide -->

        <!-- Slide -->
        <div class="swiper-slide">

          <!-- Item -->
          <a href="#" class="follow-us__list__item">

            <!-- Image -->
            <div class="follow-us__list__item__image">
              <img src="{{get_template_directory_uri() . '/assets/images/follow_us_img_1.png'}}" width="300" height="180" alt="social share image">
            </div>
            <!-- End Image -->

            <span>Date Label</span>

            <p>The 9/11 Pentagon Memorial is a place of solace, peace, and healing.</p>

          </a>
          <!-- End Item -->

        </div>
        <!-- End Slide -->

        <!-- Slide -->
        <div class="swiper-slide">

          <!-- Item -->
          <a href="#" class="follow-us__list__item">

            <!-- Image -->
            <div class="follow-us__list__item__image">
              <img src="{{get_template_directory_uri() . '/assets/images/follow_us_img_2.png'}}" width="300" height="300" alt="social share image">
            </div>
            <!-- End Image -->

            <span>Date Label</span>

            <p>The 9/11 Pentagon Memorial is a place of solace, peace, and healing.</p>

          </a>
          <!-- End Item -->

        </div>
        <!-- End Slide -->

        <!-- Slide -->
        <div class="swiper-slide">

          <!-- Item -->
          <a href="#" class="follow-us__list__item">

            <!-- Image -->
            <div class="follow-us__list__item__image">
              <img src="{{get_template_directory_uri() . '/assets/images/follow_us_img_1.png'}}" width="300" height="180" alt="social share image">
            </div>
            <!-- End Image -->

            <span>Date Label</span>

            <p>The 9/11 Pentagon Memorial is a place of solace, peace, and healing.</p>

          </a>
          <!-- End Item -->

        </div>
        <!-- End Slide -->

        <!-- Slide -->
        <div class="swiper-slide">

          <!-- Item -->
          <a href="#" class="follow-us__list__item">

            <!-- Image -->
            <div class="follow-us__list__item__image">

              <img src="{{get_template_directory_uri() . '/assets/images/follow_us_img_2.png'}}" width="300" height="300" alt="social share image">
            </div>
            <!-- End Image -->

            <span>Date Label</span>

            <p>The 9/11 Pentagon Memorial is a place of solace, peace, and healing.</p>

          </a>
          <!-- End Item -->

        </div>
        <!-- End Slide -->

      </div>
      <!-- end wrapper -->

      <!-- Container -->
      <div class="container grid-container container-fluid" id="swiperFollowContainer">

        <!-- Inner -->
        <div class="follow-us__inner border">

          <!-- Footer -->
          <div class="follow-us__footer">

            <!-- controls -->
            <div class="swiper-controls">
              <div class="swiper-button-prev"></div>
              <div class="swiper-button-next"></div>
            </div>
            <!-- end controls -->

            <!-- Share -->
            <div class="follow-us__share">

              <!-- Title -->
              <span class="follow-us__share__title">
              {{ _e( 'Follow Us', 'pmf' ) }}
            </span>
              <!-- End Title -->

              <!-- List -->
              <ul class="follow-us__share__list">
                <li>
                  <a href="{{ get_field('social_facebook','options') }}" aria-label="Facebook">
                    <img src="{{ get_template_directory_uri() . '/assets/images/icon_facebook.svg' }}" alt="" title="" class="svg">
                  </a>
                </li>
                <li>
                  <a href="#{{ get_field('social_twiter','options') }}" aria-label="Twitter">
                    <img src="{{ get_template_directory_uri() . '/assets/images/icon_tw.svg' }}" alt="" title="" class="svg">
                  </a>
                </li>
                <li>
                  <a href="{{ get_field('social_instagram','options') }}" aria-label="Instagram">
                    <img src="{{ get_template_directory_uri() . '/assets/images/icon_instagram.svg' }}" alt="" title="" class="svg">
                  </a>
                </li>
              </ul>
              <!-- End List -->

            </div>
            <!-- End Share -->

          </div>
          <!-- End Footer -->

        </div>
        <!-- End Inner -->

      </div>
      <!-- End Container -->

    </div>
    <!-- End Swiper -->

  </div>
  <!-- End Slider -->

</section>
<!-- End Component: Follow Us -->
