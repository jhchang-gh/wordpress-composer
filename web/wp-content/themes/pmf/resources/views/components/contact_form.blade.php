<!-- Start Component: Contact Form -->
<section class="intro-text contact-form-section">

  <!-- Container -->
  <div class="container grid-container global-offset-1">

    <!-- inner -->
    <div class="intro-text__inner">


      <!-- row -->
      <div class="intro-text__inner__row">

        <!-- left -->
        <div class="intro-text__inner__row__left">

        @empty( !$field['title'] )
            <div class="h2">
              {!! $field['title'] !!}
            </div>
         @endempty

          @empty( !$field['text'] )
            <div class="simple-text">
              {!! $field['text'] !!}
            </div>
          @endempty

         @empty( !$field['form'] )
            <div class="contact-form">
              {!! do_shortcode($field['form']) !!}
            </div>
         @endempty



        </div>
        <!-- end left -->



      </div>
      <!-- end row -->

    </div>
    <!-- end inner -->

  </div>
  <!-- End Container -->

</section>
<!-- End Component: Contact Form -->
