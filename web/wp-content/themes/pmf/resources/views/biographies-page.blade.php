{{--
  Template Name: Biographies Page
  Template Post Type: page
--}}

@extends('layouts.app',['body_class' => 'biographiesPage'])

@section('content')

@if(!empty($fields['content']))
    @foreach($fields['content'] as $field)
        @include('components.'.$field['acf_fc_layout'])
    @endforeach
@endif


<!-- Start Component: Scroll Top -->
<a href="#top" class="scroll scroll__top"></a>
<!-- End Component: Scroll Top -->

@endsection
