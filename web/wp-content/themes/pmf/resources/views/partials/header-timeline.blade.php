

<header class="header @if( is_home() || is_front_page() ) @else default  @endif">

  <!-- Scroll -->
  <div class="header__scroll timeline-header">

      <div class="header__notification">
        <div class="header__notification__left">
          <div class="header__notification__icon"></div>
          <span class="header__notification__title">{{ get_field('notification_title','options') }}</span>
          <span class="header__notification__subtitle">{{ get_field('notification_subtitle','options') }}</span>
        </div>
        <div class="header__notification__right">
          @php $notification_link = get_field('notification_link','options') @endphp
          <a href="{{ $notification_link['url'] }}"  target="{{ $notification_link['target'] }}" class="header__notification__link">{{ $notification_link['title'] }}</a>
          <a href="#" class="header__notification__close" aria-label="close notification"></a>
        </div>
      </div>

    <!-- Container -->
    <div class="container-fluid">

      <!-- row -->
      <div class="header__row">

        <!-- left -->
        <div class="header__row__left">

          <!-- Logo -->
          <div class="header__logo">
            <a class="brand" href="{{ home_url('/') }}">
              <img
                src="{{ get_template_directory_uri() . '/assets/images/logo.svg' }}"
                alt="{{ bloginfo('name') }}"
                title="{{ bloginfo('name') }}"
                class="header__logo__white"
              >
            </a>
          </div>
          <!-- End Logo -->



        </div>
        <!-- end left -->

        <!-- right -->
        <div class="header__row__right">



          <!-- btn group -->
          <div class="timeline-header__filter">

            <!-- Filter -->
            <div class="timeline-header__filter__wrapper">
              <form class="timeline-header__filter__form">

                <label tabindex="0"><input type="checkbox" id="all" class="timeline-filter-input"  checked><span class="filter-item-label">All</span></label>
                <label tabindex="0"><input type="checkbox" id="pentagon" class="timeline-filter-input" ><span class="filter-item-label">Pentagon</span></label>
                <label tabindex="0"><input type="checkbox" id="NYC"  class="timeline-filter-input"><span class="filter-item-label">New York City</span></label>
                <label tabindex="0"><input type="checkbox" id="shanksville" class="timeline-filter-input" ><span class="filter-item-label">Shanksville</span></label>
              </form>

            </div>
            <!-- End Filter -->
            <!-- Start Component: Filter button -->
            <span class="timeline__filter-scroll" id="filterToggler"></span>
            <!-- End Component: Filter button -->

            <!-- Btn > Menu -->
            <button type="button" class="header__btngroup__menu" aria-label="Menu">
              <span></span>
              <span></span>
              <span></span>
            </button>
            <!-- End Btn > Menu -->

          </div>
          <!-- end btn group -->

        </div>
        <!-- end right -->

      </div>
      <!-- end row -->

    </div>
    <!-- End Container -->
  </div>
  <!-- End Scroll -->

  <!-- Modal -->
  <div class="header__modal" role="alert" aria-live="assertive" aria-hidden="true" id="headerModal">
    <!-- Container -->
    <div class="grid-container container">

      <!-- Inner -->
      <div class="header__modal__inner">

        <!-- Left -->
        <div class="header__modal__inner__left">

          <!-- Search -->
          <div class="header__modal__search">

            @php if (wp_is_mobile()):@endphp
              {{ get_search_form() }}
            @php endif; @endphp

          </div>
          <!-- End Search -->

          <!-- Menu -->
          {!! wp_nav_menu( [
                'theme_location'  => 'header_menu',
                'menu'            => 'Header Navigation',
                'container'       => '',
                'container_class' => '',
                'container_id'    => '',
                'menu_class'      => 'header__modal__menu',
                'menu_id'         => '',
                'echo'            => true,
                'fallback_cb'     => 'wp_page_menu',
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
                'depth'           => 0,
                'walker'          => '',
            ] )
          !!}
          <!-- End Menu -->

        </div>
        <!-- Edd Left -->

        <!-- Right -->
        <div class="header__modal__inner__right">
        @php

          $items = get_field('image_menu_items','options');

        @endphp
        @if(  $items )
          <!-- Donate -->
            <div class="header__modal__donate">
            @foreach($items as $item )
              @php
                the_row();
                $card_link = $item['link'];

              @endphp

              <!-- Donate Item -->
                <a href="{{$card_link['url']}}" class="donate__list__item">

                  <!-- Title -->
                  <h4 class="donate__list__item__title">
                    {{$card_link['title']}}
                  </h4>
                  <!-- End Title -->

                  <!-- Image -->
                  <img
                    src="{{ $item['image']['sizes']['400x280'] }}"
                    alt="{{$card_link['title']}}"
                    title="{{$card_link['title']}}"
                    width="400"
                    height="280"
                  >

                  <!-- End Image -->

                </a>
                <!-- End Donate Item -->
            @endforeach

            @php
              $donate_link = get_field('donation_page','options');
            @endphp
            <!-- Donate Button -->
              @php if (wp_is_mobile()):@endphp
              @if ($donate_link)
                <a href="{{ $donate_link['url'] }}" class="btn btn-white btn-no-uppercase header__modal__donate__button">
                  <span> {{ $donate_link['title'] }}</span>
                </a>
              @endif
              @php endif; @endphp


            <!-- End Donate Button -->

            </div>
            <!-- End Donate -->
          @endif

        </div>
        <!-- Edd Right -->

      </div>
      <!-- End Inner -->

    </div>
    <!-- End Container -->
  </div>
  <!-- End Modal -->

</header>
<div id="timeline_modals" >
  <div class="timeline-card__content-wrapper" id="ajaxTimelineContent" tabindex="0" >
    <span class="timeline-card__close" tabindex="0"></span>
    <div class="timeline-card__nav">


      <div class="swiper-controls-buttons">
        <div  class="timeline-card__nav__btn-wrapper btn-prev" tabindex="0">
          <div class="swiper-button-prev"></div>
          <span>Previous</span>
        </div>
        <div  class="timeline-card__nav__btn-wrapper btn-next" tabindex="0">
          <span>Next</span>
          <div class="swiper-button-next" ></div>

        </div>

      </div>


    </div>
  </div>
  <div class="legend-box "></div>
  <!-- Start Flight-info-cards -->
  <div class="timeline__flight-info__wrapper">
    @empty (!get_field('flight77_content'))
      @include('partials.timeline-flight77-info-content')
    @endempty

    @empty (!get_field('flight175_content'))
      @include('partials.timeline-flight175-info-content')
    @endempty

    @empty (!get_field('flight11_content'))
      @include('partials.timeline-flight11-info-content')
    @endempty

    @empty (!get_field('flight93_content'))
      @include('partials.timeline-flight93-info-content')
    @endempty
  </div>
</div>
<!-- End Flight-info-cards -->
<div id="scrollbar"></div>
