@if( $query->have_posts() )

  @while( $query->have_posts() )

    @php( $query->the_post() )

    @if( get_post_type() == 'biographies' )
      <?php
        $categories = get_categories( [
            'taxonomy'     => 'locations',
        ] );
      ?>
      <!-- Header -->
      <div class="map__modal__content__header @if( ! has_post_thumbnail() ) normal @endif">
        <span>
          {{ __( 'On Board', 'pmf' ) }} {{ $categories[0]->name }}
        </span>
        <h2 class="title">{{ the_title() }}</h2>
        <p>{{_e('Born ','pmf').birth_date().', '.calculateAge().' years old' }}</p>
      </div>
      <!-- End Header -->

      <!-- Text -->
      <div class="map__modal__content__text">

        @if( has_post_thumbnail() )
          <!-- Photo -->
          <div class="map__modal__content__photo">

            <!-- img -->
            <div class="map__modal__content__photo-image">
              {!! the_post_thumbnail( '270x360' ) !!}
            </div>
            <!-- end img -->

          </div>
          <!-- End Photo -->
        @endif

        <div class="map__modal__content__detail">
          {{ the_content() }}
        </div>

      </div>
      <!-- End Text -->

      <!-- Footer -->
      <div class="map__modal__content__footer">
        <a href="{{ the_permalink() }}">
          {{ __( 'View Full Bio', 'pmf' ) }}
        </a>
      </div>
      <!-- End Footer -->

    @endif

    @if( get_post_type() == 'memorial-info' )
      <!-- Header -->
      <div class="map__modal__content__header normal">
        <h2 class="title">{{ the_title() }}</h2>
        <?php
        $subheading = get_field( 'subheading', get_the_ID() );
        ?>
        @if( $subheading )
          <p>{{ $subheading }}</p>
        @endif
      </div>
      <!-- End Header -->

      <!-- Text -->
      <div class="map__modal__content__text">

        <?php
          $content = get_field( 'content', get_the_ID() );
        ?>

        @if( $content )

          @foreach( $content as $item )

            @include('partials.map.'.$item['acf_fc_layout'], [ 'item' => $item ])

          @endforeach

        @endif

      </div>
      <!-- End Text -->

      <!-- Footer -->
{{--      <div class="map__modal__content__footer">--}}
{{--        <a href="{{ the_permalink() }}">--}}
{{--          {{ __( 'View Full Page', 'pmf' ) }}--}}
{{--        </a>--}}
{{--      </div>--}}
      <!-- End Footer -->

    @endif

  @endwhile

@endif
