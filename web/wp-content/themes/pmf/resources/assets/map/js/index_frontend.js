// eslint-disable-next-line no-unused-vars
jQuery( function( $ ) {

  /**
   * Init
   * @param mapid
   */
  function init (mapid) {

    var minZoom = 0,
        maxZoom = 5,
        img = [];

    /**
     * Create the map
     */
      // eslint-disable-next-line no-undef
    var map = L.map(mapid, {
        minZoom : minZoom,
        maxZoom : maxZoom,
        zoomControl: false,
      })

    // assign map and image dimensions
    // eslint-disable-next-line no-undef
    var rc = new L.RasterCoords(map, img)

    // set the view on a marker ...
    map.setView(rc.unproject([0, 0]), 5);

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

    /**
     * ResizeMap
     */
    map.invalidateSize();

  }

  /**
   * Marker Red
   * @param map
   * @param type
   * @param obj
   */
  function mapAddMarkerRed (map, obj = {}) {

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
      }).addTo(map).on('click', function(e) {

        $('#map').find('[data-id-marker="' + marker._leaflet_id + '"]').addClass('active');

        clickMarker(e, map);
        map.panTo(this.getLatLng());

      });



    /**
     * Center Map
     * @type {L.featureGroup}
     */
      // eslint-disable-next-line no-undef
    var group = new L.featureGroup([marker]);
    map.fitBounds(group.getBounds());


  }

  /**
   * Marker Blue
   * @param map
   * @param type
   * @param obj
   */
  function mapAddMarkerBlue (map, obj = {}) {

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
      }).addTo(map).on('click', function(e) {

        $('#map').find('[data-id-marker="' + marker._leaflet_id + '"]').addClass('active');

        clickMarker(e, map);
        map.panTo(this.getLatLng());

      });



    /**
     * Center Map
     * @type {L.featureGroup}
     */
      // eslint-disable-next-line no-undef
    var group = new L.featureGroup([marker]);
    map.fitBounds(group.getBounds());


  }

  /**
   * Marker Info
   * @param map
   * @param type
   * @param obj
   */
  function mapAddMarkerInfo (map, obj = {}) {

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
      }).addTo(map).on('click', function(e) {

        $('#map').find('[data-id-marker="' + marker._leaflet_id + '"]').addClass('active');

        clickMarker(e, map);
        map.panTo(this.getLatLng());

      });



    /**
     * Center Map
     * @type {L.featureGroup}
     */
      // eslint-disable-next-line no-undef
    var group = new L.featureGroup([marker]);
    map.fitBounds(group.getBounds());


  }

  /**
   * layer with markers
   */
  function layerBounds (map, rc, img) {
    // set marker at the image bound edges
    var layerBounds = L.layerGroup([
      //L.marker(rc.unproject([0, 0])).bindPopup('[0,0]'),
      //L.marker(rc.unproject(img)).bindPopup(JSON.stringify(img))
    ])
    map.addLayer(layerBounds)

    if(Object.keys(map_json_map).includes('features')){
      Object.keys(map_json_map.features).map(function(objectKey, index) {
        var value = map_json_map.features[objectKey];

        if( 'red' === value.data_type ) {
          mapAddMarkerRed(map, value);
        }

        if( 'blue' === value.data_type ) {
          mapAddMarkerBlue(map, value);
        }

        if( 'info' === value.data_type ) {
          mapAddMarkerInfo(map, value);
        }

      });
    }


    /**
     * Click Map
     */
    map.on('click', function (event) {

    })

    return layerBounds
  }

  /**
   *
   * @param type
   * @constructor
   */
  let Navigations = function (e, map, type, active_marker) {

    /**
     * Variables Default
     * @type {null}
     */
    var $next_prev_marker  = null,
      id_item       = 0;


    /**
     * Generate Object Markers Red
     * @type {{features: {}}}
     */
    var arr_marker = {
      "features": {},
    };
    map.eachLayer( function(layer) {

      if( layer.options.icon != undefined ) {

        if( layer.options.icon.options.className === 'map__point-red' ) {

          if( layer._leaflet_id > 0 ) {
            arr_marker.features[layer.options.myCustomId] = layer;
          }

        }

      }

    });

    /**
     * Get Object Item Next and Prev
     * @param key
     * @param i
     * @returns {*}
     */
    var getItem = function(key, i) {
      var keys = Object.keys(arr_marker.features).sort(function(a,b){return a-b;});
      var index = keys.indexOf(key);
      if ((i==-1 && index>0) || (i==1 && index<keys.length-1)) {index = index+i;}
      return arr_marker.features[keys[index]];
    }


    if( type === 'prev' ) {

      id_item = getItem(String(active_marker), -1);

      if( Number(id_item.options.myCustomId) === Number(active_marker) ) {

        id_item = arr_marker.features[Object.keys(arr_marker.features)[Object.keys(arr_marker.features).length-1]];

      }

    }else if ( type === 'next' ){

      id_item = getItem(String(active_marker), +1);

      if( Number(id_item.options.myCustomId) === Number(active_marker) ) {

        id_item = arr_marker.features[Object.keys(arr_marker.features)[0]];

      }

    }

    /**
     * Find Marker
     */
    $next_prev_marker = $('#map').find('[data-id-marker="'+ id_item.options.myCustomId +'"]');

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
    map.eachLayer( function(layer) {

      if ( layer.options.myCustomId != undefined ) {

        if (Number(layer.options.myCustomId) === Number(id_marker)) {

          $('#map').addClass('map_translation');
          map.invalidateSize();

          $('#map').find('.map__point-blue-marker, .map__point-red-marker').css('opacity', 0);
          $('#map').find('[data-id-marker="' + layer.options.myCustomId + '"]').css('opacity', 1);
          $('#map').find('[data-id-marker="' + layer.options.myCustomId + '"]').addClass('active');

          map.panTo(layer._latlng);

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
    $.ajax( {

      beforeSend  :   function(){

        $ajax_content.html('');
        $modal.addClass('preloader');

      },
      data        :   {
        action    :   'map_get_post',
        post      :   post,
      },
      dataType    :   'json',
      method      :   'POST',
      complete    :   function(){ },
      // eslint-disable-next-line no-unused-vars
      success     :   function( response ){

        $modal.removeClass('preloader');
        $ajax_content.html(response.data.html).ready(function(){

          if( $('.slider_lb').length ) {
            const swiper = new Swiper('.slider_lb .swiper-container', {
              speed         : 400,
              spaceBetween  : 0,
              slidesPerView: 1,
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
    } );

  }

  /**
   *
   * @param e
   * @param map
   */
  // eslint-disable-next-line no-unused-vars
  function clickMarker(e, map) {

    var post = e.target._icon.children[0].dataset.post;

    if( Number(post) === 0 ) {

      $('.map__modal__content').html('');
      $('body').removeClass('modal-active');
      $('#map').find('.active').removeClass('active');
      return false;

    }

    $('body').addClass('modal-active');

    // eslint-disable-next-line no-undef
    tippy.hideAll();

    var id = e.target._icon.children[0].dataset.idMarker;

    $('#map').find('.active').removeClass('active');
    $('#map').find('[data-id-marker="' + id + '"]').addClass('active');

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
  tippy('.map__point-red-marker, .map__point-blue-marker, .map__point-info-marker', {
    content(reference) {

      const title = reference.getAttribute('data-title');

      return  '<div class="tippy__tooltip">' + title + '</div>';

    },
    allowHTML           : true,
    placement           : 'right-start',
    appendTo            : () => document.body,
    // eslint-disable-next-line no-unused-vars
    offset(reference) {

      return [-50, -25];

    },
  });

  $(document).on('click', '.map__modal__close', function(e) {

    $('body').removeClass('modal-active');
    $('#map').find('.active').removeClass('active');

    e.preventDefault();

  });


})
