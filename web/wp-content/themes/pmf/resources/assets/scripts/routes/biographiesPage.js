/**
 *  InfiniteScroll
 */
/*
$(document).ready(function ($) {
  stopFlag();
  let scrollPage = 2,
    canBeLoaded = true,
   // bottomOffset = 2500;
    footerHeight = $('.footer').height(),
    cardsHeight = $('.cards').height(),
    bottomOffset =  footerHeight + cardsHeight + 1500;
  //console.log('offset = '+ bottomOffset);
  $(window).scroll(function () {
    let filter = $('#filter');

    if ($(document).scrollTop() > ($(document).height() - bottomOffset) && canBeLoaded == true) {
      //console.log(bottomOffset);
      let flag = stopFlag();
      if (flag < 1) {
        $.ajax({
          url: filter.attr('action'),
          data: filter.serialize() + '&paged=' + scrollPage,
          type: 'POST',
          beforeSend: function () {
            // you can also add your own preloader here
            // you see, the AJAX call is in process, we shouldn't run it again until complete
            canBeLoaded = false;
          },
          success: function (data) {

            if (data) {
              $('.heroes-list__list').append(data); // insert data
              setTimeout(function() {
                $('.heroes-list__list__col').removeClass('fade-deactive');
                $('.heroes-list__list__col').addClass('fade-active');
              },350);
              canBeLoaded = true;
              scrollPage++;
              //$('.no-results').text('All posts are shown.');
              $('.no-results').hide();
              $('.no-results').css('width','100%');
            }
            //console.log(filter.serialize() + '&paged=' + scrollPage);
           // $('.no-results').text('All posts are shown.');
            $('.no-results').hide();
            $('.no-results').css('width','100%');

          },
        });
      } else {
        $('.no-results').hide();
        $('.no-results').css('width','100%');

        scrollPage = 2;
      }

      //console.log('page' + scrollPage);

    }

    return false;
  })
})
*/
/**
 * Delete Loadmore Button when nothing to load
 */

// The node to be monitored
let target = $( '.heroes-list__list' )[0];

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
          $('.heroes-list__loadmore').hide();
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
if($('body').hasClass('biographiesPage')) {
  // Pass in the target node, as well as the observer options
  observer.observe(target, config);
}



/**
 * Loadmore
 *
 */

$(document).ready(function ($) {
  //stopFlag();
  let scrollPage = 2,
    //canBeLoaded = true,
    filter = $('#filter');


  $(document).on('click', '#loadmore_btn', function () {
    let flag = stopFlag();
      //$content = $('body');
    if (flag < 1) {
      $.ajax({
        url: filter.attr('action'),
        data: filter.serialize() + '&paged=' + scrollPage,
        type: 'POST',
        beforeSend: function () {
          //$content.addClass('loader');
          $('#loadmore_btn').hide();
          $('.loadmore-loader').show();
          flag = 1;
        },
        complete: function(){
          $('.loadmore-loader').hide();
          //$content.removeClass('loader');

        },
        success: function (data) {

          if (data) {
            $(data).insertBefore('.heroes-list__loadmore');
            let $maxPages = $('#max-pages').data('maxpages');
            setTimeout(function () {
              $('.heroes-list__list__col').removeClass('fade-deactive');
              $('.heroes-list__list__col').addClass('fade-active');
            }, 150);
            //canBeLoaded = true;
            scrollPage++;
            if (scrollPage <= $maxPages) {
              $('#loadmore_btn').show();
            }

            $('.no-results').hide();
            $('.no-results').css('width', '100%');
          } else {
            flag = 1;
            $('.no-results').hide();
            $('.no-results').css('width', '100%');
            scrollPage = 2;
          }

        },
      });
    } else {
      $('.heroes-list__loadmore').hide();
      $('.no-results').hide();
      $('.no-results').css('width', '100%');

      //scrollPage = 2;
    }


    console.log('paged: '+scrollPage);
    //console.log('max: '+$maxPages);
    return false;

  });
  function stopFlag() {
    let container = $('.heroes-list__list'),
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

  function ajaxSubmit() {
    let filter = $('#filter'),
      $content = $('.heroes-list__list');
      scrollPage = 2;
    // filterData = filter.serializeArray(),
    //paged = filterData[5]['value'];
    //console.log(filterData);

    $.ajax({
      url: filter.attr('action'),
      data: filter.serialize(), // form data
      type: filter.attr('method'), // POST


      beforeSend: function () {
        $content.addClass('loader');
      },
      complete: function(){

        $content.removeClass('loader');

      },
      success: function (data) {
        stopFlag();
        let LoadmoreBtn = '<div class="heroes-list__loadmore container grid-container ">\n' +
          '         <button class="heroes-list__loadmore__btn btn" id="loadmore_btn">Load More</button> <div class="loader loadmore-loader" style="display: none">\n' +
          '       </div>'
        $('.heroes-list__list').html(data); // insert data
        let $maxPages = $('#max-pages').data('maxpages');
        console.log('MAXPAGE:' + $maxPages)
        console.log('CURRENT:' + scrollPage)
        if (scrollPage < $maxPages){
          $('.heroes-list__list').append(LoadmoreBtn);

        }

        $('.heroes-list__list__col').removeClass('fade-deactive');
        $('.heroes-list__list__col').addClass('fade-active');

        $('.heroes-list__panel__order__btn, .dropdown').removeClass('active');


      },
    });
    //console.log('flag -' + stopFlag());
    return false;
  }

  $(document).on('click', '.heroes-list__panel__filter input', function () {
    ajaxSubmit();
    //console.log('test')
  });

  $(document).on('click', '.heroes-list__panel__search__btn', function () {
    ajaxSubmit();

  });

  $('.heroes-list__panel__search__input').on('input', function () {
    let searchValue = $(this).val().length;
    if (searchValue > 0) {
      $(this).prev().find('.icon-search').hide();
      $(this).prev().find('.icon-delete').show();
    } else {
      $(this).prev().find('.icon-search').show();
      $(this).prev().find('.icon-delete').hide();
    }
    /*if (searchValue < 3 && searchValue !== 0) {
      $('.notification-tooltip').show();
    } else {
      $('.notification-tooltip').hide();
    }*/
    ajaxSubmit();
  });

  $(document).on('click', '.icon-delete', function () {
    $('.heroes-list__panel__search__input').val('');
    $(this).hide();
    $(this).prev('.icon-search').show();
    $('.notification-tooltip').hide();
  });

  $(document).on('click', '.heroes-list__panel__order label', function (e) {
    e.preventDefault();
    $(this).closest('.dropdown').removeClass('active');
    $('.heroes-list__panel__order label').removeClass('active');
    $('.heroes-list__panel__order__btn').removeClass('active');
    $(this).addClass('active');
    let check = $(this).prev();
    if (check.prop('checked'))
      check.prop('checked', false);
    else
      check.prop('checked', true);
    //console.log(check.prop('checked'))
    if ((check.prop('checked')) == true) {
      ajaxSubmit();
    }
  });

  $('.heroes-list__panel__search__input').keypress(function (e) {
    if (e.which == 13) {
      ajaxSubmit();
      return false;    //<---- Add this line
    }
  });
})


$('.heroes-list__panel__filter input ').next('label').keypress(function (e) {
  let key = e.which;
  if(key == 13)  // the enter key code
  {
    $(this).prev().click();
    console.log('Click')
    return false;
  }
});
$('.heroes-list__panel__order .dropdown-window > li').removeAttr('tabindex');
$('.heroes-list__panel__order').find('label').keypress(function (e) {
  let key = e.which;
  if(key == 13)  // the enter key code
  {
    $(this).click();
    console.log('Click')
    return false;
  }
});


