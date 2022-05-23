<!-- Start Component: Intro Default -->
<section class="intro-default @empty( $field['image'] ) no-hero  @endempty">

  <!-- Text -->
  <div class="intro-default__text">

    <!-- Container -->
    <div class="container grid-container global-offset-1 @empty( $field['image'] ) border-bottom @endempty">

      <!-- Title -->
      <h1 class="intro-default__text__title">
        @empty( !$field['title'] )
          {{ $field['title'] }}
        @endempty
      </h1>
      <!-- End Title -->
      @empty( !$field['subtitle'] )
        <div class="intro-default__text__text">
          {!!  $field['subtitle'] !!}
        </div>
      @endempty

    </div>
    <!-- End Container -->

  </div>
  <!-- End Text -->

  <!-- Image -->
  @empty( !$field['image'] )
    <div class="intro-default__image">
      <img
        src="{{$field['image']['sizes']['h640']}}"
        alt="{{ $field['image']['alt'] }}"
      >


    </div>
  @endempty
  <!-- End Image -->

</section>
<!-- End Component: Intro Default -->
