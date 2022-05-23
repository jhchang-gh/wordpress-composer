<?php
namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Query;
use ZipArchive;

class Map extends Controller {

    /**
     * @var string
     * @VERSION
     */
    protected $VERSION = '1.0.0';

    /**
     * Map constructor.
     * @since 1.0.0
     * @__construct
     */
    public function __construct(){

        add_action( 'init', array( &$this, 'cptui_register_map_cpts' ) );

        /**
         * Scripts and Css
         */
        add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ) );

        /**
         * Create Section Canvas
         */
        add_action('edit_form_after_title', array(&$this, 'createSection'));

        /**
         * Scripts and Css Footer Frontend
         */
        add_action( 'wp_enqueue_scripts', array( &$this, 'frontend_enqueue_scripts' ) );
        add_action( 'wp_footer', array( &$this, 'frontend_footer_scripts' ) );

        /**
         * Ajax Action
         */
        add_action( 'wp_ajax_upload_map', array(&$this, 'upload_map_func') );
        add_action( 'wp_ajax_nopriv_upload_map', array(&$this, 'upload_map_func') );

        add_action( 'wp_ajax_map_save', array(&$this, 'map_save_func') );
        add_action( 'wp_ajax_nopriv_map_save', array(&$this, 'map_save_func') );

        add_action( 'wp_ajax_map_get_post', array(&$this, 'map_get_post_func') );
        add_action( 'wp_ajax_nopriv_map_get_post', array(&$this, 'map_get_post_func') );

        /**
         *
         */
        add_action( 'get_header_after', array(&$this, 'filter_header_insert') );


    }

    /**
     * Map Post Type.
     * @since 1.0.0
     * @cptui_register_map_cpts
     */
    public function cptui_register_map_cpts() {



    }

    /**
     * Frontend Insert Footer Script
     * @since 1.0.0
     *
     * @frontend_footer_scripts
     */
    public function frontend_footer_scripts() {

        /**
         * Template
         */
        $template_file = get_post_meta(get_the_ID(), '_wp_page_template', TRUE);

        if( 'views/interactive-map-page.blade.php' == $template_file ) :

            global $wp_query;
            $post_id = $wp_query->post->ID;

            /**
             * Get Json Map
             */
            //$json = get_post_meta( $post_id, '_map_json', true );

            $json = null;
            $map_file = get_template_directory() . '/assets/map/images/tiles/' . $post_id . '/map.json';
            if (file_exists($map_file)) :
                $json = file_get_contents($map_file);
            endif;

            $map_width  = ( get_post_meta( $post_id, '_map_width', true ) ) ? get_post_meta( $post_id, '_map_width', true ) : 700;
            $map_height = ( get_post_meta( $post_id, '_map_height', true ) ) ? get_post_meta( $post_id, '_map_height', true ) : 600;

            ?>
            <script>
                /**
                 * Global Variables
                 */
                    <?php if( $json ) : ?>
                var map_json_map = <?= $json ?>;
                <?php else: ?>
                var map_json_map = {};
                <?php endif; ?>

                var map_ID = <?= get_the_ID() ?>;
                var map_size = [
                    <?= $map_width ?>,
                    <?= $map_height ?>,
                ];
                var map_url_tiles = '<?= WP_CONTENT_URL ?>/themes/<?= wp_get_theme() ?>/resources/assets/map/images/tiles/<?= $post_id ?>/tiles/';

            </script>
            <!-- Preload 360 Plugin -->
            <div id="viewerHtml" class="viewer">
                <button data-fancybox-close class="fancybox-button fancybox-button--close" tabindex="-1"><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 1.05L10.95 0L6 4.95L1.05 0L0 1.05L4.95 6L0 10.95L1.05 12L6 7.05L10.95 12L12 10.95L7.05 6L12 1.05Z" fill="#233746"/></svg></button>
                <div class="viewer__container" id="viewer"></div>
            </div>
            <!-- End Preload 360 Plugin -->
        <?php

        endif;

    }

    /**
     * Frontend Include Script and Style
     * @since 1.0.0
     *
     * @frontend_enqueue_scripts
     */
    public function frontend_enqueue_scripts() {

        /**
         * Template
         */
        $template_file = get_post_meta(get_the_ID(), '_wp_page_template', TRUE);

        if( 'views/interactive-map-page.blade.php' == $template_file ) :

            /**
             * Srtyle
             */
            wp_enqueue_style('map-leaflet', get_template_directory_uri() . '/assets/map/css/leaflet.css');
            wp_enqueue_style('map-tippy', get_template_directory_uri() . '/assets/map/css/tippy.css');
            wp_enqueue_style('map-viewer', get_template_directory_uri() . '/assets/map/css/photo-sphere-viewer.min.css');

            /**
             * Leaflet
             */
            wp_enqueue_script('map-leaflet', 'https://unpkg.com/leaflet@1/dist/leaflet.js', ['jquery-core'], null, true);
            wp_enqueue_script('map-rastercoords', get_template_directory_uri() . '/assets/map/js/rastercoords.js', ['jquery-core'], null, true);
            //wp_enqueue_script('map-claster', get_template_directory_uri() . '/assets/map/js/leaflet.markercluster-src.js', ['jquery-core'], null, true);

            /**
             * Tooltip
             */
            wp_enqueue_script('map-popper', get_template_directory_uri() . '/assets/map/js/popper.js', ['jquery-core'], null, true);
            wp_enqueue_script('map-tippy', get_template_directory_uri() . '/assets/map/js/tippy.js', ['jquery-core'], null, true);

        endif;

    }

    /**
     * Admin Include Scripts And CSS
     * @since 1.0.0
     *
     * @admin_enqueue_scripts
     */
    public function admin_enqueue_scripts() {

        /**
         * CSS
         * @wp_enqueue_style
         */
        wp_enqueue_style('map-admin', get_template_directory_uri() . '/assets/map/css/main.css');
        wp_enqueue_style('map-leaflet', 'https://unpkg.com/leaflet@1/dist/leaflet.css');

        /**
         * JS
         * @wp_enqueue_script
         */
        wp_enqueue_script('map-blockUI', get_template_directory_uri() . '/assets/map/js/jquery.blockUI.js', array('jquery'), '2.7', true);
        wp_enqueue_script('map-leaflet', 'https://unpkg.com/leaflet@1/dist/leaflet.js', [], null, true);
        wp_enqueue_script('map-rastercoords', get_template_directory_uri() . '/assets/map/js/rastercoords.js', array('jquery'), '1.0.0', true);
        wp_enqueue_script('map-index', get_template_directory_uri() . '/assets/map/js/index.js', array('jquery'), '1.0.0', true);

    }

    /**
     * @param $post
     * @since 1.0.0
     */
    public function createSection($post) {

        /**
         * Global
         */
        global $pagenow;
        $template_file = get_post_meta($post->ID, '_wp_page_template', TRUE);

        if( 'post.php' === $pagenow && 'views/interactive-map-page.blade.php' == $template_file ) :

            $map_width  = ( get_post_meta( $post->ID, '_map_width', true ) ) ? get_post_meta( $post->ID, '_map_width', true ) : 700;
            $map_height = ( get_post_meta( $post->ID, '_map_height', true ) ) ? get_post_meta( $post->ID, '_map_height', true ) : 600;
            //$json       = get_post_meta( $post->ID, '_map_json', true );

            $json = null;
            $map_file = get_template_directory() . '/assets/map/images/tiles/' . $post->ID . '/map.json';
            if (file_exists($map_file)) :
                $json = file_get_contents($map_file);
            endif;
            ?>
            <style>
                #edit-slug-box {
                    display: none;
                }
            </style>
            <script>

                /**
                 * Global Variables
                 */
                    <?php if( $json ) : ?>
                var json_map = <?= $json ?>;
                <?php else: ?>
                var json_map = {};
                <?php endif; ?>

                var map_ID = <?= $post->ID ?>;
                var map_FOLBER = '<?= get_template_directory() . '/assets/map/images/tiles/' . $post->ID ?>/';
                var map_url_tiles = '<?= WP_CONTENT_URL ?>/themes/<?= wp_get_theme() ?>/resources/assets/map/images/tiles/<?= $post->ID ?>/tiles/';

            </script>
            <!-- Tour -->
            <div class="map empty">

                <!-- Panel -->
                <div class="panel">

                    <!-- Panel > Left -->
                    <div class="panel__left">

                        <div>
                            <a href="#add-map" class="btn btn-color mapUploadButton" id="btn_upload_map_file">
                                <span class="dashicons dashicons-insert"></span>
                                <?= __( 'Upload Map', 'pmf' ) ?>
                            </a>
                            <div class="mapUploadMessage"></div>
                        </div>

                        <!-- Sizes -->
                        <div class="panel__left__sizes">
                            <!-- Size Map -->
                            <div class="panel__left__inp">
                                <label for="inp_map__width">
                                    <?= __( 'W:', 'pmf' ) ?>
                                </label>
                                <input type="number" value="<?= $map_width ?>" class="map_map__width" id="inp_map__width">
                            </div>

                            <div class="panel__left__inp">
                                <label for="inp_map__height">
                                    <?= __( 'H:', 'pmf' ) ?>
                                </label>
                                <input type="number" value="<?= $map_height ?>" class="map_map__height" id="inp_map__height">
                            </div>
                            <!-- End Size Map -->
                        </div>
                        <!-- End Sizes -->

                        <!-- Btn -->
                        <div class="panel__left__added">

                            <a href="#red" class="panel__left__added__blue" id="map_add_point_blue">
                                <span>
                                    +
                                </span>
                                <?= __( 'Add', 'pmf' ) ?>
                            </a>

                            <a href="#blue" class="panel__left__added__red" id="map_add_point_red">
                                <span>
                                    +
                                </span>
                                <?= __( 'Add', 'pmf' ) ?>
                            </a>

                            <a href="#blue" class="panel__left__added__info" id="map_add_point_info">
                                <div>
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 24C18.6274 24 24 18.6274 24 12C24 5.37258 18.6274 0 12 0C5.37258 0 0 5.37258 0 12C0 18.6274 5.37258 24 12 24Z" fill="#92DAD0"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12.5 15V11H10.5V12H11.5V15H10V16H14V15H12.5ZM12 8C11.5858 8 11.25 8.3358 11.25 8.75C11.25 9.1642 11.5858 9.5 12 9.5C12.4142 9.5 12.75 9.1642 12.75 8.75C12.75 8.3358 12.4142 8 12 8ZM12 19C8.134 19 5 15.866 5 12C5 8.134 8.134 5 12 5C15.866 5 19 8.134 19 12C19 13.8565 18.2625 15.637 16.9497 16.9497C15.637 18.2625 13.8565 19 12 19ZM12 6C8.6863 6 6 8.6863 6 12C6 15.3137 8.6863 18 12 18C15.3137 18 18 15.3137 18 12C18 8.6863 15.3137 6 12 6Z" fill="#233746"/>
                                    </svg>
                                </div>
                                <?= __( 'Add', 'pmf' ) ?>
                            </a>

                        </div>
                        <!-- End Btn -->

                    </div>
                    <!-- End Panel > Left -->

                    <!-- Panel > Right -->
                    <div class="panel__left column">
                        <a href="#save" class="btn btn-color mapSave" data-post="<?= get_the_ID() ?>" id="map_button_save_map" style="margin: 0">
                            <span class="dashicons dashicons-saved"></span>
                            <?= __( 'Save Map', 'pmf' ) ?>
                        </a>
                        <div class="mapSaveMessage"></div>
                    </div>
                    <!-- End Panel > Right -->

                </div>
                <!-- End Panel -->

                <!-- Container -->
                <div class="map__container">

                    <!-- Inner -->
                    <div class="map__container__inner">

                        <!-- Popper -->
                        <div class="map__popper" id="map__popper">

                            <span class="close" id="map__popper__close">x</span>

                            <input type="hidden" value="" id="map_point_selected">
                            <input type="hidden" value="" id="map_point_selected_real_id">

                            <!-- Title -->
                            <h3 class="map__popper__title">
                                <?= __( 'Settings Point', 'pmf' ) ?>
                            </h3>
                            <!-- End Title -->

                            <!-- Red Marker -->
                            <div class="map__popper__red">

                                <!-- row -->
                                <div class="map__popper__row">
                                    <label for="map_point_red_post">
                                        <?= __( 'Attach Page Detail', 'nec' ) ?>
                                    </label>
                                    <select class="map-js-select tourElementTourDetail" name="map_post" style="width:100%" id="map_point_red_post">
                                        <option value="0" selected="selected">
                                            <?= __( 'Select Post', 'nec' ) ?>
                                        </option>

                                        <?php
                                        $posts = get_posts( [
                                            'post_status'           => 'publish',
                                            'post_type'             => 'biographies',
                                            'posts_per_page'        => -1,
                                        ] );

                                        if( $posts ) :
                                            foreach( $posts as $pst ) :
                                                $title = ( mb_strlen( $pst->post_title ) > 50 ) ? mb_substr( $pst->post_title, 0, 49 ) . '...' : $pst->post_title;
                                                ?>
                                                <option value="<?= $pst->ID ?>">
                                                    <?= $title ?>
                                                </option>
                                            <?php
                                            endforeach;
                                        endif;
                                        ?>

                                    </select>

                                </div>
                                <!-- end row -->

                            </div>
                            <!-- End Red Marker -->

                            <!-- Info Marker -->
                            <div class="map__popper__info">

                                <!-- row -->
                                <div class="map__popper__row">
                                    <label for="map_point_red_post">
                                        <?= __( 'Attach Page Detail', 'nec' ) ?>
                                    </label>
                                    <select class="map-js-select tourElementTourDetail" name="map_post" style="width:100%" id="map_point_info_post">
                                        <option value="0" selected="selected">
                                            <?= __( 'Select Post', 'nec' ) ?>
                                        </option>

                                        <?php
                                        $posts = get_posts( [
                                            'post_status'           => 'publish',
                                            'post_type'             => 'memorial-info',
                                            'posts_per_page'        => -1,
                                        ] );

                                        if( $posts ) :
                                            foreach( $posts as $pst ) :
                                                $title = ( mb_strlen( $pst->post_title ) > 50 ) ? mb_substr( $pst->post_title, 0, 49 ) . '...' : $pst->post_title;
                                                ?>
                                                <option value="<?= $pst->ID ?>">
                                                    <?= $title ?>
                                                </option>
                                            <?php
                                            endforeach;
                                        endif;
                                        ?>

                                    </select>

                                </div>
                                <!-- end row -->

                            </div>
                            <!-- End Info Marker -->

                            <div class="map__popper__footer">
                                <button type="button" class="button btn-blue" id="map_point_remove">
                                    <?= __( 'Remove Point', 'pmf' ) ?>
                                </button>
                            </div>

                        </div>
                        <!-- End Popper -->

                        <!-- Map -->
                        <div class="map__container__canvas" id="map">

                        </div>
                        <!-- End Map -->
                    </div>
                    <!-- End Inner -->

                </div>
                <!-- End Container -->

            </div>
            <!-- Tour -->

        <?php

        endif;

    }

    /**
     * Upload Map
     * @since 1.0.0
     */
    public function upload_map_func() {

        /**
         * POST
         */
        $post           = absint($_POST['post']);
        $file_id        = absint($_POST['file_id']);
        $file           = get_attached_file( $file_id );
        $folder         = get_template_directory() . '/assets/map/images/tiles/' . $post . '/';
        $file_name      = $_POST['file_name'];

        if( $file_id ) :

            if (!file_exists($folder)) :
                mkdir($folder, 0777, true);
            endif;

            $zip = new ZipArchive;
            $res = $zip->open($file);

            if ($res === TRUE) :

                $zip->extractTo($folder);
                $zip->close();

                wp_delete_attachment($file_id);

                wp_send_json_success([
                    'html'      => '',
                    'message'   => __('Map has been successfully generated', 'pmf')
                ]);

            endif;

        else:

            /**
             * Send Json
             */
            wp_send_json_error([
                'html'      => '',
                'message'   => __( 'No Image Selected', 'pmf' )
            ]);

        endif;

        wp_die();

    }

    /**
     * Ajax
     * Map Save Json
     * @since 1.0.0
     */
    function map_save_func() {

        $json       = wp_unslash($_POST['map']);
        $post       = absint($_POST['post']);

        update_post_meta( $post, '_map_width', absint($_POST['width']) );
        update_post_meta( $post, '_map_height', absint($_POST['height']) );
        //update_post_meta( $post, '_map_json', $json );

        /**
         * Save Json Map
         */
        $dir = get_template_directory() . '/assets/map/images/tiles/' . $post . '/map.json';
        file_put_contents($dir, json_encode($json));

        /**
         * Post Meta by List Single
         * @update
         */
        if( $json['features'] ) :
            foreach ( $json['features'] as $item ) :
                $id_post = $item['data_post'];

                if( $item['data_post'] ) :
                    update_post_meta( $id_post, '_map_marker_id', $item['data_id_marker'] );
                endif;

            endforeach;
        endif;

        $html = '<div class="success">' .  __( 'Map saved successfully' ) . '</div>';

        wp_send_json_success( ['html' => $html ] );
        wp_die();

    }

    /**
     * Insert HTML Header Filter Frontend
     */
    public function filter_header_insert() {

        /**
         * Template
         */
        $template_file = get_post_meta(get_the_ID(), '_wp_page_template', TRUE);

        if( 'views/interactive-map-page.blade.php' == $template_file ) :
            ?>
            <!-- Mobile Button -->
            <button type="button" class="map__filters__button">
                <svg class="filter" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 18H7.5C6.67157 18 6 17.3284 6 16.5V10.8075L0.4425 5.25C0.160809 4.96999 0.00167459 4.58968 0 4.1925V1.5C0 0.671573 0.671573 0 1.5 0H16.5C17.3284 0 18 0.671573 18 1.5V4.1925C17.9983 4.58968 17.8392 4.96999 17.5575 5.25L12 10.8075V16.5C12 17.3284 11.3284 18 10.5 18ZM1.5 1.5V4.1925L7.5 10.1925V16.5H10.5V10.1925L16.5 4.1925V1.5H1.5Z" fill="#233746"/>
                </svg>
                <svg class="close" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1.05L10.95 0L6 4.95L1.05 0L0 1.05L4.95 6L0 10.95L1.05 12L6 7.05L10.95 12L12 10.95L7.05 6L12 1.05Z" fill="white"/>
                </svg>
            </button>
            <!-- End Mobile Button -->

            <!-- Filters -->
            <div class="map__filters">

                <!-- form -->
                <form class="map__filters__form">

                    <!-- form > checkbox -->
                    <div class="map__filters__form__checkbox" tabindex="0">
                        <input type="checkbox" id="filter-all" checked="checked" class="map__filters__form__checkbox__all" tabindex="-1">
                        <label for="filter-all">
                            <span><?= __( 'All', 'pmf' ) ?></span>
                        </label>
                    </div>
                    <!-- end form > checkbox -->

                    <!-- form > checkbox -->
                    <div class="map__filters__form__checkbox" tabindex="0">
                        <input type="checkbox" id="filter-marker-red" class="map__filters__form__checkbox__check" data-type="red" tabindex="-1">
                        <label for="filter-marker-red">
                            <svg class="line" width="25" height="32" viewBox="0 0 25 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.94241 0.10171L0.42006 2.61232C0.0371194 2.88527 -0.0903138 3.36329 0.13543 3.68L19.8124 31.2865C20.0382 31.6032 20.5316 31.6387 20.9146 31.3658L24.4369 28.8552C24.8199 28.5822 24.9473 28.1042 24.7215 27.7875L5.04453 0.180959C4.81879 -0.135756 4.32535 -0.171237 3.94241 0.10171Z" fill="#6D1F2E"/>
                            </svg>
                            <span><?= __( 'Flight 77 Benches', 'pmf' ) ?></span>
                        </label>
                    </div>
                    <!-- end form > checkbox -->

                    <!-- form > checkbox -->
                    <div class="map__filters__form__checkbox" tabindex="0">
                        <input type="checkbox" id="filter-marker-blue" class="map__filters__form__checkbox__check" data-type="blue" tabindex="-1">
                        <label for="filter-marker-blue">
                            <svg class="line" width="25" height="32" viewBox="0 0 25 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.94241 0.10171L0.42006 2.61232C0.0371194 2.88527 -0.0903138 3.36329 0.13543 3.68L19.8124 31.2865C20.0382 31.6032 20.5316 31.6387 20.9146 31.3658L24.4369 28.8552C24.8199 28.5822 24.9473 28.1042 24.7215 27.7875L5.04453 0.180959C4.81879 -0.135756 4.32535 -0.171237 3.94241 0.10171Z" fill="#233746"/>
                            </svg>
                            <span><?= __( 'Pentagon Benches', 'pmf' ) ?></span>
                        </label>
                    </div>
                    <!-- end form > checkbox -->

                    <!-- form > checkbox -->
                    <div class="map__filters__form__checkbox" tabindex="0">
                        <input type="checkbox" id="filter-marker-info" class="map__filters__form__checkbox__check" data-type="info" tabindex="-1">
                        <label for="filter-marker-info">
                            <svg class="round" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 24C18.6274 24 24 18.6274 24 12C24 5.37258 18.6274 0 12 0C5.37258 0 0 5.37258 0 12C0 18.6274 5.37258 24 12 24Z" fill="#92DAD0"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.5 15V11H10.5V12H11.5V15H10V16H14V15H12.5ZM12 8C11.5858 8 11.25 8.3358 11.25 8.75C11.25 9.1642 11.5858 9.5 12 9.5C12.4142 9.5 12.75 9.1642 12.75 8.75C12.75 8.3358 12.4142 8 12 8ZM12 19C8.134 19 5 15.866 5 12C5 8.134 8.134 5 12 5C15.866 5 19 8.134 19 12C19 13.8565 18.2625 15.637 16.9497 16.9497C15.637 18.2625 13.8565 19 12 19ZM12 6C8.6863 6 6 8.6863 6 12C6 15.3137 8.6863 18 12 18C15.3137 18 18 15.3137 18 12C18 8.6863 15.3137 6 12 6Z" fill="#233746"/>
                            </svg>
                            <span><?= __( 'Memorial Details', 'pmf' ) ?></span>
                        </label>
                    </div>
                    <!-- end form > checkbox -->

                </form>
                <!-- end form -->

            </div>
            <!-- End Filters -->

            <!-- Modal -->
            <div class="map__modal" role="alert" aria-live="assertive" aria-hidden="true">

                <!-- close -->
                <button class="map__modal__close">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1.05L10.95 0L6 4.95L1.05 0L0 1.05L4.95 6L0 10.95L1.05 12L6 7.05L10.95 12L12 10.95L7.05 6L12 1.05Z" fill="#233746"/>
                    </svg>
                </button>
                <!-- end close -->

                <!-- content -->
                <div class="map__modal__content mapDetailAjax">

                </div>
                <!-- end content -->

                <!-- nav -->
                <div class="map__modal__nav">

                    <a href="#prev" class="map__modal__nav__prev">
                        <div>
                            <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.5 0.5L8.5725 1.54475L2.8875 7.25H18V8.75H2.8875L8.5725 14.4298L7.5 15.5L0 8L7.5 0.5Z" fill="#233746"/>
                            </svg>
                        </div>
                        <span>Previous</span>
                    </a>
                    <a href="#next" class="map__modal__nav__next">
                        <span>Next</span>
                        <div>
                            <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 0.5L9.4275 1.54475L15.1125 7.25H0V8.75H15.1125L9.4275 14.4298L10.5 15.5L18 8L10.5 0.5Z" fill="#233746"/>
                            </svg>
                        </div>
                    </a>

                </div>
                <!-- end nav -->

            </div>
            <!-- End Modal -->

        <?php
        endif;
    }

    /**
     * Get Post Click Marker
     */
    public function map_get_post_func() {

        $post       = absint($_POST['post']);
        $html       = null;

        if( $post <> 0 ) :

            $args = array(
                'post_type' => ['biographies', 'memorial-info'],
                'post__in'  => [ $post ],
            );
            $query = new WP_Query( $args );
            $html = \App\template('partials/map-detail', ['query' => $query]);

        endif;
        wp_send_json_success([
            'html' => $html
        ]);
        wp_die();

    }


}
