<!-- Start Component: Card Video  -->
<section class="card-video video-caption">


        <div class="card-video__wrapper">

          @php


              //var_dump($video_id);
                if(!$field['video_cover']) {
                  $video_id = $field['embed_video_url'];
                  $hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$video_id.php"));
                  $video_thumb = $hash[0]['thumbnail_medium'];
                }
                else {
                    $video_thumb = $field['video_cover'];
                }

          @endphp


            <a data-fancybox href="@if( $field['type_of_video'] == true ) https://player.vimeo.com/video/{{$field['embed_video_url']}} @else{{ $field['video_file'] }}@endif" class="video-caption__cover-image" aria-label="Open video" style="background-image: url({{ $video_thumb }})">

            </a>


        </div>






</section>
<!-- End Component: Card Video -->
