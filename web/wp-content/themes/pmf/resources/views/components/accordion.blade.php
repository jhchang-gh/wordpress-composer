<!-- Start Component: Accordion -->
<section class="accordion ">

  <!-- Container -->
  <div class="container grid-container global-offset-1">

    <!-- inner -->
    <div class="accordion__inner">

      <!-- row -->
      <div class="accordion__inner__row">

        <!-- left -->
        <div class="accordion__inner__row__left">

        @empty( !$field['items'] )
            <ul class="accordion__wrapper">
              @foreach( $field['items'] as $item)
                <li class="accordion__item">
                  <a href="#" class="accordion__item__title"> {{ $item['title'] }} </a>
                  <div class="accordion__item__content">{{ $item['text'] }}</div>
                </li>
              @endforeach
            </ul>
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
<!-- End Component: Accordion -->
