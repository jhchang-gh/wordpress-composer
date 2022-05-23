<!-- Start Component: Home Intro -->
<section class="home-intro" style="background-image: url( {{ $field['image'] }} );">

  <!-- Container -->
  <div class="container grid-container global-offset-1">

    <!-- text -->
    <div class="home-intro__text">

      <!-- subtitle -->
      <span class="home-intro__text__subtitle">
            {{ $field['label'] }}
          </span>
      <!-- end subtitle -->

      <!-- title -->
      <h1 class="home-intro__text__title">
        {{ $field['title'] }}
      </h1>
      <!-- end title -->

      <!-- introtext -->
      <p>
        {{ $field['subtitle'] }}
      </p>
      <!-- end introtext -->

      <!-- btn -->
      <a href="{{ $field['link']['url'] }}" @if (!empty($field['link']['target'])) target="_blank: @else target="_self" @endif class="btn btn-white btn-opacity btn-uppercase">
        <span><i></i>{{ $field['link']['title'] }} </span>
      </a>
      <!-- end btn -->

    </div>
    <!-- end text -->

  </div>
  <!-- End Container -->


</section>
<!-- End Component: Home Intro -->
