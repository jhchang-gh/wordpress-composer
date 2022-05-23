<!-- Start Component: Intro Text 2 -->
<section class="intro-text intro-text-v2 @if($field['no_img_above']) no-hero @endif {{ $field['position'] }}">

  <!-- Container-fluid -->
  <div class="container-fluid grid-container">

    <!-- inner -->
    <div class="intro-text__inner">

      <!-- Container -->
      <div class="container grid-container">

        <!-- Title text -->
        <!-- row -->
        <div class="intro-text__inner__row">

          <!-- left -->
          <div class="intro-text__inner__row__left">


            @empty( !$field['intro_text'] )
              <h2 class="title">
                {!!  $field['intro_text'] !!}
              </h2>
            @endempty


          </div>
          <!-- end left -->
        </div>
        <!-- End Title text -->

        <!-- row -->
        <div class="intro-text__inner__row">

        <!-- left -->
        <div class="intro-text__inner__row__left @if( empty($field['right_text']['text']) ) full @endif">


              @empty( !$field['text'] )
                <div class="simple_text">
                  {!! $field['text'] !!}
                </div>
              @endempty

        </div>
        <!-- end left -->

        <!-- right -->

        @empty( !$field['right_text']['text'] )
          <div class="intro-text__inner__row__right">

            <div class="text">
              <span>{{ $field['right_text']['title'] }}</span>
              <p>{{ $field['right_text']['text'] }}</p>
              @empty( !$field['right_text']['link'] )
                <a href="{{ $field['right_text']['link']['url'] }}" target="{{ $field['right_text']['link']['target'] }}">{{ $field['right_text']['link']['title'] }}</a>
              @endempty
            </div>

          </div>
        @endempty
        <!-- end right -->

      </div>
      <!-- end row -->

      </div>
        <!-- End Container-->
    </div>
    <!-- end inner -->

  </div>
  <!-- End Container fluid-->

</section>
<!-- End Component: Intro Text -->
