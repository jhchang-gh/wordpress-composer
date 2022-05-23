<!-- Start Component: Intro Biography -->
<section class="intro-biography">
  @php
    $field = get_field('heroes_slider','options');
  @endphp
  <!-- Container -->
  <div class="container grid-container global-offset-1">
    <div class="intro-biography__breadcrumbs">
      @empty (!$field['link'])
        <a href="{{ $field['link']['url'] }}" target="{{ $field['link']['target'] }}" class="intro-biography__breadcrumbs__link">
          Back
        </a>
      @endempty

    </div>
    <!-- Image -->
    <div class="intro-biography__img">

      @if( has_post_thumbnail() )
        <!-- Image -->
            {!! the_post_thumbnail() !!}


          <!-- End Image -->
        @endif
    </div>
    <!-- End Image -->

    <!-- Text -->
    <div class="intro-biography__text">

      <!-- subtitle -->
      <span class="intro-biography__text__subtitle">
        {{_e('9/11 Pentagon Memorial Heroes','pmf')}}
      </span>
      <!-- end subtitle -->

      <!-- Title -->
      <h1 class="intro-biography__text__title">
       {{the_title()}}
      </h1>
      <!-- End Title -->

      <div class="intro-biography__text__text">

        @empty( !get_field( 'biography_date_of_birth', get_the_ID() ) )

          <p>{{_e('Born ','pmf').birth_date().', '.calculateAge().' years old' }} </p>
        @endempty

      </div>

    </div>
    <!-- End Text -->

  </div>
  <!-- End Container -->



</section>
<!-- End Component: Intro Biography -->
