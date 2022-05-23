<!-- Start Component: Intro Text -->
<section class="quick_fact">

  <!-- Container Fluid-->
  <div class="container-fluid grid-container">

    <!-- inner -->
    <div class="quick_fact__inner">

      <!-- Container-->
      <div class="container grid-container">

        <div class="quick_fact__left">
          @empty (!$field['fact_image'])
            <img
              src="{{$field['fact_image']['sizes']['288x288']}}"
              alt="{{ $field['fact_image']['alt'] }}"
            >

          @endempty
        </div>
        <div class="quick_fact__right">
          @empty(!$field['caption'])
            <div class="quick_fact__caption">
                {{ $field['caption'] }}
            </div>
          @endempty
          @empty(!$field['text'])
            <div class="quick_fact__text">
                 {{ $field['text'] }}
            </div>
          @endempty
          @empty(!$field['link'])
            <div class="quick_fact__link">
              <a href="{{ $field['link']['url'] }}" target="{{ $field['link']['target'] }}">{{ $field['link']['title'] }}</a>
            </div>
          @endempty
        </div>

      </div>
      <!-- End Container-->

    </div>
    <!-- end inner -->

  </div>
  <!-- End Container Fluid-->

</section>
<!-- End Component: Intro Text -->
