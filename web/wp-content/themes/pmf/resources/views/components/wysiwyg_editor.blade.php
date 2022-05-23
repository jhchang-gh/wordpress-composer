<!-- Start Component: Intro Text -->
<section class="intro-text wysiwyg-editor">

  <!-- Container -->
  <div class="container grid-container global-offset-1">

    <!-- inner -->
    <div class="intro-text__inner">

      <!-- row -->
      <div class="intro-text__inner__row">

        <!-- left -->
        <div class="intro-text__inner__row__left">


         @empty( !$field['text'] )
            <div class="simple_text">
              {!! $field['text'] !!}
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
<!-- End Component: Intro Text -->
