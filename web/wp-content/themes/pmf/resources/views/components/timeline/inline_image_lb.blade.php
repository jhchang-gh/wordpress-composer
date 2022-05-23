<!-- Start Component: Card text -->
<section class="card-image lightbox">

  @empty( !$field['image'] )
    <a href="{{ $field['image']['url'] }}" data-fancybox class="simple_text">
      <img src = "{{ $field['image']['sizes']['w460'] }}">

    </a>
  @endempty

</section>
<!-- End Component: Card Text -->
