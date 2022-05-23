<!-- Start Component: Grid -->
@php
  $items = $field['pages'];
@endphp
@if(  $items )
<section class="grid">

  <!-- Container -->
  <div class="container grid-container global-offset-1">

    <!-- Inner -->
    <div class="grid__inner border-bottom">

      <!-- Row -->
      <div class="grid__row">
      @foreach($items as $item )
        @if ($loop->first)
          @php
            //$image_args = [ 'height' => 530, 'class' => 'grid__row__col__image_desctope' ]
            $size = 'h530';
            $classes = 'grid__row__col__image_desctope';
          @endphp
        @else($loop->last)
          @php
            //$image_args = [ 'height' => 315, 'class' => 'grid__row__col__image_desctope' ]
            $size = 'h530';
            $classes = 'grid__row__col__image_desctope';
          @endphp
        @endif
        <!-- Col -->
        <a href="{{ $item['page'] }}" class="grid__row__col">
          <h2 class="grid__row__col__title">{{ $item['title'] }}</h2>
          <img
            src="{{$item['image']['sizes'][$size]}}"
            alt="{{ $item['title'] }}-image"
            class="{{ $classes }}"
          >
          <img
            src="{{$item['image']['sizes']['800x600']}}"
            alt="{{ $item['title'] }}-image"
            class="grid__row__col__image_mobile"
          >

        </a>
        <!-- End Col -->
      @endforeach


      </div>
      <!-- End Row -->

    </div>
    <!-- End Inner -->

  </div>
  <!-- End Container -->

</section>
@endif
<!-- End Component: Grid -->

