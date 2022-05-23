<!-- Start Component: Card text -->
<section class="card-text">

          @empty( !$field['text'] )
            <div class="simple_text">
              {!! $field['text'] !!}
            </div>
          @endempty

</section>
<!-- End Component: Card Text -->
