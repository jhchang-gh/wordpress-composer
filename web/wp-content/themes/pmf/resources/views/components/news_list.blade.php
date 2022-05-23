@php

  $paged = get_query_var('paged') ? get_query_var('paged') : 1;
  global $wp_query;

  $wp_query = new WP_Query([
      'post_type'           => 'post',
      'posts_per_page'      => ($field['pagination']) ? $field['pagination'] : 10,
      'paged'               => $paged,
      'orderby'             => 'id',
      'order'               => 'DESC',
      'category__in'        => $field['categories'],
      'post_status'         => 'publish',
  ]);

@endphp

<!-- Start Component: News List -->
<section class="news_list">

  <!-- Container -->
  <div class="container grid-container global-offset-1">

    <!-- inner -->
    <div class="news_list__inner">


      <!-- List -->
      <div class="news_list__list">

      @while( $wp_query->have_posts() )
        {{ $wp_query->the_post() }}
        @php
          $cat = get_the_category(get_the_ID())[0]->name;
        @endphp

        <!-- Item -->
          <a href="{{ the_permalink() }}" class="news_list__list-item">

          @if( $cat )
            <!-- cat -->
              <small class="news_list__list-item-cat">
                {{ $cat }}
              </small>
              <!-- end cat -->
          @endif

          <!-- Image -->
            <div class="news_list__list-item-image">

              @if( has_post_thumbnail() )
                {!! get_the_post_thumbnail( get_the_ID(), '300x400' ) !!}
              @else
                <img src="{{ get_template_directory_uri() . '/assets/images/not-image-300x400.png' }}" alt="">
              @endif

            </div>
            <!-- End Image -->

            <!-- Title -->
            <h4 class="news_list__list-item-title">
              {{ the_title() }}
            </h4>
            <!-- End Title -->

          @if( has_excerpt() )
            <!-- excerpt -->
              <div class="news_list__list-item-excerpt">

                {{ the_excerpt() }}

              </div>
              <!-- End excerpt -->
          @endif

          <!-- Read More -->
            <span class="news_list__list-item-link">
              {{ __( 'Read More', 'pmf' ) }}
            </span>
            <!-- End Read More -->

          </a>
          <!-- End Item -->
        @endwhile
        {!! wp_reset_postdata() !!}
      </div>
      <!-- End List -->

      <!-- nav -->
      <div class="pagination">
        <!-- Navigation -->
      {{ the_posts_pagination([
        'show_all'              => true,
        'screen_reader_text'    => ' ',
        'prev_text'             => '&laquo;',
        'next_text'             => '&raquo;'
      ]) }}
      <!-- Navigation -->
      </div>
      <!-- end nav -->

    </div>
    <!-- end inner -->

  </div>
  <!-- End Container -->

</section>
<!-- End Component: News List -->

@php
  wp_reset_query();
@endphp
