<!-- Start Component: Video and Caption -->
<section class="intro-text video-caption">

  <!-- Container -->
  <div class="container grid-container global-offset-1">

    <!-- inner -->
    <div class="intro-text__inner">

      <!-- row -->
      <div class="intro-text__inner__row">

        <!-- left -->
        <div class="intro-text__inner__row__left">


          @empty( !$field['video_cover'] )
            <a data-fancybox href="@if( $field['type_of_video'] == true ) {{ $field['embed_video_url'] }} @else{{ $field['video_file'] }}@endif" class="video-caption__cover-image" style="background-image: url({{ $field['video_cover'] }})">

            </a>
          @endempty

        </div>
        <!-- end left -->

        <!-- right -->
        @empty( !$field['caption'] )
          <div class="intro-text__inner__row__right">

            <div class="text">
              <span>{{ $field['caption']['title'] }}</span>
              <p>{{ $field['caption']['text'] }}</p>

            </div>

          </div>
        @endempty
      <!-- end right -->

      </div>
      <!-- end row -->

    </div>
    <!-- end inner -->

  </div>
  <!-- End Container -->

</section>
<!-- End Component: Video and Caption -->
