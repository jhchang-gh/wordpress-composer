<!-- Start Component: biography story cards -->

@if( have_rows( 'biography_story_cards', get_the_ID() ) )
<section class="biography-options">

  <!-- Container -->
  <div class="container global-offset-1 grid-container">
    <!-- inner -->
    <div class="biography-options__inner">
      <!-- Row -->
      <div class="biography-options__row">
        @php  $i = 1; @endphp
        @while(have_rows('biography_story_cards', get_the_ID()))
          @php
            the_row();
            $sc_link = get_sub_field('sc_link');
            $sc_type = get_sub_field('card_type');
            if($sc_type == 'ico-marker') {
                $sc_link['url'] = get_home_url().'/interactive-map/#'.get_the_ID();
                $sc_link['title'] = 'Interactive Map';
            }


          @endphp

          <a href="{{ $sc_link['url'] }}" class="biography-options__item @if($i < 3) {{ $i }} width-default @else width-big @endif" title="{{ $sc_link['title'] }}">

            <div class="biography-options__item__caption">
              {{ get_sub_field('sc_label') }}
            </div>

            <div class="biography-options__item__icon biography-options__item__icon--{{ get_sub_field('card_type') }}"></div>

            <div class="biography-options__item__title">
              {{ get_sub_field('sc_title') }}
            </div>

            <span  class="biography-options__item__link">{{ $sc_link['title'] }}</span>


          </a>
          @php
          $i++;
          @endphp
        @endwhile

      </div>
      <!-- End Row -->
    </div>
    <!-- End Inner -->

  </div>
  <!-- End Container -->

</section>
<!-- End Component: Biography story cards -->
@endif
