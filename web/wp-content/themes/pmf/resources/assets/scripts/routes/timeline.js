import Swiper from 'swiper';

export default {
  init() {


  },
  finalize() {
    /**
     * Tabs Controls
     */
    function trapFocus($modal) {

      // add all the elements inside modal which you want to make focusable
      const  focusableElements =
        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';
      const modal = document.querySelector($modal); // select the modal by it's id

      const firstFocusableElement = modal.querySelectorAll(focusableElements)[0]; // get first element to be focused inside modal
      //const firstFocusableElement = $('.header__btngroup__menu');
      const focusableContent = modal.querySelectorAll(focusableElements);
      const lastFocusableElement = focusableContent[focusableContent.length - 1]; // get last element to be focused inside modal


      document.addEventListener('keydown', function(e) {
        let isTabPressed = e.key === 'Tab' || e.keyCode === 9;

        if (!isTabPressed) {
          return;
        }

        if (e.shiftKey) { // if shift key pressed for shift + tab combination
          if (document.activeElement === firstFocusableElement) {
            lastFocusableElement.focus(); // add focus for the last focusable element
            e.preventDefault();
          }
        } else { // if tab key is pressed
          if (document.activeElement === lastFocusableElement) { // if focused has reached to last focusable element then focus first focusable element after pressing tab
            firstFocusableElement.focus();

            e.preventDefault();
          }
        }
        console.log(focusableContent)
      });

      //    firstFocusableElement.focus();
    }
    /**
     * Open by enter button
     * @param $selector
     */

    function keypress($selector) {
      $($selector).keypress(function (e) {
        let key = e.which;
        if(key == 13)  // the enter key code
        {
          $(this).click();
          return false;
        }
      });
    }

    /**
     * Init KeyPress for elements
     */
    keypress('a[data-fancybox]');

    $(document).ready(function (){
      $('[data-fancybox="gallery"]').fancybox({
        btnTpl: {

          arrowLeft:
            '<button data-fancybox-prev class="test fancybox-button fancybox-button--arrow_left" title="{{PREV}}">' +
            '<div><svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
            '<path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 0.567871L8.5725 1.61262L2.8875 7.31787H18V8.81787H2.8875L8.5725 14.4976L7.5 15.5679L0 8.06787L7.5 0.567871Z" fill="#233746"/>\n' +
            '</svg></div>' +
            '</button>',

          arrowRight:
            '<button data-fancybox-next class="fancybox-button fancybox-button--arrow_right" title="{{NEXT}}">' +
            '<div><svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
            '<path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 0.567871L9.4275 1.61262L15.1125 7.31787H0V8.81787H15.1125L9.4275 14.4976L10.5 15.5679L18 8.06787L10.5 0.567871Z" fill="#233746"/>\n' +
            '</svg></div>' +
            '</button>',
        },
      })
    })

    /**
     * Close Timeline Content
     * @click
     */
    function closeTimelineCard() {
      $('body').removeClass('modal-active');
      $('.modal-content').remove();
      $('#ajaxTimelineContent').removeAttr('aria-live','assertive');
      //if($('.flight-info.active'))
    }
    $('.timeline-card__close').click(function (){

      closeTimelineCard()

    })
    //keypress('.timeline-card__close');
    $('.timeline-card__close').keypress(function (e) {
      let key = e.which;
      if(key == 13)  // the enter key code
      {
        $('body').removeClass('modal-active');
        let currentCard = $('#ajaxTimelineContent').find('.modal-content').attr('data-id');
        $('.modal-content').remove();
        $('#ajaxTimelineContent').removeAttr('aria-live','assertive');
        $('.timeline__container__cards-wrapper').find('.timeline-card[data-id="' + currentCard + '"]').focus().removeClass('active');
        return false;
      }
    });

    /**
     * CloseCard Mouseup
     */
    $(document).mouseup(function (e) {
      let container = $('#ajaxTimelineContent');
      //dropdownButton = $('.dropdown-button.active');

      if (container.has(e.target).length === 0)  {
        closeTimelineCard()
      }

    });

    /**
     * fix sticky hover state
     */
    function fixHoverState()
    {
      var el = this;
      var par = el.parentNode;
      var next = el.nextSibling;
      par.removeChild(el);
      setTimeout(function() {par.insertBefore(el, next);}, 0)
    }

    /**
     *
     * @param e
     * @param type
     * @constructor
     */
      // eslint-disable-next-line no-unused-vars
    let LoadDetail = function (post = 0, element = 0, navigation = false) {

        var $ajax_content = $('#ajaxTimelineContent '),
        $ajax_wrapper = $('#ajaxTimelineContent .modal-content'),
        $buttons = $('.timeline-card__nav');

          //$modal        = $('.modal-content');
        /**
         * Ajax
         */
        $.ajax( {

          beforeSend  :   function(){
            $buttons.hide();
            //$ajax_wrapper.html('');
            $ajax_wrapper.remove();
            $ajax_content.addClass('preloader');
            showModalsFocusable ();

          },
          url         :   '/wp/wp-admin/admin-ajax.php',
          data        :   {
            action    :   'load_content',
            post      :   post,
          },
          //dataType    :   'json',
          type      :   'POST',
          complete    :   function(){

          },
          // eslint-disable-next-line no-unused-vars
          success     :   function( data ){
            //console.log('TEST')
            $ajax_content.append(data);
            $ajax_content.removeClass('preloader');
            $buttons.find('.swiper-button-next, .swiper-button-prev').unbind('mouseup');
            $buttons.show();
            $('.timeline-card__content-wrapper > .timeline-card__content').addClass('active');

            $(document).ready(function (){

              trapFocus('#ajaxTimelineContent, #timelineContentWrapper ');


            })
            /**
             * Swiper Timeline Cards Slider (when load ajax)
             */
            if ($('.card-slider').length > 0) {
              new Swiper('.card-slider  .swiper-container', {
                loop: true,
                slidesPerView: '1',
                grabCursor : true,
                speed           : 500,
                centeredSlides  : true,
                freeMode: false,
                initialSlide    : '0',
                pagination: {
                  el: '.card-slider  .swiper-pagination',
                  type: 'bullets',
                  clickable: true,
                  renderBullet: function () {
                    return '<span class="dot swiper-pagination-bullet"></span>';
                  },
                },

              });
            }
            $('[data-fancybox]').fancybox({
              btnTpl: {
                close:
                  '<button data-fancybox-close class="test  fancybox-button fancybox-button--close" title="{{CLOSE}}">' +
                  '<div><svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
                  '<path fill-rule="evenodd" clip-rule="evenodd" d="M10.7037 8.39342L1.9892 0.422852L0.442993 1.83707L9.15748 9.80763L0.442996 17.7782L1.9892 19.1924L10.7037 11.2218L18.9975 18.8076L20.5437 17.3934L12.2499 9.80763L20.5437 2.22184L18.9975 0.807628L10.7037 8.39342Z" fill="#233746"/>\n' +
                  '</svg></div>' +
                  '</button>',
                arrowLeft:
                  '<button data-fancybox-prev class="fancybox-button fancybox-button--arrow_left" title="{{PREV}}">' +
                  '<div><svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
                  '<path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 0.567871L8.5725 1.61262L2.8875 7.31787H18V8.81787H2.8875L8.5725 14.4976L7.5 15.5679L0 8.06787L7.5 0.567871Z" fill="#233746"/>\n' +
                  '</svg></div>' +
                  '</button>',

                arrowRight:
                  '<button data-fancybox-next class="fancybox-button fancybox-button--arrow_right" title="{{NEXT}}">' +
                  '<div><svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
                  '<path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 0.567871L9.4275 1.61262L15.1125 7.31787H0V8.81787H15.1125L9.4275 14.4976L10.5 15.5679L18 8.06787L10.5 0.567871Z" fill="#233746"/>\n' +
                  '</svg></div>' +
                  '</button>',
              },
            })

          },
          // eslint-disable-next-line no-undef

        } );

      }



    /**
     * Timeline Filter
     */
    $('.timeline-header__filter__form').delegate('input[type=checkbox]', 'change', function() {
      var $lis = $('.timeline-card').not('.last'),
        $checked = $('input:checked');
      if ($checked.length) {
        var selector = '';
        $($checked).each(function(index, element){


          if(selector === '') {
            selector += '[data-category~="' + element.id + '"]';
          } else {
            selector += ',[data-category~="' + element.id + '"]';
          }




        });

          $lis.hide();


          //console.log(selector);
          $lis.hide().filter(selector).show();

      } else {
        $lis.show();
      }
    });
    $(document).on('click', '.timeline-header__filter__form input', function(){
      if($(this).attr('id') !=='all') {
        $('.timeline-header__filter__form #all').prop('checked',false);
        if($('.timeline-header__filter__form input:checked').length === 0) {
          $('.timeline-header__filter__form #all').prop('checked',true);
        }
      } else {
        $('.timeline-header__filter__form input').prop('checked',false);
        $('.timeline-header__filter__form #all').prop('checked',true);
      }
      if($('.timeline-header__filter__form input:checked').length > 2) {
        $('.timeline-header__filter__form input').prop('checked',false);
        $('.timeline-header__filter__form #all').prop('checked',true);

      }
    });
    /**
     * Filter select by key press
     */

    $('.timeline-header__filter__form label').keypress(function (e) {
      let key = e.which;
      if(key == 13)  // the enter key code
      {
       // alert('test')
        $(this).find('input').click();
        return false;
      }
    });
    /**
     * Open filter
     */
    $(document).on('click', '.timeline__filter-scroll', function(e){
      $(this).toggleClass('active')
      $('.timeline-header__filter__wrapper').slideToggle(500)
      e.preventDefault()

      //$(this).toggleClass('active')

    });
    /*$(document).mouseup(function (e) {
      let container = $('.timeline-header__filter__wrapper');
        //content = $('.timeline-card__content.active');
      //dropdownButton = $('.dropdown-button.active');

      if (container.has(e.target).length === 0 && $('.timeline-header__filter__wrapper:hidden').length == 0)  {
        $('.timeline__filter-scroll').click();


        //container.hide();
        //$('.timeline__filter-scroll').removeClass('active');
      }

    });*/
    if(window.matchMedia('(max-width: 991px)').matches) {
      $(document).mouseup(function (e) {
        if (e.target.id !== 'filterToggler') {
          console.log('EMPTY SPACE' + e.target.id)
          let container = $('.timeline-header__filter__wrapper');
          if (container.has(e.target).length === 0) {
            $('.timeline-header__filter__wrapper').slideUp(500)
            $('#filterToggler').removeClass('active');
            e.preventDefault()
          }
        } else {
          console.log('THIS IS TOGGLER' + e.target.id)
        }
        console.log(e.target.id)
      });
    }

    /**
     * Timeline Cards Navigation and Open
     */
    $(function() {
      let $savePrevCardId,//for save opened card ID in global variable
          $thisLine, // get current TimeLine
          $nextCard,
          $prevCard;

        let lastCard = $('.timeline__container__cards-wrapper').find('.timeline-card:last');
        lastCard.addClass('last');
        //console.log(test);


      /**
       * Open Timeline Content
       * @click
       */
      $('.timeline-card.clickable').click (function(e) {
        let  post = $(this).data('post_id'),
        //$checkNextLine =   $(this).nextAll('.clickable').first().data('flight').split(' '),
        $target = $('.timeline-card__content-wrapper > .timeline-card__content');
        $savePrevCardId = post; //save opened card ID in global variable
        $thisLine = $(this).data('flight').split(' ');
        $thisLine = $thisLine[0];

        $nextCard = $(this).nextAll('.' + $thisLine).first();
        $prevCard = $(this).prevAll('.' + $thisLine).first();
        e.preventDefault();
        $('body').addClass('modal-active');
        //$('.timeline-card__content').addClass('active');
        $(this).addClass('active');

        //clickCard(e);
        //console.log($(e.target).attr('id'));
        console.log($target);
        console.log($nextCard.data('flight'));
        console.log($thisLine);
        console.log($prevCard);

        LoadDetail(post);
        $('#ajaxTimelineContent').focus().attr('aria-live','assertive');
        //$('.timeline-card__content').focus();
        //if($thisLine)
       /* if ($nextCard.length === 0 ) {
          $('.timeline-card__nav__btn-wrapper.btn-next').addClass('disabled');
        } else {
          $('.timeline-card__nav__btn-wrapper.btn-next').removeClass('disabled');
        }
        */
        if($(this).hasClass('last')) {
          $('.timeline-card__nav__btn-wrapper.btn-next').addClass('disabled');
        } else {
          $('.timeline-card__nav__btn-wrapper.btn-next').removeClass('disabled');
        }
        if ($prevCard.length === 0) {
          $('.timeline-card__nav__btn-wrapper.btn-prev').addClass('disabled');
        } else {
          $('.timeline-card__nav__btn-wrapper.btn-prev').removeClass('disabled');
        }


      });

      /**
       *Open card by KeyPress
       */
      keypress('.timeline-card.clickable');


      /**
       * Timeline Cards Navigation Sticky Buttons
       */

      $('#wrapper').scroll(function() {
        let hT = $('.timeline__container__left .date').offset().top,
          hH = $('.timeline__container__left .date').outerHeight(),
          wH = $('#wrapper').height(),
          wS = $(this).scrollTop();
        if (wS > (hT+hH-wH) ){
          $('.timeline__swiper-controls').addClass('sticky')
        } else {
          $('.timeline__swiper-controls').removeClass('sticky')
        }
        console.log(wH);
      });


      /**
       * Timeline Cards Navigation Next
       */

      $(document).on('click', '.timeline-card__nav__btn-wrapper.btn-next', function () {

        let $thisCard = $(this).parents('#ajaxTimelineContent').find('.modal-content'),
          $thisCardID = $thisCard.data('id'),
          $thisTimelineCard = $('.timeline-card[data-post_id="' + $thisCardID + '"]'),
          $thisTimeLineCardFlight = $thisTimelineCard.data('flight'),
          $nextTimelineCard = $thisTimelineCard.nextAll('.clickable.' + $thisTimeLineCardFlight).first(),
          $secondTimelineCard = $thisTimelineCard.nextAll('.clickable.' + $thisTimeLineCardFlight).eq(1),
          $prevTimelineCard = $thisTimelineCard.prevAll('.clickable.' + $thisTimeLineCardFlight).first();

        if ($nextTimelineCard.data('flight') === 'line-3 common-line' || $nextTimelineCard.data('flight') === undefined) {

          $nextTimelineCard = $thisTimelineCard.nextAll('.line-3').first();
         // $secondTimelineCard = $thisTimelineCard.nextAll('.line-3').eq(1);
        }
        if ($secondTimelineCard.data('flight')=='line-3 common-line' || $secondTimelineCard.data('flight') === undefined) {
          $secondTimelineCard = $thisTimelineCard.nextAll('.line-3').eq(1);
        }
        //console.log($thisTimeLineCardFlight)

        let $nextCardID = $nextTimelineCard.data('post_id'),
            $secondCardID = $secondTimelineCard.data('post_id'),
            $prevCardID = $prevTimelineCard.data('post_id');

        $savePrevCardId = $thisCardID;

        if ($nextCardID !== undefined && $(this).not('.no-click')) {
          $thisCard.removeClass('active');
          $thisTimelineCard.removeClass('active');
          LoadDetail($nextCardID);
          $nextTimelineCard.addClass('active');
          /*************/
          if($('.timeline__swiper-controls .swiper-button-next').hasClass('disabled')){
            //console.log('test')
          }
          /**************/
          if ($('body').hasClass('oneline-timeline-page')||$('body').hasClass('oneline-timeline-page-v2')) {
            $('#timelineContainer').animate({
              scrollLeft: $('.timeline-card[data-post_id="' + $nextCardID + '"]').position().left + 200,
            }, 500);
          } else {
            $('#timelineContainer').animate({
              scrollLeft: $('.timeline-card[data-post_id="' + $nextCardID + '"]').position().left + 700,
            }, 500);
          }


          //console.log('second: '+$secondCardID);
          //console.log('next: '+$nextCardID );
          $('.timeline-card__nav__btn-wrapper.btn-prev').removeClass('disabled');
        } /*else {
          $(this).addClass('disabled');
        }*/
        if($secondCardID == undefined) {
          $(this).addClass('disabled');
        }
        if ($prevCardID !== undefined) {
            $('.timeline-card__nav__btn-wrapper.btn-prev').removeClass('disabled')
        }
        fixHoverState();
        return false;
      });

      keypress('.timeline-card__nav__btn-wrapper.btn-next');

      /**
       * Timeline Cards Navigation Prev
       */

      $(document).on('click', '.timeline-card__nav__btn-wrapper.btn-prev', function () {
        let $thisCard = $(this).parents('#ajaxTimelineContent').find('.modal-content'),
          $thisCardID = $thisCard.data('id'),
          $thisTimelineCard = $('.timeline-card[data-post_id="' + $thisCardID + '"]'),
          $thisTimeLineCardFlight = $thisTimelineCard.data('flight'),
          $prevTimeLineCardFlight,
          $prevTimeLineCard,
          $nextTimelineCard = $thisTimelineCard.prevAll('.clickable.' + $thisTimeLineCardFlight).first(),
          $secondTimelineCard = $thisTimelineCard.prevAll('.clickable.' + $thisTimeLineCardFlight).eq(1),
          $prevTimelineCard = $thisTimelineCard.nextAll('.clickable').first();

        if($savePrevCardId !== undefined && $(this).not('.no-click')) {
          $prevTimeLineCard = $('.timeline-card[data-post_id="' + $savePrevCardId + '"]');
          $prevTimeLineCardFlight = $prevTimeLineCard.data('flight').split(' ');
          $prevTimeLineCardFlight = $prevTimeLineCardFlight[0];

          $nextTimelineCard = $thisTimelineCard.prevAll('.clickable.'+$prevTimeLineCardFlight).first();

        }
        if ($nextTimelineCard.data('flight') === 'line-3 common-line' || $nextTimelineCard.data('flight') === undefined){

          $nextTimelineCard = $thisTimelineCard.prevAll('.clickable.line-3').first()
        }
        if ($secondTimelineCard.data('flight')=='line-3 common-line' || $secondTimelineCard.data('flight') === undefined) {
          $secondTimelineCard = $thisTimelineCard.nextAll('.line-3').eq(1);
        }
        let $nextCardID = $nextTimelineCard.data('post_id'),
            $secondCardID = $secondTimelineCard.data('post_id'),
            $prevCardID = $prevTimelineCard.data('post_id');

        if ($nextCardID !== undefined) {
          $thisCard.removeClass('active');
          $thisTimelineCard.removeClass('active');
          LoadDetail($nextCardID);
          $nextTimelineCard.addClass('active');
          if ($('body').hasClass('oneline-timeline-page')) {
            $('#timelineContainer').animate({
              scrollLeft: $('.timeline-card[data-post_id="' + $nextCardID + '"]').position().left + 200,
            }, 500);
          } else {
            $('#timelineContainer').animate({
              scrollLeft: $('.timeline-card[data-post_id="' + $nextCardID + '"]').position().left + 700,
            }, 500);
          }

          // sideScroll('#timelineContainer','left',50,$nextCardDistance,160);
          $(this).removeClass('disabled');
        } else {
          $(this).addClass('disabled');
        }
        if($secondCardID == undefined) {
          $(this).addClass('disabled');
        }
        if ($prevCardID !== undefined) {
          $('.timeline-card__nav__btn-wrapper.btn-next').removeClass('disabled')
        }
        if($thisTimelineCard.hasClass('last') ) {
          $('.timeline-card__nav__btn-wrapper.btn-next').removeClass('disabled')
        }
        console.log('second_Prev: ' + $secondCardID)
        fixHoverState()

        return false;
      });
    })
    keypress('.timeline-card__nav__btn-wrapper.btn-prev');



    /**
     * Timeline Sticky labels
     */

    $('#timelineContainer').scroll(function() {
      let currentScroll = $(this).scrollLeft();
          //lastCardPosition = $('.timeline-card:last-of-type').position().left;


      /*if (currentScroll >= lastCardPosition){
        console.log('current scroll more')
        $('.timeline__swiper-controls .swiper-button-next').addClass('disabled');
      } else {
        $('.timeline__swiper-controls .swiper-button-next').removeClass('disabled');
      }*/
      if (currentScroll > 0) {
        $('.swiper-button-prev').removeClass('disabled');
      }
      if ( $(this)[0].scrollWidth  <= ($(this).scrollLeft() + $(this)[0].clientWidth)) {
        console.log($(this)[0].scrollWidth)
        console.log($(this).scrollLeft() + $(this)[0].clientWidth)
        $('#timelineNext').addClass('disabled');
      } else {
        $('#timelineNext').removeClass('disabled');
      }

      if($('.timeline__wrapper.oneline').length > 0) {
        let maxWidth = $('.timeline__container__right').width();

        if($(this).scrollLeft() >=500){
          $('.timeline__container__center').find('.sticky-left').css({'left' : $(this).scrollLeft() -550, 'width':'234px'});
          $(this).addClass('scroll-left');
        } else {
          $(this).removeClass('scroll-left');
          $('.timeline__container__center').find('.sticky-left').css({'left':'unset', 'width':'502px'});
        }

       /* if(currentScroll >= maxWidth) {
          $('#timelineNext').addClass('disabled')
        } else {
          $('#timelineNext').removeClass('disabled')
        }*/
        console.log('max: '+maxWidth)

      } else {
        let legend = $('.timeline__legend__flights.sticky-left');
        let legendContainer = $('#legend');
        let stickyContainer = $('#timelineLegendDesctop');
        let topPos = $('#timelineContainer').position();
        console.log(topPos.top);
        /*if($(this).scrollLeft() >=1284){
          $('.timeline__container__center').find('.sticky-left').css({'left' : $(this).scrollLeft() -550, 'width':'234px'});
          $(this).addClass('scroll-left');
        } else {
          $(this).removeClass('scroll-left');
          $('.timeline__container__center').find('.sticky-left').css({'left':'unset', 'width':'502px'});
        }*/
        if($(this).scrollLeft() >=1284){
          legend.css('top',Number(topPos.top));
          stickyContainer.append(legend);
          legendContainer.html();
        } else {
          legend.css('top','');
          legendContainer.append(legend);
          stickyContainer.html();
        }

      }



    });
    /**
     * Close card
     */
    $(document).on('click', '.timeline-card__close', function(){
      hideModalsFocusable ();
      let $thisCard =  $(this).closest('.timeline-card__content'),
        $cardID = $thisCard.attr('id'),
        $thisTimelineCard = $('.timeline-card[data-id="'+$cardID+'"]');
      $thisTimelineCard.removeClass('active');
      $('.timeline-card').removeClass('active');
      $thisCard.removeClass('active').removeAttr('aria-live','assertive');
      if($thisCard.hasClass('flight-info')) {
        $($thisCard).find('.timeline-card__close').hide();
      }
      console.log($thisTimelineCard);

      if(window.matchMedia('(max-width: 991px)').matches) {

        $('.timeline__filter-scroll').show();
      }

      return false;
    });
    //keypress('.timeline-card__close');
    $('.timeline-card__close').keypress(function (e) {
      let key = e.which;
      if(key == 13 && $(this).parents('.flight-info').length )  // the enter key code
      {
        let $thisCard =  $(this).closest('.timeline-card__content'),
          $cardID = $thisCard.attr('id'),
          $thisTimelineCard = $('.timeline-card[data-id="'+$cardID+'"]');
        $('.timeline__legend__flights').find('.active').focus();
        $thisTimelineCard.removeClass('active');
        $('.timeline-card').removeClass('active');
        $thisCard.removeClass('active').removeAttr('aria-live','assertive');
        $($thisCard).find('.timeline-card__close').hide();
        if(window.matchMedia('(max-width: 991px)').matches) {

          $('.timeline__filter-scroll').show();
        }
        return false;
      }
    });
    /**
     * Mouseup
     */
    $(document).mouseup(function (e) {
      let container = $('.timeline__flight-info__wrapper, .timeline-card__content-wrapper'),
        content = $('.timeline-card__content.active');
      //dropdownButton = $('.dropdown-button.active');

      if (container.has(e.target).length === 0)  {
        content.removeAttr('aria-live','assertive');
        $(content).find('.timeline-card__close').hide();
        content.removeClass('active');
        $('.timeline-card').removeClass('active');
        hideModalsFocusable ();
      }

    });



    /**
     * Open timeline legend  card
     */
    $(document).on('click', '.timeline__legend__flights-item', function(){
      showModalsFocusable ();
      let $thisCard =  $(this),
        $target = '#' + $thisCard.data('id');
      $('.timeline-card.clickable').each(function(){
        $(this).removeClass('active');
      })
      $thisCard.addClass('active');


      //console.log($target);
      $($target).find('.timeline-card__close').hide(0).delay(300).show(0);
      $('.timeline-card__content').removeClass('active');
      $($target).addClass('active');
      $($target).focus().attr('aria-live','assertive');
      $($target).find('.timeline-card__close').addClass('sticky')
     // $($target).find('.timeline-card__close').show(0).delay(2000).hide(0)
      //setTimeout( $($target).find('.timeline-card__close').show(), 15000);




      if(window.matchMedia('(max-width: 991px)').matches) {
        $('.timeline__filter-scroll').hide();
      }
      /**
       * Swiper Timeline Cards Slider
       */
      if ($('.card-slider').length > 0) {
        new Swiper('.card-slider  .swiper-container', {
          loop: true,
          slidesPerView: '1',
          grabCursor : true,
          speed           : 500,
          centeredSlides  : true,
          freeMode: false,
          initialSlide    : '0',
          pagination: {
            el: '.card-slider  .swiper-pagination',
            type: 'bullets',
            clickable: true,
            renderBullet: function () {
              return '<span class="dot swiper-pagination-bullet"></span>';
            },
          },

        });
      }
      $('[data-fancybox]').fancybox({
        btnTpl: {
          close:
            '<button data-fancybox-close class="test  fancybox-button fancybox-button--close" title="{{CLOSE}}">' +
            '<div><svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
            '<path fill-rule="evenodd" clip-rule="evenodd" d="M10.7037 8.39342L1.9892 0.422852L0.442993 1.83707L9.15748 9.80763L0.442996 17.7782L1.9892 19.1924L10.7037 11.2218L18.9975 18.8076L20.5437 17.3934L12.2499 9.80763L20.5437 2.22184L18.9975 0.807628L10.7037 8.39342Z" fill="#233746"/>\n' +
            '</svg></div>' +
            '</button>',
          arrowLeft:
            '<button data-fancybox-prev class="fancybox-button fancybox-button--arrow_left" title="{{PREV}}">' +
            '<div><svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
            '<path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 0.567871L8.5725 1.61262L2.8875 7.31787H18V8.81787H2.8875L8.5725 14.4976L7.5 15.5679L0 8.06787L7.5 0.567871Z" fill="#233746"/>\n' +
            '</svg></div>' +
            '</button>',

          arrowRight:
            '<button data-fancybox-next class="fancybox-button fancybox-button--arrow_right" title="{{NEXT}}">' +
            '<div><svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
            '<path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 0.567871L9.4275 1.61262L15.1125 7.31787H0V8.81787H15.1125L9.4275 14.4976L10.5 15.5679L18 8.06787L10.5 0.567871Z" fill="#233746"/>\n' +
            '</svg></div>' +
            '</button>',
        },
      })


      return false;
    });
    keypress('.timeline__legend__flights-item');
    $(document).ready(function (){

      trapFocus('#fl-77');
      trapFocus('#fl-175');
      trapFocus('#fl-11');
      trapFocus('#fl-93');


    })
    /**
     * Sticky Timeline Legend on Mobile
     */

    window.onscroll = function(){
      if(window.matchMedia('(max-width: 767px)').matches) {

        let $element = document.getElementById('legend'),
          el = $element,
          element_position = $('.timeline__container__center').offset().top,
          y_scroll_pos = window.pageYOffset,
          legendPosition,
          scroll_pos_native = element_position + 330,
          scroll_pos_top = element_position,
          legendBox = $('.legend-box.has-notification '),
          notificationHeight = $('.header__notification').height();
          if(legendBox.length > 0) {
            legendBox.css('top',notificationHeight + 65)
          } else {
            legendBox.css('')
          }
          console.log(legendBox.length);

        if(y_scroll_pos > scroll_pos_native ) {
          legendPosition = 'native';
        }
        if (y_scroll_pos < scroll_pos_top  /*&& blockPositonSticky > 0*/) {
           legendPosition = 'top';
        }
        //console.log(y_scroll_pos + ':' + scroll_pos_test )
        switch (legendPosition) {
          case 'native' :
            $('.legend-box').append(el);
            $('.legend-box').addClass('active');
            break;
          case 'top':
            $('.timeline__container__center').append(el);
            $('.legend-box').removeClass('active');
            break;
        }

      }
    }
    /**
     * Timeline Container Scroll Buttons
     */

    let button = document.getElementById('timelineNext');
    button.onclick = function () {
      let container = document.getElementById('timelineContainer');
      sideScroll(container,'right',50,400,160);
      $('.swiper-button-prev').removeClass('disabled');
    };

    let back = document.getElementById('timelinePrev');

    back.onclick = function () {
      let container = document.getElementById('timelineContainer');

      sideScroll(container,'left',50,400,160);
    };

    function sideScroll(element,direction,speed,distance,step){
      let maxWidth = $('.timeline__container__right ').width();
      let scrollAmount = 0;
      let slideTimer = setInterval(function(){
        if(direction == 'left' ) {
          element.scrollLeft -= step;
          $('#timelineNext').removeClass('disabled');
          console.log(element.scrollLeft)
          if(element.scrollLeft === 0) {
            $('#timelinePrev').addClass('disabled');
          }
        }
        if (direction == 'right' ){
         // console.log(maxWidth)
         // console.log(element.scrollLeft)
          if (element.scrollLeft < maxWidth) {
            element.scrollLeft += step;

          }
         /* else {
            $('#timelineNext').addClass('disabled');
          }*/
         // console.log(element.scrollLeft)
          //console.log(maxWidth-900)
        }
        scrollAmount += step;
        if(scrollAmount >= distance){
          window.clearInterval(slideTimer);

        }
      }, speed);
    }
    keypress('#timelineNext')
    keypress('#timelinePrev')

    /**
     * Timeline Container Scroll Drag & Drop
     */
    const container = document.querySelector('#timelineContainer');

    let startY;
    let startX;
    let scrollLeft;
    let scrollTop;
    let isDown;

    container.addEventListener('mousedown',e => mouseIsDown(e));
    container.addEventListener('mouseup',e => mouseUp(e))
    container.addEventListener('mouseleave',e=>mouseLeave(e));
    container.addEventListener('mousemove',e=>mouseMove(e));

    function mouseIsDown(e){
      isDown = true;
      startY = e.pageY - container.offsetTop;
      startX = e.pageX - container.offsetLeft;
      scrollLeft = container.scrollLeft;
      scrollTop = container.scrollTop;
      container.style.cursor = 'grabbing';
    }
    function mouseUp(){
      isDown = false;
      container.style.cursor = 'grab';
    }
    function mouseLeave(){
      isDown = false;
    }
    function mouseMove(e){
      if(isDown){
        e.preventDefault();
        //Move vertcally
        const y = e.pageY - container.offsetTop;
        const walkY = y - startY;
        container.scrollTop = scrollTop - walkY;

        //Move Horizontally
        const x = e.pageX - container.offsetLeft;
        const walkX = x - startX;
        if(container.scrollLeft === 0) {
          $('#timelinePrev').addClass('disabled');
        }
        container.scrollLeft = scrollLeft - walkX;

      }
    }
    const  modalFocusableElements =
      'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"],.timeline__legend__flights-item,.timeline-card__close)';
    function hideModalsFocusable () {
      $('#timeline_modals').find(modalFocusableElements).hide();

    }
    function showModalsFocusable () {
      $('#timeline_modals').find(modalFocusableElements).show();

    }
    hideModalsFocusable ();

    $(document).ready(function () {

    })





  },
};
