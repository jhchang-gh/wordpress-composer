/**
 * Map Backend
 */
jQuery( function( $ ) {

  /**
   * Init
   * @param mapid
   */
  function init (mapid) {

    var minZoom = 2,
        maxZoom = 5,
        img     = [
          document.getElementById('inp_map__width').value,
          document.getElementById('inp_map__height').value,
        ];

    /**
     * Create the map
     */
      // eslint-disable-next-line no-undef
    var map = L.map(mapid, {
      minZoom : minZoom,
      maxZoom : maxZoom,
    })

    // assign map and image dimensions
    // eslint-disable-next-line no-undef
    var rc = new L.RasterCoords(map, img)

    // set the view on a marker ...
    map.setView(rc.unproject([0, 0]), 2);
    // eslint-disable-next-line no-unused-vars
    var offset = map.getSize().y * 0.15;
    // eslint-disable-next-line no-undef
    map.panBy(new L.Point (img[0] / 2, img[1] / 2), {animate: false});

    /**
     * add layer control object
     */
      // eslint-disable-next-line no-unused-vars,no-undef
    var lcontrol = L.control.layers({}, {
          'Bounds': layerBounds(map, rc),
        }).addTo(map)

    /**
     * the tile layer containing the image generated
     */
    // eslint-disable-next-line no-undef
    L.tileLayer(map_url_tiles+'/{z}/{x}/{y}.png', {
      noWrap      : true,
      attribution : '',
    }).addTo(map)

    /**
     * Add Red Marker
     * @type {HTMLElement}
     */
    var btn_add_red = document.getElementById('map_add_point_red');
    // eslint-disable-next-line no-unused-vars
    btn_add_red.addEventListener('click', event => {

      mapAddMarkerRed(map);

    });

    /**
     * Add Blue Marker
     * @type {HTMLElement}
     */
    var btn_add_blue = document.getElementById('map_add_point_blue');
    btn_add_blue.addEventListener('click', event => {

      mapAddMarkerBlue(map);

    });

    /**
     * Add Info Marker
     * @type {HTMLElement}
     */
    var btn_add_info = document.getElementById('map_add_point_info');
    btn_add_info.addEventListener('click', event => {

      mapAddMarkerInfo(map);

    });


    /**
     * Controls Remove
     * @type {HTMLElement}
     */
    var controls_remove = document.getElementById('map_point_remove');
    controls_remove.addEventListener('click', event => {

      const id_element_selected = document.getElementById('map_point_selected_real_id').value;

      map.eachLayer( function(layer) {

        if ( layer._leaflet_id === Number(id_element_selected) ) map.removeLayer(layer);

      });

      hideControls();

    });

    /**
     * Save Map
     */
    var btn_save_map = document.getElementById('map_button_save_map');
    var collection = {
      "type": "FeatureCollection",
      "features": []
    };

    btn_save_map.addEventListener('click', event => {

      /**
       * Each Marker Map
       */
      map.eachLayer(function (layer) {

        /**
         * Check if layer is a marker
         */
        if (layer instanceof L.Marker) {

          /**
           * Create GeoJSON object from marker
           */
          var geojson = layer.toGeoJSON();

          /**
           * Set Attribute
           * @type {string}
           */
          geojson["data_title"]       = layer._icon.children[0].dataset.title;
          geojson["data_post"]        = layer._icon.children[0].dataset.post;
          geojson["data_type"]        = layer._icon.children[0].dataset.type;
          geojson["data_id_marker"]   = layer._leaflet_id;

          collection.features.push(geojson);
        }
      });

      /**
       * Variables
       * @type {{features: *[], type: string}}
       */
      let json    = collection,
          $button = jQuery('.mapSave'),
          post    = $button.data('post'),
          width   = jQuery('.map_map__width').val(),
          height  = jQuery('.map_map__height').val();

      /**
       * Ajax
       */
      jQuery.ajax( {
        beforeSend  :   function(){

          $button.block({ message: null, overlayCSS: { background: '#fff', opacity: 0.6 } });

        },
        data        :   {
          action  : 'map_save',
          map     : json,
          post    : post,
          width   : width,
          height  : height,
        },
        dataType    :   'json',
        method      :   'POST',
        complete    :   function(){

          $button.unblock();

        },
        success     :   function( response ){

          jQuery('.mapSaveMessage').html(response.data.html)

        },
        url         :   ajaxurl,
      } );

    })

  }

  /**
   * Marker Red
   * @param map
   * @param type
   * @param obj
   */
  function mapAddMarkerRed (map, type = 'create', obj = {}) {

    /**
     *
     * Variables
     * @type {number}
     */
    var random_id       = Math.floor(Math.random() * (9999999 - 1 + 1)) + 1,
        id_element      = 'point-' + random_id,
        popper          = document.getElementById('map__popper');

    /**
     * if Create Marker
     */
    if( 'create' === type ) {
      popper.classList.add('show');
      popper.classList.add('red');
      popper.classList.remove('info');
    }

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
    var Icon = L.divIcon({
      className   : 'map__point-red',
      html        : '<div class="map__point-red-marker" id="' + id_element + '" data-type="' + data_type + '" data-post="' + data_post + '" data-title="' + data_title + '" data-id-marker="' + data_id_marker + '"><svg width="25" height="32" viewBox="0 0 25 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.94241 0.10171L0.42006 2.61232C0.0371194 2.88527 -0.0903138 3.36329 0.13543 3.68L19.8124 31.2865C20.0382 31.6032 20.5316 31.6387 20.9146 31.3658L24.4369 28.8552C24.8199 28.5822 24.9473 28.1042 24.7215 27.7875L5.04453 0.180959C4.81879 -0.135756 4.32535 -0.171237 3.94241 0.10171Z" fill="#6D1F2E"/></svg></div>',
      iconSize    : [25, 32],
    });

    /**
     * LatLng
     * @type {string|*}
     */
    var lat = map.getCenter().lat,
      lng = map.getCenter().lng;
    if( 'edit' === type ) {
      lat = obj.geometry.coordinates[1];
      lng = obj.geometry.coordinates[0];
    }

    /**
     * Marker
     */
    var marker = L.marker([lat, lng], {
      icon      : Icon,
      draggable : true,
    }).addTo(map).on('click', function(e) {

      //63
      document.getElementById('map_point_selected_real_id').value = e.target._leaflet_id;

      showControls(id_element, 'red');
      map.panTo(this.getLatLng());

    });

    /**
     * Set Value to Panel Controls
     * @type {number}
     */
    document.getElementById('map_point_selected_real_id').value = marker._leaflet_id;
    document.getElementById('map_point_selected').value = id_element;

    document.getElementById('map_point_red_post').value = 0;
    document.getElementById('map_point_red_post').dispatchEvent(new Event('change'));

  }

  /**
   * Marker Blue
   * @param map
   * @param type
   * @param obj
   */
  function mapAddMarkerBlue (map, type = 'create', obj = {}) {

    /**
     *
     * Variables
     * @type {number}
     */
    var random_id       = Math.floor(Math.random() * (9999999 - 1 + 1)) + 1,
        id_element      = 'point-' + random_id,
        popper          = document.getElementById('map__popper');

    /**
     * if Create Marker
     */
    if( 'create' === type ) {
      popper.classList.add('show');
      popper.classList.add('red');
      popper.classList.remove('info');
    }

    /**
     * Data Attributes
     * @type {*|string}
     */
    var data_type       = ( obj.data_type != undefined ) ? obj.data_type : 'blue',
        data_title      = ( obj.data_title != undefined ) ? obj.data_title : '',
        data_post       = ( obj.data_post != undefined ) ? obj.data_post : 0,
        data_id_marker  = ( obj.data_id_marker != undefined ) ? obj.data_id_marker : 0;

    /**
     * Create Icon
     */
    var Icon = L.divIcon({
      className   : 'map__point-blue',
      html        : '<div class="map__point-blue-marker" id="' + id_element + '" data-type="' + data_type + '" data-post="' + data_post + '" data-title="' + data_title + '" data-id-marker="' + data_id_marker + '"><svg width="25" height="32" viewBox="0 0 25 32" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.94241 0.10171L0.42006 2.61232C0.0371194 2.88527 -0.0903138 3.36329 0.13543 3.68L19.8124 31.2865C20.0382 31.6032 20.5316 31.6387 20.9146 31.3658L24.4369 28.8552C24.8199 28.5822 24.9473 28.1042 24.7215 27.7875L5.04453 0.180959C4.81879 -0.135756 4.32535 -0.171237 3.94241 0.10171Z" fill="#233746"/></svg></div>',
      iconSize    : [25, 32],
    });

    /**
     * LatLng
     * @type {string|*}
     */
    var lat = map.getCenter().lat,
        lng = map.getCenter().lng;
    if( 'edit' === type ) {
      lat = obj.geometry.coordinates[1];
      lng = obj.geometry.coordinates[0];
    }

    /**
     * Marker
     */
    var marker = L.marker([lat, lng], {
      icon      : Icon,
      draggable : true,
    }).addTo(map).on('click', function(e) {

      document.getElementById('map_point_selected_real_id').value = e.target._leaflet_id;

      showControls(id_element, 'red');
      map.panTo(this.getLatLng());

    });

    /**
     * Set Value to Panel Controls
     * @type {number}
     */
    document.getElementById('map_point_selected_real_id').value = marker._leaflet_id;
    document.getElementById('map_point_selected').value = id_element;

    document.getElementById('map_point_red_post').value = 0;
    document.getElementById('map_point_red_post').dispatchEvent(new Event('change'));

  }

  /**
   * Marker Info
   * @param map
   * @param type
   * @param obj
   */
  function mapAddMarkerInfo (map, type = 'create', obj = {}) {

    /**
     *
     * Variables
     * @type {number}
     */
    var random_id       = Math.floor(Math.random() * (9999999 - 1 + 1)) + 1,
        id_element      = 'point-' + random_id,
        popper          = document.getElementById('map__popper');

    /**
     * if Create Marker
     */
    if( 'create' === type ) {
      popper.classList.add('show');
      popper.classList.add('info');
      popper.classList.remove('red');
    }

    /**
     * Data Attributes
     * @type {*|string}
     */
    var data_type       = ( obj.data_type != undefined ) ? obj.data_type : 'info',
        data_title      = ( obj.data_title != undefined ) ? obj.data_title : '',
        data_post       = ( obj.data_post != undefined ) ? obj.data_post : 0,
        data_id_marker  = ( obj.data_id_marker != undefined ) ? obj.data_id_marker : 0;

    /**
     * Create Icon
     */
    var Icon = L.divIcon({
      className   : 'map__point-info',
      html        : '<div class="map__point-info-marker" id="' + id_element + '" data-type="' + data_type + '" data-post="' + data_post + '" data-title="' + data_title + '" data-id-marker="' + data_id_marker + '"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 24C18.6274 24 24 18.6274 24 12C24 5.37258 18.6274 0 12 0C5.37258 0 0 5.37258 0 12C0 18.6274 5.37258 24 12 24Z" fill="#92DAD0"/><path fill-rule="evenodd" clip-rule="evenodd" d="M12.5 15V11H10.5V12H11.5V15H10V16H14V15H12.5ZM12 8C11.5858 8 11.25 8.3358 11.25 8.75C11.25 9.1642 11.5858 9.5 12 9.5C12.4142 9.5 12.75 9.1642 12.75 8.75C12.75 8.3358 12.4142 8 12 8ZM12 19C8.134 19 5 15.866 5 12C5 8.134 8.134 5 12 5C15.866 5 19 8.134 19 12C19 13.8565 18.2625 15.637 16.9497 16.9497C15.637 18.2625 13.8565 19 12 19ZM12 6C8.6863 6 6 8.6863 6 12C6 15.3137 8.6863 18 12 18C15.3137 18 18 15.3137 18 12C18 8.6863 15.3137 6 12 6Z" fill="#233746"/></svg></div>',
      iconSize    : [24, 24],
    });

    /**
     * LatLng
     * @type {string|*}
     */
    var lat = map.getCenter().lat,
      lng = map.getCenter().lng;
    if( 'edit' === type ) {
      lat = obj.geometry.coordinates[1];
      lng = obj.geometry.coordinates[0];
    }

    /**
     * Marker
     */
    var marker = L.marker([lat, lng], {
      icon      : Icon,
      draggable : true,
    }).addTo(map).on('click', function(e) {

      document.getElementById('map_point_selected_real_id').value = e.target._leaflet_id;

      showControls(id_element, 'info');
      map.panTo(this.getLatLng());

    });

    /**
     * Set Value to Panel Controls
     * @type {number}
     */
    document.getElementById('map_point_selected_real_id').value = marker._leaflet_id;
    document.getElementById('map_point_selected').value = id_element;

    document.getElementById('map_point_red_post').value = 0;
    document.getElementById('map_point_red_post').dispatchEvent(new Event('change'));

  }


  /**
   * layer with markers
   */
  // eslint-disable-next-line no-unused-vars
  function layerBounds (map, rc) {
    // set marker at the image bound edges
    var layerBounds = L.layerGroup([])
    map.addLayer(layerBounds)

    // eslint-disable-next-line no-undef
    if(Object.keys(json_map).includes('features')){
      Object.keys(json_map.features).map(function(objectKey, index) {
        var value = json_map.features[objectKey];

        /**
         * Red
         */
        if( 'red' === value.data_type ) {
          mapAddMarkerRed(map, 'edit', value);
        }

        /**
         * Blue
         */
        if( 'blue' === value.data_type ) {
          mapAddMarkerBlue(map, 'edit', value);
        }

        /**
         * Info
         */
        if( 'info' === value.data_type ) {
          mapAddMarkerInfo(map, 'edit', value);
        }

      });
    }

    /**
     * Click Map
     */
    // eslint-disable-next-line no-unused-vars
    map.on('click', function (event) {

      /**
       * Hide Controls
       */
      hideControls();

    })

    return layerBounds
  }

  /**
   *
   * @param id
   * @param type
   */
  function showControls(id, type) {

    var id_point_input  = document.getElementById('map_point_selected'),
        point           = document.getElementById(id),
        popper          = document.getElementById('map__popper'),
        post            = point.getAttribute('data-post');

    id_point_input.value = id;

    post = point.getAttribute('data-post');
    post = (post > 0) ? post : 0;

    popper.classList.add('show');
    popper.classList.add(type);

    if( 'red' === type || 'blue' === type ) {

      popper.classList.remove('info');

      document.getElementById('map_point_red_post').value = post;
      document.getElementById('map_point_red_post').dispatchEvent(new Event('change'));

    }else if ( 'info' === type ) {

      popper.classList.remove('red');

      document.getElementById('map_point_info_post').value = post;
      document.getElementById('map_point_info_post').dispatchEvent(new Event('change'));

    }

  }

  /**
   * Hide Controls
   */
  function hideControls() {

    var controls = document.getElementById('map__popper');

    controls.classList.remove('show');
    controls.classList.remove('red');
    controls.classList.remove('blue');
    controls.classList.remove('info');

  }

  /**
   * Hide Controls
   * @type {HTMLElement}
   */
  var controls_close = document.getElementById('map__popper__close');
  controls_close.addEventListener('click', event => {

    hideControls();

  });

  /**
   * Init Map
   */
  init('map');

  /**
   * Upload File
   * @type {HTMLElement}
   */
  var btn_upload_map_file = document.getElementById('btn_upload_map_file');
  btn_upload_map_file.addEventListener('click', event => {

    /**
     * Init Media Wp
     */
    var MediaUploadZip = window.wp.media({
      frame           : 'select',
      title           : 'Select Zip Archive',
      multiple        : false,
      library         : {
        type: 'application/zip',
      },
      button: {
        text        : 'Select Zip',
      },

    });

    /**
     * Open Media Wp
     */
    MediaUploadZip.open();

    /**
     * Select
     */
    MediaUploadZip.on( 'select', function() {

      let selectionCollection = MediaUploadZip.state().get('selection').first().toJSON(),
        $button = jQuery('#btn_upload_map_file');

      jQuery.ajax( {
        beforeSend  :   function(){

          $button.block({ message: null, overlayCSS: { background: '#fff', opacity: 0.6 } });
          $('#map').block({ message: null, overlayCSS: { background: '#fff', opacity: 0.6 } });

        },
        data        :   {
          action    :   'map_upload_zip',
          file_id   :   selectionCollection.id,
          file_url  :   selectionCollection.url,
          file_name :   selectionCollection.name,
          post      :   selectionCollection.uploadedTo,
        },
        dataType    :   'json',
        method      :   'POST',
        complete    :   function(){

          $button.unblock();
          $('#map').unblock();

        },
        success     :   function( response ){

          $('.mapUploadMessage').html(response.data.message);

          if( response.success === true  ) {
            location.reload();
            return false;
          }

        },
        url         :   ajaxurl,
      } );

    } );


  })

  /**
   * Select2
   */
  let select_post = $('.map-js-select').select2();

  select_post.on('select2:select', function (e) {
    let data                  = e.params.data,
        id_element_selected   = document.getElementById('map_point_selected').value,
        title                 = '';

    if( data.id > 0 ) {
      title = data.element.label;
    }else{
      title                 = ''
    }

    document.getElementById(id_element_selected).setAttribute('data-post', data.id);
    document.getElementById(id_element_selected).setAttribute('data-title', title);

  });

})
