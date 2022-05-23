<!-- Start Component: Intro Text -->
<section class="biography-content">

  <!-- Container -->
  <div class="container grid-container global-offset-1">

    <!-- inner -->
    <div class="biography-content__inner">

      <!-- row -->
      <div class="biography-content__inner__row">

        <!-- left -->
        <div class="biography-content__inner__row__left">

          {{ the_content() }}

        </div>
        <!-- end left -->

        <!-- right -->
        <div class="biography-content__inner__row__right">
          @if( have_rows( 'biography_quick_facts', get_the_ID() ) )
            @while(have_rows('biography_quick_facts', get_the_ID()))
              @php the_row() @endphp
            <div class="text ">

              <span>{{ get_sub_field('qf_title') }}</span>
              {{ get_sub_field('qf_description') }}
              @php

                $qf_link = get_sub_field('qf_link');

              @endphp

                <a href="{{ $qf_link['url'] }}" target=" {{ $qf_link['target'] }} " class="text__link">{{ $qf_link['title'] }}</a>


            </div>
            @endwhile
          @endif



          <div class="text" >
            <span>Share {{ get_name() }} Story</span>
            <ul class="social-share">
              <li>
                <a href="https://twitter.com/intent/tweet" class="social-share__link social-share__link--ico-twiter"></a>

              </li>
              <li>
                <a href="https://www.instagram.com/?url={{ get_permalink() }}" target="_blank" rel="noopener" class="social-share__link social-share__link--ico-instagram"></a>
              </li>
              <li>
                <a href="#" class="social-share__link social-share__link--ico-facebook"></a>
              </li>
            </ul>
          </div>

        </div>
        <!-- end right -->

      </div>
      <!-- end row -->

    </div>
    <!-- end inner -->

  </div>
  <!-- End Container -->

</section>
<!-- End Component: Intro Text -->
