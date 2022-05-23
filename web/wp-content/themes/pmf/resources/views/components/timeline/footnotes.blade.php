<!-- Start Component: Footnotes -->
<section class="footnotes">

  @empty( !$field['notes'] )
    <ul class="footnotes-content">
      @foreach($field['notes'] as $note)
        <li id="fn-{{ $loop->iteration }}">
          <span class="footnote-id">({{ $loop->iteration }})</span>
          @empty(!$note['note_text']) {{ $note['note_text'] }} @endempty
          @empty(!$note['note_link']) <a href="{{ $note['note_link']['url'] }}" target="{{ $note['note_link']['target'] }}">{{ $note['note_link']['title'] }} </a>@endempty
        </li>
      @endforeach
    </li>
  @endempty

</section>
<!-- End Component: Footnotes -->
