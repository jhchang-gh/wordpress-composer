<!-- Start Component: Column -->
<section class="column box column__image-right">

  <!-- Container-fluid -->
  <div class="container-fluid grid-container">

    <!-- Inner -->
    <div class="column__inner border-bottom">

      <!-- Container -->
      <div class="container grid-container">

        <!-- Grid -->
        <div class="column__grid">

          <!-- Grid > Left -->
          <div class="column__grid__left">
            <!-- center -->
            <div>

              <!-- subtitle -->
              @empty (!$field['label'])
                <span class="column__subtitle">
                {{ $field['label'] }}
              </span>
              @endempty
            <!-- end subtitle -->

              <!-- title -->
              @empty (!$field['title'])
                <h2 class="column__title">
                  {{ $field['title'] }}
                </h2>
              @endempty
            <!-- end title -->

              <!-- text -->
              @empty (!$field['text'])
                <div class="column__text">
                  <p>
                    {{ $field['text'] }}
                  </p>
                </div>
            @endempty
            <!-- end text -->

              <!-- footer -->
              <div class="column__footer">
                @empty (!$field['link'])
                  <a href="{{ $field['link']['url'] }}" target="{{ $field['link']['target'] }}" class="btn">
                    <span><i></i>{{ $field['link']['title'] }}</span>
                  </a>
                @endempty
              </div>
              <!-- end footer -->

            </div>
            <!-- end center -->

          </div>
          <!-- End Grid > Left -->

          <!-- Grid > Right -->
          <div class="column__grid__right">

            @empty (!$field['image'])

              <img
                src="{{$field['image']['sizes']['490x650']}}"
                alt="{{ $field['image']['alt'] }}"
              >
            @endempty

          </div>
          <!-- End Grid > Right -->

        </div>
        <!-- End Grid -->

      </div>
      <!-- End Container -->

    </div>
    <!-- End Inner -->

  </div>
  <!-- End Container-fluid -->

</section>
<!-- End Component: Column -->
