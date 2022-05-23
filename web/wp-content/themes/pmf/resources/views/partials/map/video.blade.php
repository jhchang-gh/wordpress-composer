<!-- Video -->
<div class="map__modal__content__text__row video">

    <!-- Embed -->
    <div class="video__embed">

      @if( $item['preview'] )
        <!-- preview -->
        <a href="{{ $item['preview'] }}" class="video__embed-preview mapVideoPreview" style="background-image: url('{{ $item['preview'] }}')"></a>
        <!-- End preview -->
      @endif

      {!! $item['embed_video_url'] !!}

    </div>
    <!-- End Embed -->

</div>
<!-- End Video -->
