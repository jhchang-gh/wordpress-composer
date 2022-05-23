<!-- Start Component: Intro Text -->
<section class="cite_block">

  <!-- Container Fluid -->
  <div class="grid-container container-fluid">

    <!-- inner -->
    <div class="cite_block__inner">

      <!-- Container Fluid -->
      <div class="grid-container container ">

        @empty( !$field['text'] )
          <cite class="cite_block__cite">
            <span>{{ $field['text'] }}</span>
          </cite>
        @endempty
        @empty( !$field['name'] )
          <p class="cite_block__name">
            {{ $field['name'] }}
          </p>
        @endempty
        @empty( !$field['position'] )
          <p class="cite_block__position">
            {{ $field['position'] }}
          </p>
        @endempty

      </div>
      <!-- End Container-->
    </div>
    <!-- end inner -->

  </div>
  <!-- End Container Fluid-->

</section>
<!-- End Component: Intro Text -->
