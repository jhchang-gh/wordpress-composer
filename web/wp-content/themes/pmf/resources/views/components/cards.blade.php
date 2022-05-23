<!-- Start Component: Cards -->
<section class="cards row">

  <!-- Container -->
  <div class="container grid-container global-offset-1">

  @php
    $items = get_field('cards_item','options');
  @endphp

  <!-- List -->
    @if(  $items )
      <div class="cards__list">
      @foreach($items as $item )

        @php
          the_row();
          $card_link = $item['card_link'];
        @endphp

        <!-- Col -->
          <div class="cards__list__col @if ($item['card_img']['width'] > $item['card_img']['height']) big_col @else normal_col @endif">

            <!-- Item -->
            @if( $card_link['url'] )
              <a href="{{ $card_link['url'] }}" class="cards__list__item">
            @else
              <div class="cards__list__item no-hover">
            @endif

              <!-- Subtitle -->
              <small class="cards__list__item__subtitle">
                {{ $item['card_title'] }}
              </small>
              <!-- End Subtitle -->

              <!-- Image -->
              <div class="cards__list__item__image">

                @if ($item['card_img']['width'] > $item['card_img']['height'])
                  <img
                    src="{{$item['card_img']['sizes']['486x376']}}"
                    alt="{{ $item['card_title'] }}"
                    title="{{ $item['card_title'] }}"
                  >
                @else
                  <img
                    src="{{$item['card_img']['sizes']['282x376']}}"
                    alt="{{ $item['card_title'] }}"
                    title="{{ $item['card_title'] }}"
                  >
                @endif

              </div>
              <!-- End Image -->

            @if( ! empty( $item['card_text'] ) )
              <!-- Title -->
              <h4 class="cards__list__item__title">
                {{ $item['card_text'] }}
              </h4>
              <!-- End Title -->
            @endif

            @if( ! empty( $card_link['title'] ) )
              <!-- Link -->
              <span class="cards__list__item__link">
              {{ $card_link['title'] }}
              </span>
              <!-- End Link -->
            @endif

            @if( $card_link['url'] )
              </a>
            @else
              </div>
            @endif
            <!-- End Item -->

          </div>
          <!-- End Col -->
        @endforeach

      </div>
  @endif
  <!-- End List -->

  </div>
  <!-- End Container -->

</section>
<!-- End Component: Cards -->
