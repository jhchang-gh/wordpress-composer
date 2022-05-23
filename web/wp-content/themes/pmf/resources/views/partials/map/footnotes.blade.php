<!-- Footnotes -->
<div class="map__modal__content__text__row footnotes">

  @if( $item['notes'] )
    <ul class="footnotes-content">
      @foreach( $item['notes'] as $note )
      <li>
        <span class="footnote-id">{{ $loop->iteration }})</span>
        @empty(!$note['note_text']) {{ $note['note_text'] }} @endempty
        @empty(!$note['note_link']) <a href="{{ $note['note_link']['url'] }}" target="{{ $note['note_link']['target'] }}">{{ $note['note_link']['title'] }} </a>@endempty
      </li>
      @endforeach
    </ul>
  @endif

</div>
<!-- End Footnotes -->
