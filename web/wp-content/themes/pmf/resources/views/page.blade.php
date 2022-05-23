@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @if(!empty($fields['content']))
      @foreach($fields['content'] as $field)
        @include('components.'.$field['acf_fc_layout'])
      @endforeach
    @endif
  @endwhile
@endsection


