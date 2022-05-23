import Swiper from 'swiper/bundle';

export default {
  init() {

  },
  finalize() {
    function isMobile() { return ('ontouchstart' in document.documentElement); }
    function setCookie(name,value,days) {
      let expires = '';
      if (days) {
        let date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = '; expires=' + date.toUTCString();
      }
      document.cookie = name + '=' + (value || '')  + expires + '; path=/';
    }
    function getCookie(name) {
      var nameEQ = name + '=';
      var ca = document.cookie.split(';');
      for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
      }
      //return null;
    }
    $(document).ready(function () {
      console.log(getCookie('notificationRead'))
      if(!getCookie('notificationRead')){
        //setCookie('notificationRead','true','7');
        //alert (getCookie('notificationRead'))
        $('body, header,.legend-box').addClass('has-notification');

      }
    })


    function formInputKeyPress($selector) {
      $($selector).parent().keypress(function (e) {
        let key = e.which;
        if(key == 13 )  // the enter key code
        {
          $(this).click();

          return false;
        }
      });
    }
    formInputKeyPress('input[type="checkbox"]:not(".timeline-filter-input"), input[type="radio"]');



    /**
     * Add tabindex to input labels
     */
    $('input[type="radio"], input[type="checkbox"]').parent().not('li').attr('tabindex', 0);
    $('.form-radio').removeAttr('tabindex');

    /**
     * focus on logo
     */
    //$('#brand').focus();


    /**
     * Trap focus in modals
     * @param $modal
     */

    function trapFocus($modal) {

// add all the elements inside modal which you want to make focusable
      const  focusableElements =
        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])';
      const modal = document.querySelector($modal); // select the modal by it's id

      //const firstFocusableElement = modal.querySelectorAll(focusableElements)[0]; // get first element to be focused inside modal
      const firstFocusableElement = $('.header__btngroup__menu');
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
      });

      //firstFocusableElement.focus();
    }
    $(document).ready(function (){

        trapFocus('#headerModal');


    })




    /**
     * Header
     * @type {{init: init}}
     */
    let Header = function () {

      /**
       * Install
       * @param data
       * @constructor
       */
      let Install = function () {

        $.extend($.expr[':'], {
          'off-top': function(el) { // проверка того, что элемент достиг верха экрана
            return $(el).offset().top < $(window).scrollTop();
          },
          'off-top-height': function(el) { // проверка того, что весь элемент ушел за верхний край экрана
            return ($(el).offset().top+$(el).outerHeight()) < $(window).scrollTop();
          },
          'off-right': function(el) { // проверка того, что элемент ушел за правый край
            return $(el).offset().left + $(el).outerWidth() - $(window).scrollLeft() > $(window).width();
          },
          'off-bottom': function(el) { // проверка того, что элемент ушел за нижний край
            return $(el).offset().top + $(el).outerHeight() - $(window).scrollTop() > $(window).height();
          },
          'off-left': function(el) { // проверка того, что элемент ушел за левый край
            return $(el).offset().left < $(window).scrollLeft();
          },
          'off-screen': function(el) { // элемент вышел из области видимости экран
            return $(el).is(':off-top, :off-right, :off-bottom, :off-left');
          },
        });


        /**
         *
         */

        $(document).ready(function (){
          if(isMobile() == true) {
            $('body').addClass('is-mobile');

          }else{
            $('.mobile-search-form').hide();
          }
          if( $('.home-intro').length || $('.timeline').length ) {
            if($('.is-mobile').length === 0) {

              $('#wrapper').scroll(function () {

                if ($('#wrapper').scrollTop() > 30) {
                  $('header').addClass('dark');
                } else {
                  $('header').removeClass('dark');
                }
              });
            } else {
              $(window).scroll(function () {
                //alert('test')
                if( $(window).scrollTop() > 30 ) {
                  $('header').addClass('dark');
                }else{
                  $('header').removeClass('dark');
                }
              })
            }

          }
        })








      }

      /**
       * Menu
       * @param data
       * @constructor
       */
      let Menu = function () {

        /**
         * @click
         */
        let classes_header = null;

        $(document).on('click', '.header__btngroup__menu', function(e){
          e.preventDefault()

          const $header = $('header'),
                $modal  = $('.header__modal');
                if($modal.attr('aria-hidden') === 'true') {
                  $modal.attr('aria-hidden','false');

                } else {
                  $modal.attr('aria-hidden','true');
                }
                console.log($modal.attr('aria-hidden'))
               // $modalHeight = $('.header__modal__inner').height(),
                //$windowHeight = $modal.height();


          if( $modal.height() > 0 ) {

            /**
             * If Hidden Modal
             */
            $header.addClass(classes_header)
            classes_header = null

          }else{

            if( $header.hasClass( 'dark' ) ) {
              classes_header = 'dark'
              $header.removeClass('dark')

            }

            if( $header.hasClass( 'default' ) ) {
              classes_header = 'default'
              $header.removeClass('default')

            }

          }


          /**
           * Check if scrollbar
           */
          $.fn.hasScrollBar = function() {
            return this.get(0).scrollHeight > this.height();
          }
          if($modal.hasScrollBar() === true) {
            $header.addClass('has-scroll');
          } else {
            $header.removeClass('has-scroll');
          }
          if( $('body').hasClass('menu-active') ) {

            $('body').removeClass('menu-active');
            setTimeout(function (){
              $('body').removeClass('menu-active-header')
            }, 130)

          } else {

            $('body').addClass('menu-active')
            $('body').addClass('menu-active-header')

          }



        });

      }

      /**
       * MenuAccordion
       * @param data
       * @constructor
       */
      let MenuAccordion = function () {

        /**
         * @click
         */
        $(document).on('click', '.header__modal__menu > li > a', function(e){
          e.preventDefault()

          const $li = $(this).parent();

          if( $li.hasClass('active') ) {

            $li.removeClass('active')

          }else{

            $('.header__modal__menu').find('li.active').removeClass('active');

            $(this).parent().toggleClass('active')
          }

        });

      }

      /**
       * @return
       */
      return {
        init: function () {
          Install();
          Menu();
          MenuAccordion();
        },
      };
    }();

    /**
     * Init Header
     */
    Header.init();


    /**
     * Dropdown
     * @type {{init: init}}
     */
    let Dropdown = function () {

      /**
       * Install
       * @param data
       * @constructor
       */
      let Install = function () {

        /**
         * Click
         */
        $(document).on('click', '.dropdown-button', function(e){
          $(this).toggleClass('active')
          $(this).parent().toggleClass('active')
          e.preventDefault()

          //$(this).toggleClass('active')

        });

        /**
         * Mouseup
         */
        $(document).mouseup(function (e) {
          var container = $('.dropdown.active'),
              dropdownButton = $('.dropdown-button.active');

          if (container.has(e.target).length === 0)  {
            container.removeClass('active');
          }
          if (dropdownButton.has(e.target).length === 0 && !dropdownButton.parent().hasClass('active')) {
            dropdownButton.removeClass('active');
          }
        });

      }


      /**
       * @return
       */
      return {
        init: function () {
          Install();
        },
      };
    }();

    /**
     * Init Dropdown
     */
    Dropdown.init();




    /**
     * Replace SVG
     */
    jQuery('img.svg').each(function(){
      var $img = jQuery(this);
      var imgID = $img.attr('id');
      var imgClass = $img.attr('class');
      var imgURL = $img.attr('src');

      jQuery.get(imgURL, function(data) {
        // Get the SVG tag, ignore the rest
        var $svg = jQuery(data).find('svg');

        // Add replaced image ID to the new SVG
        if(typeof imgID !== 'undefined') {
          $svg = $svg.attr('id', imgID);
        }
        // Add replaced image classes to the new SVG
        if(typeof imgClass !== 'undefined') {
          $svg = $svg.attr('class', imgClass+' replaced-svg');
        }

        // Remove any invalid XML tags as per http://validator.w3.org
        $svg = $svg.removeAttr('xmlns:a');

        // Check if the viewport is set, if the viewport is not set the SVG wont't scale.
        if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
          $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
        }

        // Replace image with new SVG
        $img.replaceWith($svg);

      }, 'xml');

    });


    /**
     * Swiper: Follow Us
     */
    if ($('.swiperFollowUs').length > 0) {

      /**
       * Offset Slider Before
       * @type {number}
       */
        // eslint-disable-next-line no-unused-vars
      let follow_offset_before  = 44;
        //$container_follow     = $('#swiperFollowContainer');


      /**
       * Load and Resize
       * @resize
       * @load
       */
      $(window).on('resize load', function () {

        /*var W_WIDTH_F = $(window).width();*/
        /**
         * Get Offset Before Container
         * @type {number}
         */
        /*if( W_WIDTH_F > 767 ) {
          follow_offset_before = parseInt($container_follow.css('padding-left'));
        }*/

        // eslint-disable-next-line no-unused-vars
        let SwiperFollow = new Swiper('.swiperFollowUs .swiper-container', {
          slidesPerView   : '5',
          spaceBetween    : 16,
          //loop            : true,
          loopFillGroupWithBlank: true,
          //loopedSlides: 10,
          speed           : 500,
          centeredSlides  : true,
          initialSlide    : 1,
          slidesOffsetBefore: follow_offset_before,
          pagination      : {
            el            : '.swiperFollowUs .swiper-pagination',
            clickable     : true,
          },
          navigation: {
            nextEl        : '.swiperFollowUs .swiper-button-next',
            prevEl        : '.swiperFollowUs .swiper-button-prev',
          },
          breakpoints: {
            320: {
              slidesPerView: 'auto',
              centeredSlides  : false,
              initialSlide: 0,
            },
            768: {
              slidesPerView: 3,
            },
            1024: {
              centeredSlides: false,
              initialSlide: 0,
              slidesPerView   : '5',
            },
          },
        });
        /*if( W_WIDTH_F > 767 ) {
          SwiperFollow.params.slidesOffsetBefore = follow_offset_before;
        }*/


      });



    }

    /**
     * Swiper: Heroes
     */
    if ($('.swiperHeroes').length > 0) {


      /**
       * Offset Slider Before
       * @type {number}
       */
        // eslint-disable-next-line no-unused-vars
      let heroes_offset_before  = 44,
        $container_heroes     = $('#swiperHeroesContainer');

      /**
       * Load and Resize
       * @resize
       * @load
       */
      $(window).on('resize load', function () {

        var W_WIDTH = $(window).width();
        /**
         * Get Offset Before Container
         * @type {number}
         */
        if( W_WIDTH > 767 ) {
          heroes_offset_before = parseInt($container_heroes.css('padding-left'));
        }

        // eslint-disable-next-line no-unused-vars
        let SwiperHeroes = new Swiper('.swiperHeroes .swiper-container', {
          slidesPerView   : 'auto',
          spaceBetween    : 16,
          loop            : false,
          speed           : 500,
          slidesPerGroup  : 1,
          pagination      : {
            el            : '.swiperHeroes .swiper-pagination',
            clickable     : true,
          },
          navigation: {
            nextEl        : '.swiperHeroes .swiper-button-next',
            prevEl        : '.swiperHeroes .swiper-button-prev',
          },
          keyboard: {
            enabled: true,
            onlyInViewport: false,
          },
          slidesOffsetBefore: heroes_offset_before,
          slidesOffsetAfter: 44,
        });

        if( W_WIDTH > 767 ) {
          SwiperHeroes.params.slidesOffsetBefore = heroes_offset_before;
        }
      });


    }


    /**
     * Scroll Top
     */
    $(document).on('click', '.scroll__top', function(){
      $('html, body, #wrapper').animate({scrollTop: 0},500);
      return false;
    });





    /**
     *  Search form
     */

    /**
     * Mouseup
     */


    $(document).on('click', '#search-toggler:not(".open")', function(){
      $('#search-toggler').toggleClass('open');
      $('.header__searchbox').slideDown();
      $('.header__searchbox').find('input.form-control').focus();
      return false;
    });
    $(document).on('click', '#search-toggler.open', function(){
      $('#search-toggler').toggleClass('open');
      $('.header__searchbox').slideUp();
      $('.header__searchbox').find('input.form-control').focus();
      return false;
    });

      $(document).mouseup(function (e) {
        if(e.target.id !== 'search-toggler') {
          console.log('EMPTY SPACE' + e.target.id)
          let container = $('.header__searchbox');
          if (container.has(e.target).length === 0 ) {
            $('.header__searchbox').slideUp();
            $('#search-toggler').removeClass('open');
            e.preventDefault()
          }
        }else {
          console.log('THIS IS TOGGLER' + e.target.id)
        }



        console.log(e.target.id)
      });


    /**
     *  Donate form Open
     *

    $(document).on('click', '.header__btngroup__donate, .header__modal__donate__button', function(){
      $('.modal-donate').addClass('active');

      return false;
    });
    /**
     * Donate form close
     *
    $(document).on('click', '.modal-donate__close', function(){
      $('.modal-donate').removeClass('active');

      return false;
    });
    /**
     * Mouseup
     *
    $(document).mouseup(function (e) {
      var container = $('.modal-donate__body');
        //dropdownButton = $('.dropdown-button.active');

      if (container.has(e.target).length === 0)  {
        $('.modal-donate').removeClass('active');
      }

    });

    /**
     *  Notification Bar
     */
    //-- set cookie
  /*  function setCookie(name, value, options = {}) {

      options = {
        path: '/',

      };

      if (options.expires instanceof Date) {
        options.expires = options.expires.toUTCString();
      }

      let updatedCookie = encodeURIComponent(name) + '=' + encodeURIComponent(value);

      for (let optionKey in options) {
        updatedCookie += ';'  + optionKey;
        let optionValue = options[optionKey];
        if (optionValue !== true) {
          updatedCookie += '=' + optionValue;
        }
      }

      document.cookie = updatedCookie;
    }
    */

    $(document).on('click', '.header__notification__close', function(){
      $('.header__notification').slideUp();
      $('body, .header, .legend-box').removeClass('has-notification');
      $('.legend-box').css('top',65);
      if($('body.home').length == 0) {
        $('.header').css('height', 65);
      } else {
        $('.home-intro__text').css('padding-top', 185);
        if($('.intro-default__text').length >0) {
          $('.intro-default__text').css ('padding-top','')
        }

      }
      if($('.intro-biography').length > 0 && $('body.is-mobile').length == 0) {
        $('.intro-biography').css('padding-top', 80)
      }
      //$('.header__modal__inner').css('padding-top','')
      //setCookie('notificationRead', true, {'max-age': 3.154e+7});
      setCookie('notificationRead','true','7');
      return false;
    });

    /**
     * Accordion section
     */

      $(document).on('click', '.accordion__item > a', function(e){
        e.preventDefault()

        const $li = $(this).parent();

        if( $li.hasClass('active') ) {

          $li.removeClass('active')

        }else{

          $('.accordion__wrapper').find('li.active').removeClass('active');

          $(this).parent().toggleClass('active')
        }

      });

    /**
     * Scroll to first invalid field
     * WPCF7 on validation error event
     */
    document.addEventListener( 'wpcf7invalid', function() {
      setTimeout( function() {
        $('html').stop().animate({
          scrollTop: $('.wpcf7-not-valid').eq(0).offset().top - 140,
        }, 500, 'swing');
      }, 100);
    }, false );




    /**
     * Custom select
     */
    // Iterate over each select element
    $('.wpcf7-select').each(function () {

      // Cache the number of options
      let $this = $(this),
        numberOfOptions = $(this).children('option').length;

      // Hides the select element
      $this.addClass('s-hidden');

      // Wrap the select element in a div
      $this.wrap('<div class="select" tabindex="0"></div>');

      // Insert a styled div to sit over the top of the hidden select element
      $this.after('<div class="styledSelect"></div>');

      // Cache the styled div
      let $styledSelect = $this.next('div.styledSelect');

      // Show the first select option in the styled div
      $styledSelect.text($this.children('option').eq(0).text());

      // Insert an unordered list after the styled div and also cache the list
      let $list = $('<ul />', {
        'class': 'options',
      }).insertAfter($styledSelect);

      // Insert a list item into the unordered list for each select option
      for (let i = 0; i < numberOfOptions; i++) {
        $('<li />', {
          text: $this.children('option').eq(i).text(),
          rel: $this.children('option').eq(i).val(),
        }).appendTo($list);
      }

      // Cache the list items
      let $listItems = $list.children('li');
      $listItems.attr('tabindex',0);

      // Show the unordered list when the styled div is clicked (also hides it if the div is clicked again)
      $styledSelect.click(function (e) {
        e.stopPropagation();
        /*$('div.styledSelect.active').each(function () {
          $(this).removeClass('active').next('ul.options').hide();
          //alert('test2')
        });*/
        $(this).toggleClass('active').next('ul.options').toggle();

        //alert('test')
      });
      $('.select').keyup(function(e){
        if(e.keyCode==13) {
          e.stopPropagation();
          $styledSelect.toggleClass('active').next('ul.options').toggle();
          console.log('Click2')
        }
      });


      // Hides the unordered list when a list item is clicked and updates the styled div to show the selected list item
      // Updates the select element to have the value of the equivalent option
      $listItems.click(function (e) {
        e.stopPropagation();
        $list.children('li').removeClass('active');
        $(this).toggleClass('active');
        $styledSelect.text($(this).text()).removeClass('active');
        $this.val($(this).attr('rel'));
        $list.hide();
        //alert($this.val());
      });
      $listItems.keyup(function(e){
        if(e.keyCode==13) {
          e.stopPropagation();
          $list.children('li').removeClass('active');
          $(this).toggleClass('active');
          $styledSelect.text($(this).text()).removeClass('active');
          $this.val($(this).attr('rel'));
          $list.hide();
        }
      });


      /**
       * Mouseup for selet input
       */
      $(document).mouseup(function (e) {
        var container = $('.select');
        //dropdownButton = $('.dropdown-button.active');

        if (container.has(e.target).length === 0)  {
          $styledSelect.removeClass('active');
          $list.hide();
        }

      });


    });

    /**
     * Custom ScrollBar
     */
// Problems exist with iframes
    let window_h;
    let scroll_ratio;
    let $scrollbar = $('#scrollbar');
    let $scrollable = $('#wrapper');
    let $scroll_buffer = 1;
    let dragging = null;

// update size and position of scrollbar
    function update_scroll(scroll_content) {
      scroll_content = typeof scroll_content !== 'undefined' ? scroll_content : true;

      // determine scrollbar size
      window_h = $(window).height();
      scroll_ratio = window_h / $scrollable.get(0).scrollHeight;
      if (scroll_ratio >= 1) {
        // no scrolling necessary
        $scrollbar.css('height', 0);
        return;
      }
      let size = window_h * scroll_ratio;
      $scrollbar.css('height', size);

      // determine scrollbar position
      // move content
      scroll_ratio = (window_h - $scrollbar.height() - 2 * $scroll_buffer) / ($scrollable.get(0).scrollHeight - $scrollable.height());
      if (scroll_content) {
        $scrollable.scrollTop( ($scrollbar.offset().top - $scroll_buffer) / scroll_ratio );
      } else {
        $scrollbar.offset({ top:($scrollable.scrollTop() * scroll_ratio) + $scroll_buffer });
      }
    }

    $(document).ready(function() {
      if($('.is-mobile').length === 0){
        $scrollbar = $('#scrollbar');
        $scrollable = $('#wrapper');
        $scroll_buffer = 1;
        dragging = null;
        update_scroll(false);
        $scrollbar.css('right', $scroll_buffer);
        $scrollable.on('scroll', function() {
          update_scroll(false);
        });
      }


    });

    $(window).on('resize', function() {
      if($('.is-mobile').length === 0) {
        update_scroll(false);
      }
    });

    function limit(y, el_h) {
      return Math.max($scroll_buffer, Math.min(y, window_h - el_h - $scroll_buffer));
    }

    $scrollbar.on('mousedown', function(e) {
      if($('.is-mobile').length === 0) {
        dragging = {
          z_idx: $scrollbar.css('z-index'),
          drg_h: $scrollbar.outerHeight(),
          pos_y: e.clientY - $scrollbar.offset().top,
        };
        $scrollbar.css('z-index', 1000);
        $scrollbar.addClass('active-scroll');
        if (e.target.setCapture) e.target.setCapture();
        e.preventDefault(); // disable selection
      }
    });

    $scrollbar.on('losecapture', function() {
      if($('.is-mobile').length === 0) {
        dragging = null;
      }
    });

    document.addEventListener('mouseup', function() {
      if($('.is-mobile').length === 0){
        if (!dragging) return;
        $scrollbar.css('z-index', dragging.z_idx);
        $scrollbar.removeClass('active-scroll');
        dragging = null;
      }


    }, true);


    let dragTarget = $scrollbar.get(0).setCapture ? $scrollbar.get(0) : document; // setCapture fix
    if($('.is-mobile').length === 0) {
      dragTarget.addEventListener('mousemove', function (e) {
        if (!dragging) return;

        $scrollbar.offset({
          top: limit(e.clientY - dragging.pos_y, dragging.drg_h),
        });
        update_scroll();
      }, true);
    }

    $(document).on('mouseover', function(e) { // setCapture fix
      if($('.is-mobile').length === 0) {
        if (e.which != 1) dragging = null;
      }
    });
    /**
     * Notification Fix Header Height
     */

    function notificationFix () {
        let barHeight = $('.header__notification').outerHeight(true);
        let header = $('.header');
        if(header.hasClass('has-notification')){
          //let modal = $('.has-notification .header__modal__inner');
          if($('body.home').length == 0) {
            header.css('height',Number(barHeight + 65));
            if($('.intro-default__text').length > 0 && $('body.is-mobile').length == 0) {
              $('.intro-default__text').css ('padding-top',Number(barHeight + 96))
            }
            if($('.intro-biography').length > 0 && $('body.is-mobile').length == 0) {
              $('.intro-biography').css('padding-top',Number(barHeight + 80))
            }
          } else {
            $('.home-intro__text').css('padding-top',Number(barHeight + 185))
          }
          //modal.css('padding-top',barHeight + 150)



          console.log($('.intro-default__text').length)
        }

    }
    $(window).load(function (){
      notificationFix()


    })


  },

};



