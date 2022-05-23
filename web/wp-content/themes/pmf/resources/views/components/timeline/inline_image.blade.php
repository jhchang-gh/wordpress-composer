<!-- Start Component: Card text -->
<section class="card-image">

  @empty( !$field['image'] )
    <div class="simple_text">

      <a href="{{ $field['image']['url'] }}" data-fancybox class="simple_text">
        <img src = "{{ $field['image']['sizes']['w460'] }}">

      </a>
    </div>
  @endempty

</section>
<!-- End Component: Card Text -->
