import Swiper from 'swiper/bundle';
import '@fancyapps/fancybox/dist/jquery.fancybox';
import { Viewer } from 'photo-sphere-viewer';

let viewerPane;
if( $('#viewer').length ) {
  // eslint-disable-next-line no-unused-vars
  viewerPane = new Viewer({
    container: document.querySelector('#viewer'),
    navbar: false,
    defaultZoomLvl: 0,
    //autorotateDelay: 1,
    autorotateSpeed: '1rpm',
    //captureCursor: true,
  });
}
export default {
  init() {


  },
  finalize() {

    /**
     * Filters Panel Checkbox All
     * @change
     */
    $(document).on('change', '.map__filters__form__checkbox__all', function () {

      if (this.checked) {
        $('#filter-marker-red').prop('checked', false);
        $('#filter-marker-blue').prop('checked', false);
        $('#filter-marker-info').prop('checked', false);

        $('.leaflet-marker-icon').each(function () {
          var $icon = $(this).find('div');
          $icon.removeClass('show');
          $icon.removeClass('hidden');
          $(this).removeClass('hidden');
        });
      } else {
        $(this).prop('checked', true)
      }

    });

    /**
     * Filters Panel Checkbox Check
     * @change
     */
    $(document).on('change', '.map__filters__form__checkbox__check', function () {

      var check_type = $(this).data('type');

      if (this.checked) {
        $('#filter-all').prop('checked', false);

        /**
         *
         */
        $('.map__filters__form__checkbox__check').each(function () {
          var $this = $(this);

          if ( $this.prop('checked') ) {
            var type = $this.data('type');

            $('.leaflet-marker-icon').each(function () {

              var $this = $(this),
                  $icon = $this.find('div');

              // eslint-disable-next-line no-empty
              if ( $icon.hasClass('show') ) {

              } else {
                if ($icon.hasClass('map__point-' + type + '-marker')) {
                  $icon.removeClass('hidden');
                  $icon.addClass('show');
                  $this.removeClass('hidden');
                } else {
                  $icon.addClass('hidden');
                  $this.addClass('hidden');
                }
              }

            });
          }

        });
      } else {
        $('.leaflet-marker-icon').each(function () {
          var $this = $(this),
              $icon = $this.find('div');

          if ( $icon.data('type') === check_type ) {
            $icon.addClass('hidden');
            $icon.removeClass('show');

            $this.addClass('hidden');
          }

        });
      }

      var active = 0;
      $('.map__filters__form__checkbox__check').each(function () {
        if ( $(this).prop('checked') ) {
          active += 1;
        }
      });

      if ( active === 3 || active === 0 ) {
        $('#filter-all').prop('checked', true);
        $('#filter-all').trigger('change');

        $('.map__filters__form__checkbox__check').prop('checked', false)
      }

    });

    /**
     * Open Filter Mobile
     * @click
     */
    $(document).on('click', '.map__filters__button', function (e) {

      $('body').toggleClass('filter-active');

      e.preventDefault();


    });

    /**
     * Pano Open
     * Click
     */
    $(document).on('click', '.fancyPano', function (e) {

      /**
       * Fancybox
       */
      $.fancybox.open({
        src  : '#viewerHtml',
        opts : {
          infobar : false,
          loop: true,
          buttons: [
            'close',
          ],
          thumbs : {
            autoStart   : false,
            hideOnClose : true,
          },
          touch: false,
          // eslint-disable-next-line no-unused-vars
          afterShow : function ( instance ) {

            var $pano = $('.fancyPano'),
              // eslint-disable-next-line no-unused-vars
              image = $pano.attr('href');

            if( $('#viewer').length ) {
              // eslint-disable-next-line no-unused-vars
              viewerPane.setPanorama(image)
                .then(() => {
                  viewerPane.toggleAutorotate();
                });
            }


          },
          btnTpl: {
            close: '<button data-fancybox-close class="test fancybox-button fancybox-button--closes" title="{{CLOSE}}"><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 1.05L10.95 0L6 4.95L1.05 0L0 1.05L4.95 6L0 10.95L1.05 12L6 7.05L10.95 12L12 10.95L7.05 6L12 1.05Z" fill="#233746"/></svg></button>',
            arrowLeft: '<button data-fancybox-prev class="fancybox-button fancybox-button--arrow_left" title="{{PREV}}">' +
              '<div><svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 0.5L8.5725 1.54475L2.8875 7.25H18V8.75H2.8875L8.5725 14.4298L7.5 15.5L0 8L7.5 0.5Z" fill="#233746"/></svg></div>' +
              '</button>',

            arrowRight: '<button data-fancybox-next class="fancybox-button fancybox-button--arrow_right" title="{{NEXT}}">' +
              '<div><svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 0.5L9.4275 1.54475L15.1125 7.25H0V8.75H15.1125L9.4275 14.4298L10.5 15.5L18 8L10.5 0.5Z" fill="#233746"/></svg></div>' +
              '</button>',
          },
          baseTpl:
            '<div class="fancybox-container fancybox-pano" role="dialog" tabindex="-1">' +
            '<div class="fancybox-bg"></div>' +
            '<div class="fancybox-inner">' +
            '<div class="fancybox-stage"></div>' +
            '<div class="fancybox-caption"><div class=""fancybox-caption__body"></div></div>' +
            '</div>' +
            '</div>',
        },
      });

      e.preventDefault();

    });

    /**
     * Play Video
     * @click
     */
    $(document).on('click', '.mapVideoPreview', function (e) {

      const $this     = $(this),
            $iframe   = $this.parent().parent().find('iframe');

      $iframe[0].src += '&autoplay=1';

      $this.remove();

      e.preventDefault();

    });

    /**
     * Global Category
     * @type {null}
     */
      // eslint-disable-next-line no-unused-vars
    let active_click_marker = null;
    /**
     * Init
     * @param mapid
     */
    function init(mapid)
    {

      var minZoom = 2,
        maxZoom = 4,
        // eslint-disable-next-line no-undef
        img     = map_size;

      /**
       * Create the map
       */
        // eslint-disable-next-line no-undef
      var map = L.map(mapid, {
          minZoom : minZoom,
          maxZoom : maxZoom,
          zoomControl: false,
          // zoomSnap: 0,
          // zoomDelta: 0.5,
          // zoomAnimation: false,
          maxBoundsViscosity: 1,
        })

      // assign map and image dimensions
      // eslint-disable-next-line no-undef
      var rc = new L.RasterCoords(map, img)

      // set the view on a marker ...
      map.setView(rc.unproject([0, 0]), 3);
      // eslint-disable-next-line no-undef
      //map.panBy(new L.Point (img[0] / 2, img[1] / 2), {animate: false});


      //const clustered = L.markerClusterGroup({
      // eslint-disable-next-line no-undef
      // const clustered = L.markerGroup({
      // maxClusterRadius: 18,
      // spiderfyOnMaxZoom: true,
      // showCoverageOnHover: false,
      // zoomToBoundsOnClick: true,
      // animateAddingMarkers: true,
      // spiderfyDistanceMultiplier: 1,
      // removeOutsideVisibleBounds: true,
      // disableClusteringAtZoom: 4,
      //});
      //map.addLayer(clustered);

      /**
       * add layer control object
       */
      // eslint-disable-next-line no-undef
      L.control.layers({}, {
        'Bounds': layerBounds(map, rc),
        // 'Info': layerGeo(map, rc),
      }).addTo(map);

      // eslint-disable-next-line no-undef
      L.control.zoom({
        position: 'bottomright',
      }).addTo(map);

      /**
       * the tile layer containing the image generated
       */
      // eslint-disable-next-line no-undef
      L.tileLayer(map_url_tiles+'/{z}/{x}/{y}.png', {
        noWrap      : true,
        attribution : '',
      }).addTo(map);

      //TODO This Hardcode

      // eslint-disable-next-line no-undef
      map.panTo(new L.LatLng(70.377854, 21.884766));

      /**
       * ResizeMap
       */
      map.invalidateSize();

      /**
       * Center Map of Markers Group
       * @type {*[]}
       */
      // var grouped_markers = [];
      // map.eachLayer(function (layer) {
      //
      //   if( undefined != layer._latlng ) {
      //     grouped_markers.push([layer._latlng.lat, layer._latlng.lng]);
      //   }
      //
      // });
      // map.fitBounds([grouped_markers]);
      // var zoom_map = map.getZoom();
      // map.setZoom(zoom_map < 3 ? 3 : zoom_map);

      /**
       * Next Post
       * @tourNextItem
       */
      $(document).on('click', '.map__modal__nav__next', function (e) {

        e.preventDefault();

        $('body').removeClass('modal-active');

        var id_marker_active = $('#map').find('.active').data('id-marker');
        Navigations(e, map, 'next', id_marker_active);

      });

      /**
       * Prev Post
       * @tourPrevItem
       */
      $(document).on('click', '.map__modal__nav__prev', function (e) {

        e.preventDefault();

        $('body').removeClass('modal-active');

        var id_marker_active = $('#map').find('.active').data('id-marker');
        Navigations(e, map, 'prev', id_marker_active);

      });

      map.setMinZoom(map.getBoundsZoom(map.options.maxBounds) + .25);
      map.setZoom(map.getBoundsZoom(map.options.maxBounds) + .25);

      /**
       * If Hash Url True
       */
      if (window.location.hash) {

        /**
         * Post ID
         * @type {string}
         */
        var hash = window.location.hash.substring(1);

        /**
         * If Post is Numeric
         */
        if (!isNaN(hash)) {

          /**
           * Variables
           * @type {{target: {_icon: {children: *[]}}}}
           */
          var e = {
              'target': {
                '_icon': {
                  'children': [],
                },
              },
            },
            marker = $('#map').find('[data-post="' + hash + '"]').data('id-marker'),
            type = $('#map').find('[data-post="' + hash + '"]').data('type');

          /**
           * if Marker length
           */
          if ( marker ) {
            e.target._icon.children[0] = {
              'dataset': {
                'post': hash,
                'idMarker': marker,
                'type': type,
              },
            };

            /**
             * Simulate Click Marker
             */

            map.setZoom(4);

            setTimeout(function () {
              clickMarker(e, map);
            }, 900);
          }
        }
      }

      /**
       * Zoomed
       */
      map.on('zoomend', function() {

        let currentZoom = map.getZoom();
        if (currentZoom < 3) {

          map.eachLayer(function (layer) {

            if ( layer.options.icon != undefined ) {

              $('#map').find('[data-id-marker="' + layer.options.myCustomId + '"]').css('transform', 'scale(0.7)');

            }

          });

        } else {

          map.eachLayer(function (layer) {

            if ( layer.options.icon != undefined ) {

              $('#map').find('[data-id-marker="' + layer.options.myCustomId + '"]').css('transform', 'scale(1.0)');
            }

          });

        }

      });

      /**
       * Sort markers according to z-index
       * @type {*|jQuery|HTMLElement}
       */
      let $leafletMarkerPane = $('.leaflet-pane.leaflet-marker-pane');
      $leafletMarkerPane.find('.leaflet-marker-icon').sort(function(a, b) {
        return +a.style.zIndex - +b.style.zIndex;
      }).appendTo($leafletMarkerPane);

      /**
       * Define pressed keys
       */
      let tabPressed = false,
          shiftPressed = false;
      $(document).on('keydown', function(e){
        tabPressed = e.keyCode = 9;
        shiftPressed = e.shiftKey;
      });
      $(document).on('keyup', function(){
        tabPressed = false;
        shiftPressed = false;
      });

      /**
       * Center map on marker focus
       */
      $(document).on('focus', 'body:not(.modal-active) .leaflet-marker-icon', function(e){
        if (tabPressed) {
          let lat = parseFloat($(e.target).attr('data-lat')),
              lng = parseFloat($(e.target).attr('data-lng'));

          map.setView(new Array(lat, lng + 20));
        }
      });

      /**
       * KeyPress on marker
       * Only return button
       */
      $(document).on('keypress', '.leaflet-marker-icon', function(e){
        if (e.keyCode == 13) {
          $(this).click();
        }
      });

      /**
       * Focus elements inside modal
       */
      $(document).on('focus', '*', function(e){
        if ($('body').hasClass('modal-active') && $(e.target).parents('.map__modal').length == 0) {
          let $el = $('.map__modal').find('select, input, textarea, button, a').filter(':visible');
          if (shiftPressed) {
            $el.last().focus();
          } else {
            $el.first().focus();
          }
        }
      });

      /**
       * Remove tabindex from map
       */
      $('#map').removeAttr('tabindex');

      /**
       * Press Space or Return on filters checkboxes
       */
      $(document).on('keydown', '.map__filters__form__checkbox', function(e){
        if (e.keyCode == 32 || e.keyCode == 13) {
          $(this).find('input').click();
        }
      });
    }

    /**
     * Marker Red
     * @param map
     * @param type
     * @param obj
     */
    function mapAddMarkerRed(map, obj = {})
    {

      /**
       * Data Attributes
       * @type {*|string}
       */
      var data_type       = ( obj.data_type != undefined ) ? obj.data_type : 'red',
        data_title      = ( obj.data_title != undefined ) ? obj.data_title : '',
        data_post       = ( obj.data_post != undefined ) ? obj.data_post : 0,
        data_id_marker  = ( obj.data_id_marker != undefined ) ? obj.data_id_marker : 0;

      /**
       * Create Icon
       */
        // eslint-disable-next-line no-undef
      var Icon = L.divIcon({
          className   : 'map__point-red',
          html        : '<div class="map__point-red-marker" id="' + data_id_marker + '" data-type="' + data_type + '" data-post="' + data_post + '" data-title="' + data_title + '" data-id-marker="' + data_id_marker + '"><svg width="25" height="32" viewBox="0 0 25 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.94241 0.10171L0.42006 2.61232C0.0371194 2.88527 -0.0903138 3.36329 0.13543 3.68L19.8124 31.2865C20.0382 31.6032 20.5316 31.6387 20.9146 31.3658L24.4369 28.8552C24.8199 28.5822 24.9473 28.1042 24.7215 27.7875L5.04453 0.180959C4.81879 -0.135756 4.32535 -0.171237 3.94241 0.10171Z" fill="#6D1F2E"/></svg></div>',
          iconSize    : [25, 32],
        });

      /**
       * LatLng
       * @type {string|*}
       */

      var lat = obj.geometry.coordinates[1],
        lng = obj.geometry.coordinates[0];

      /**
       * Marker
       */
        // eslint-disable-next-line no-undef
      var marker = L.marker([lat, lng], {
          icon      : Icon,
          draggable : false,
          myCustomId: obj.data_id_marker,
          riseOnHover: true,
        }).on('click', function (e) {

          $('#map').find('[data-id-marker="' + marker._leaflet_id + '"]').addClass('active');

          var pos = this.getLatLng();
          clickMarker(e, map);
          map.panTo([Number(pos.lat), Number(pos.lng + 20)]);

        }).on('mouseover', function (e) {

          Tooltip(e);

        }).addTo(map);

      $('#map').find('[data-id-marker="' + data_id_marker + '"]').parent().attr('data-lat', lat).attr('data-lng', lng);

      /**
       * Center Map
       * @type {L.featureGroup}
       */

    }

    /**
     * Marker Blue
     * @param map
     * @param type
     * @param obj
     */
    function mapAddMarkerBlue(map, obj = {})
    {

      /**
       * Data Attributes
       * @type {*|string}
       */
      var data_type       = ( obj.data_type != undefined ) ? obj.data_type : 'red',
        data_title      = ( obj.data_title != undefined ) ? obj.data_title : '',
        data_post       = ( obj.data_post != undefined ) ? obj.data_post : 0,
        data_id_marker  = ( obj.data_id_marker != undefined ) ? obj.data_id_marker : 0;

      /**
       * Create Icon
       */
        // eslint-disable-next-line no-undef
      var Icon = L.divIcon({
          className   : 'map__point-blue',
          html        : '<div class="map__point-blue-marker" id="' + data_id_marker + '" data-type="' + data_type + '" data-post="' + data_post + '" data-title="' + data_title + '" data-id-marker="' + data_id_marker + '"><svg width="25" height="32" viewBox="0 0 25 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.94241 0.10171L0.42006 2.61232C0.0371194 2.88527 -0.0903138 3.36329 0.13543 3.68L19.8124 31.2865C20.0382 31.6032 20.5316 31.6387 20.9146 31.3658L24.4369 28.8552C24.8199 28.5822 24.9473 28.1042 24.7215 27.7875L5.04453 0.180959C4.81879 -0.135756 4.32535 -0.171237 3.94241 0.10171Z" fill="#233746"/></svg></div>',
          iconSize    : [25, 32],
        });

      /**
       * LatLng
       * @type {string|*}
       */

      var lat = obj.geometry.coordinates[1],
        lng = obj.geometry.coordinates[0];

      /**
       * Marker
       */
        // eslint-disable-next-line no-undef
      var marker = L.marker([lat, lng], {
          icon      : Icon,
          draggable : false,
          myCustomId: obj.data_id_marker,
        }).on('click', function (e) {
          $('#map').find('[data-id-marker="' + marker._leaflet_id + '"]').addClass('active');

          var pos = this.getLatLng();
          clickMarker(e, map);
          map.panTo([Number(pos.lat), Number(pos.lng + 20)]);


        }).on('mouseover', function (e) {

          Tooltip(e);

        }).addTo(map);

      $('#map').find('[data-id-marker="' + data_id_marker + '"]').parent().attr('data-lat', lat).attr('data-lng', lng);

      /**
       * Center Map
       * @type {L.featureGroup}
       */

    }

    /**
     * Marker Info
     * @param map
     * @param type
     * @param obj
     */
    function mapAddMarkerInfo(map, obj = {})
    {

      /**
       * Data Attributes
       * @type {*|string}
       */
      var data_type       = ( obj.data_type != undefined ) ? obj.data_type : 'red',
        data_title      = ( obj.data_title != undefined ) ? obj.data_title : '',
        data_post       = ( obj.data_post != undefined ) ? obj.data_post : 0,
        data_id_marker  = ( obj.data_id_marker != undefined ) ? obj.data_id_marker : 0;

      /**
       * Create Icon
       */
        // eslint-disable-next-line no-undef
      var Icon = L.divIcon({
          className   : 'map__point-info',
          html        : '<div class="map__point-info-marker" id="' + data_id_marker + '" data-type="' + data_type + '" data-post="' + data_post + '" data-title="' + data_title + '" data-id-marker="' + data_id_marker + '"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 24C18.6274 24 24 18.6274 24 12C24 5.37258 18.6274 0 12 0C5.37258 0 0 5.37258 0 12C0 18.6274 5.37258 24 12 24Z" fill="#92DAD0"/><path fill-rule="evenodd" clip-rule="evenodd" d="M12.5 15V11H10.5V12H11.5V15H10V16H14V15H12.5ZM12 8C11.5858 8 11.25 8.3358 11.25 8.75C11.25 9.1642 11.5858 9.5 12 9.5C12.4142 9.5 12.75 9.1642 12.75 8.75C12.75 8.3358 12.4142 8 12 8ZM12 19C8.134 19 5 15.866 5 12C5 8.134 8.134 5 12 5C15.866 5 19 8.134 19 12C19 13.8565 18.2625 15.637 16.9497 16.9497C15.637 18.2625 13.8565 19 12 19ZM12 6C8.6863 6 6 8.6863 6 12C6 15.3137 8.6863 18 12 18C15.3137 18 18 15.3137 18 12C18 8.6863 15.3137 6 12 6Z" fill="#233746"/></svg></div>',
          iconSize    : [24, 24],
        });

      /**
       * LatLng
       * @type {string|*}
       */

      var lat = obj.geometry.coordinates[1],
        lng = obj.geometry.coordinates[0];

      /**
       * Marker
       */
        // eslint-disable-next-line no-undef
      var marker = L.marker([lat, lng], {
          icon      : Icon,
          draggable : false,
          myCustomId: obj.data_id_marker,
        }).on('click', function (e) {

          $('#map').find('[data-id-marker="' + marker._leaflet_id + '"]').addClass('active');

          var pos = this.getLatLng();
          clickMarker(e, map);
          map.panTo([Number(pos.lat), Number(pos.lng + 20)]);

        }).on('mouseover', function (e) {

          Tooltip(e);

        }).addTo(map);

      $('#map').find('[data-id-marker="' + data_id_marker + '"]').parent().attr('data-lat', lat).attr('data-lng', lng);

      /**
       * Center Map
       * @type {L.featureGroup}
       */

    }

    /**
     * layer with markers
     */
    // eslint-disable-next-line no-unused-vars
    function layerBounds(map, rc, claster)
    {
      // set marker at the image bound edges
      // eslint-disable-next-line no-undef
      var layerBounds = L.layerGroup([
        //L.marker(rc.unproject([0, 0])).bindPopup('[0,0]'),
        //L.marker(rc.unproject(img)).bindPopup(JSON.stringify(img))
      ])
      map.addLayer(layerBounds)

      // eslint-disable-next-line no-undef
      if (Object.keys(map_json_map).includes('features')) {
        // eslint-disable-next-line no-unused-vars,no-undef
        Object.keys(map_json_map.features).map(function (objectKey, index) {
          // eslint-disable-next-line no-undef
          var value = map_json_map.features[objectKey];

          if ( 'red' === value.data_type ) {
            mapAddMarkerRed(map, value);
          }

          if ( 'blue' === value.data_type ) {
            mapAddMarkerBlue(map, value);
          }

          if ( 'info' === value.data_type ) {
            mapAddMarkerInfo(map, value);
          }

        });
      }


      /**
       * Click Map
       */
      // eslint-disable-next-line no-unused-vars
      map.on('click', function (event) {

      })

      return layerBounds
    }

    let NextMarker = function(type) {
      let $next_prev_marker = null,
          $active_marker = null,
          $markers = null;

      /**
       * Find All Markers
       */
      $markers = $('#map').find('.leaflet-marker-icon:not(.hidden)');

      /**
       * Find Active Marker
       */
      $active_marker = $('#map').find('.active[data-id-marker]').parent('.leaflet-marker-icon');

      /**
       * Find Marker
       */
      if (type == 'prev') {
        $next_prev_marker = $active_marker.prevAll('.leaflet-marker-icon:not(.hidden)').first();
        if ($next_prev_marker.length == 0) {
          $next_prev_marker = $markers.last()
        }
      } else {
        $next_prev_marker = $active_marker.nextAll('.leaflet-marker-icon:not(.hidden)').first();
        if ($next_prev_marker.length == 0) {
          $next_prev_marker = $markers.first()
        }
      }

      return $next_prev_marker;
    }

    /**
     *
     * @param type
     * @constructor
     */
      // eslint-disable-next-line no-unused-vars
    let Navigations = function (e, map, type, active_marker) {
        let $next_prev_marker = NextMarker(type).find('[data-id-marker]');

        /**
         * Remove Active Class
         */
        $('#map').find('.active').removeClass('active');

        /**
         * Variables
         */
        var post          = $next_prev_marker.data('post'),
          id_marker     = $next_prev_marker.data('id-marker');

        /**
         * Load Detail Post
         */
        LoadDetail(e, post);

        /**
         * Control Markers
         */
        map.eachLayer(function (layer) {

          if ( layer.options.myCustomId != undefined ) {
            if (Number(layer.options.myCustomId) === Number(id_marker)) {
              map.invalidateSize();

              $('#map').find('[data-id-marker="' + layer.options.myCustomId + '"]').addClass('active');


              map.panTo([Number(layer._latlng.lat), Number(layer._latlng.lng + 20)]);

              //map.panTo(layer._latlng);

              //map.panBy([150, 0], {animate:false});
            }
          }
        });

      }

    /**
     *
     * @param e
     * @param type
     * @constructor
     */
      // eslint-disable-next-line no-unused-vars
    let LoadDetail = function (e, post = 0, element = 0, navigation = false) {

        var $ajax_content = $('.mapDetailAjax'),
          $modal        = $('.map__modal__content');
        /**
         * Ajax
         */
        $.ajax({

          beforeSend  :   function () {

            //setTimeout(function (){
            $('body').addClass('modal-active');
            //}, 400);

            $ajax_content.html('');
            $modal.addClass('preloader');
            $('.map__modal').attr('aria-hidden', 'false').show();
          },
          data        :   {
            action    :   'map_get_post',
            post      :   post,
          },
          dataType    :   'json',
          method      :   'POST',
          complete    :   function (){ },
          // eslint-disable-next-line no-unused-vars
          success     :   function ( response ) {

            $modal.removeClass('preloader');
            $ajax_content.html(response.data.html).ready(function () {

              /**
               * Fancybox
               * @fancybox
               */
              $('[data-fancybox="gallery"]').fancybox({
                infobar : false,
                loop: false,
                buttons: [
                  'close',
                ],
                thumbs : {
                  autoStart   : false,
                  hideOnClose : true,

                },
                touch : {
                  vertical : 'auto',
                },
                animationEffect: false,
                btnTpl: {
                  close: '<button data-fancybox-close class="test fancybox-button fancybox-button--closes" title="{{CLOSE}}"><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 1.05L10.95 0L6 4.95L1.05 0L0 1.05L4.95 6L0 10.95L1.05 12L6 7.05L10.95 12L12 10.95L7.05 6L12 1.05Z" fill="#233746"/></svg></button>',
                  arrowLeft: '<button data-fancybox-prev class="fancybox-button fancybox-button--arrow_left" title="{{PREV}}">' +
                    '<div><svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 0.5L8.5725 1.54475L2.8875 7.25H18V8.75H2.8875L8.5725 14.4298L7.5 15.5L0 8L7.5 0.5Z" fill="#233746"/></svg></div>' +
                    '</button>',

                  arrowRight: '<button data-fancybox-next class="fancybox-button fancybox-button--arrow_right" title="{{NEXT}}">' +
                    '<div><svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 0.5L9.4275 1.54475L15.1125 7.25H0V8.75H15.1125L9.4275 14.4298L10.5 15.5L18 8L10.5 0.5Z" fill="#233746"/></svg></div>' +
                    '</button>',
                },
              });
              $('[data-fancybox="gallery-single"]').fancybox({
                infobar : false,
                loop: false,
                buttons: [
                  'close',
                ],
                thumbs : {
                  autoStart   : false,
                  hideOnClose : true,

                },
                touch : {
                  vertical : 'auto',
                },
                animationEffect: false,
                btnTpl: {
                  close: '<button data-fancybox-close class="test fancybox-button fancybox-button--closes" title="{{CLOSE}}"><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 1.05L10.95 0L6 4.95L1.05 0L0 1.05L4.95 6L0 10.95L1.05 12L6 7.05L10.95 12L12 10.95L7.05 6L12 1.05Z" fill="#233746"/></svg></button>',
                  arrowLeft: '<button data-fancybox-prev class="fancybox-button fancybox-button--arrow_left" title="{{PREV}}">' +
                    '<div><svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 0.5L8.5725 1.54475L2.8875 7.25H18V8.75H2.8875L8.5725 14.4298L7.5 15.5L0 8L7.5 0.5Z" fill="#233746"/></svg></div>' +
                    '</button>',

                  arrowRight: '<button data-fancybox-next class="fancybox-button fancybox-button--arrow_right" title="{{NEXT}}">' +
                    '<div><svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 0.5L9.4275 1.54475L15.1125 7.25H0V8.75H15.1125L9.4275 14.4298L10.5 15.5L18 8L10.5 0.5Z" fill="#233746"/></svg></div>' +
                    '</button>',
                },
              });

              /**
               * Swiper
               * @Swiper
               */
              if ( $('.slider_lb').length ) {
                // eslint-disable-next-line no-unused-vars
                const swiper = new Swiper('.slider_lb .swiper-container', {
                  speed         : 400,
                  spaceBetween  : 15,
                  slidesPerView : 1,
                  pagination: {
                    el          : '.slider_lb .swiper-pagination',
                    clickable   : true,
                    type        : 'bullets',
                  },
                  navigation: {
                    nextEl      : '.slider_lb .swiper-button-next',
                    prevEl      : '.slider_lb .swiper-button-prev',
                  },
                });
              }
            });
          },
          // eslint-disable-next-line no-undef
          url         :   pmf.ajax_url,
        });

      }

    /**
     *
     * @param e
     * @param map
     */
    // eslint-disable-next-line no-unused-vars
    function clickMarker(e, map)
    {

      active_click_marker = e.target._icon.children[0].dataset.type;

      var post = e.target._icon.children[0].dataset.post;

      if ( Number(post) === 0 ) {
        $('.map__modal__content').html('');
        $('body').removeClass('modal-active');
        $('#map').find('.active').removeClass('active');
        return false;
      }

      $('body').removeClass('modal-active');

      // eslint-disable-next-line no-undef
      tippy.hideAll();

      var id = e.target._icon.children[0].dataset.idMarker;

      $('#map').find('.active').removeClass('active');
      $('#map').find('[data-id-marker="' + id + '"]')
        .addClass('active')
        .trigger('click');

      // set focus to modal
      $('.map__modal').attr('tabindex', 0).focus();

      /**
       *
       * @type {string}
       */
      LoadDetail(e, post);

    }

    /**
     * Init Map
     */
    init('map');

    // eslint-disable-next-line no-undef
    const instanceTooltip = {};

    let Tooltip = function (e) {


      if ( typeof instanceTooltip[e.target.options.myCustomId] !== 'undefined' ) {
        instanceTooltip[e.target.options.myCustomId][0].destroy();
      }

      // eslint-disable-next-line no-undef
      tippy.hideAll();
      // eslint-disable-next-line no-undef,no-unused-vars
      instanceTooltip[e.target.options.myCustomId] = tippy('#map [data-id-marker="' + e.target.options.myCustomId + '"]', {
        content(reference) {

          const title = reference.getAttribute('data-title');

          return '<div class="tippy__tooltip">' + title + '</div>';

        },
        allowHTML: true,
        placement: 'right-start',
        appendTo: () => document.body,
        // eslint-disable-next-line no-unused-vars
        offset(reference) {

          return [-50, -25];

        },
      });

    };

    /**
     * Close Modal
     */
    $(document).on('click', '.map__modal__close', function (e) {

      $('body').removeClass('modal-active');
      $('.map__modal').attr('aria-hidden', 'true').hide();
      $('#map').find('.active').parent('.leaflet-marker-icon').focus();
      $('#map').find('.active').removeClass('active');

      e.preventDefault();

    });

  },
};
