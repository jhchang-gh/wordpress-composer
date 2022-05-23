export default {
  init() {
    /**
     * Delete Loadmore Button when nothing to load
     */

// The node to be monitored
    let target = $( '.newposts' )[0];

// Create an observer instance
    let observer = new MutationObserver(function( mutations ) {
      mutations.forEach(function( mutation ) {
        let newNodes = mutation.addedNodes; // DOM NodeList
        if( newNodes !== null ) { // If there are new nodes added
          let $nodes = $( newNodes ); // jQuery set
          $nodes.each(function() {
            let $node = $( this );
            if( $node.hasClass( 'no-results' ) ) {
              console.log('checked');
              $('.show_more').hide();
              $('.no-results').hide();
            }
          });
        }
      });
    });

// Configuration of the observer:
    let config = {
      attributes: true,
      childList: true,
      characterData: true,
    };
    if($('body').hasClass('search')) {
      // Pass in the target node, as well as the observer options
      observer.observe(target, config);
    }

    /****/

    let scrollPage = 2
    $('.show_more').click(function(){

          let button = $(this),
          flag = stopFlag(),
          url_string = window.location.href,
          url = new URL(url_string),
          searchString = url.searchParams.get('s'),
          data = {
            'action': 'loadmore',
            //'query': misha_loadmore_params.posts, // that's how we get params from wp_localize_script() function
            'page' : scrollPage,
            'search' : searchString,
          };

      if (flag < 1) {
        $.ajax({ // you can also use $.post here
          url: 'wp/wp-admin/admin-ajax.php', // AJAX handler
          data: data,
          type: 'POST',
          beforeSend: function () {
            button.text('Loading...'); // change the button text, you can also add a preloader image
          },
          complete: function(){
            $('.show_more').hide();
            //$content.removeClass('loader');

          },
          success: function (data) {
            console.log(scrollPage);
            if (data) {
              button.text('Show More Results') // insert new posts
              $('.newposts').append(data);
              let $maxPages = $('#max-pages').data('maxpages');
              scrollPage++;
              if (scrollPage <= $maxPages) {
                $('.show_more').show();
              }


            } else {
              button.remove(); // if no data, remove the button as well
            }
          },
        });
      } else {
        button.remove();
      }
    });
    function stopFlag() {
      let container = $('.search-results .intro-text__inner__row__left'),
        noResultDiv = container.find('.no-results'),
        flag;

      if (noResultDiv.length > 0) {
        flag = 1
      } else {
        flag = 0
      }
      //console.log(noResultDiv);
      //console.log('first Flag =' + flag);
      return flag;
    }
  },
  finalize() {

  },
};
