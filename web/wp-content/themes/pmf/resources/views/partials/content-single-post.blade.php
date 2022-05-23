@extends('layouts.app')

@php
  $fields['content'] = get_field( 'content', get_the_ID() );
@endphp

@section('content')
  @if(!empty($fields['content']))
    @foreach($fields['content'] as $field)
      @include('components.'.$field['acf_fc_layout'])
    @endforeach
  @endif
@endsection
