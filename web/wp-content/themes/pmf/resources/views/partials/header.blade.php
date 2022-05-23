<header class="header @if( is_home() || is_front_page() ) @else default @endif ">

  <!-- Scroll -->
  <div class="header__scroll">

      <div class="header__notification container-fluid">
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
            <a class="brand" href="{{ home_url('/') }}"  id="brand" aria-label="logo">
              <img
                src="{{ get_template_directory_uri() . '/assets/images/logo.svg' }}"
                alt="{{ bloginfo('name') }}"
                title="{{ bloginfo('name') }}"
                class="header__logo__white"
              >
              <img
                src="{{ get_template_directory_uri() . '/assets/images/logo-color.svg' }}"
                alt="{{ bloginfo('name') }}"
                title="{{ bloginfo('name') }}"
                class="header__logo__color"
              >
            </a>
          </div>
          <!-- End Logo -->

          <!-- Location -->
          <div class="header__location">

            <div>
              <span>Memorial Hours</span>
              <p>Closed indefinitely</p>
            </div>

          </div>
          <!-- End Location -->

        </div>
        <!-- end left -->

        <!-- right -->
        <div class="header__row__right">

          @if( is_home() || is_front_page() ) @else
            @php
              $breadcrumbps = custom_breadcrumbps();
            @endphp
            @if ($breadcrumbps)
            <!-- Breadcrumbs -->
              <div class="header__breadcrumbs web">

                <!-- List -->
                <ul class="breadcrumbs">
                  <li>
                    <a href="#" aria-label="breadcrumbp">{{ $breadcrumbps['parent'] }}</a>
                  </li>
                  <li class="drop dropdown">

                    <!-- button -->
                    <a href="#" class="dropdown-button">{{ get_the_title() }}<span class="dropdown-arrow"></span></a>
                    <!-- end button -->
                    @if ($breadcrumbps['elements'])

                      <!-- list -->
                      <ul class="dropdown-window">
                        @foreach($breadcrumbps['elements'] as $element)
                          <li>
                            <a href="{{ $element['url'] }}" class="{{ $element['classes'] }}">
                              {{ $element['title'] }}
                            </a>
                          </li>
                        @endforeach

                      </ul>
                    @endif
                    <!-- end list -->

                  </li>
                </ul>
                <!-- End List -->

              </div>
              <!-- End Breadcrumbs -->
            @endif
          @endif

          <!-- btn group -->
          <div class="header__btngroup">

            <!-- Btn > Search -->
            <a href="#" type="button" class="header__btngroup__search" id="search-toggler" aria-label="Search"></a>
            <!-- End Btn > Search -->
            @php
              $donate_link = get_field('donation_page','options');
            @endphp
            <!-- Btn > Donate -->
            @if ($donate_link)
              <a href="{{ $donate_link['url'] }}" class="header__btngroup__donate">
                {{ $donate_link['title'] }}
              </a>
            @endif
            <!-- End Btn > Donate -->

            <!-- Btn > Menu -->
            <button type="button" class="header__btngroup__menu" aria-label="menu">
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

      <!-- Start search form  -->

      <div class="header__searchbox" role="alert" aria-live="assertive">

        {{ get_search_form() }}

      </div>

      <!-- End search form  -->

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

          <!-- Mobile Search -->
          <div class="header__modal__search mobile-search-form">


            {{ get_search_form() }}


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

@if( is_home() || is_front_page() ) @else
  @if ($breadcrumbps)
  <!-- Breadcrumbs -->
  <div class="header__breadcrumbs mobile">

    <!-- List -->
    <ul class="breadcrumbs">
      <li>
        <a href="#">{{ $breadcrumbps['parent'] }}</a>
      </li>
      <li class="drop dropdown">

        <!-- button -->
        <a href="#" class="dropdown-button">{{ get_the_title() }}<span class="dropdown-arrow"></span></a>
        <!-- end button -->

      @if ($breadcrumbps['elements'])

        <!-- list -->
          <ul class="dropdown-window">
            @foreach($breadcrumbps['elements'] as $element)
              <li>
                <a href="{{ $element['url'] }}" class = "{{ $element['classes'] }}">
                  {{ $element['title'] }}
                </a>
              </li>
            @endforeach

          </ul>
      @endif
        <!-- end list -->
        <!--<a href="#" class="dropdown-button"><span class="dropdown-arrow"></span></a>-->
      </li>
    </ul>
    <!-- End List -->

  </div>
  <!-- End Breadcrumbs -->
  @endif
@endif
<div id="scrollbar"></div>
