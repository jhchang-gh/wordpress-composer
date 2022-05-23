<?php
namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Query;


class TimelinePage extends Controller {


    /**
     * Timeline constructor.
     * @since 1.0.0
     * @__construct
     */
    public function __construct(){

         /**
         * Ajax Action
         */
        add_action( 'wp_ajax_load_content', array(&$this, 'load_content_func') );
        add_action( 'wp_ajax_nopriv_load_content', array(&$this, 'load_content_func') );




    }
    /**
     * Build
     * @return $this
     */
    public function build()
    {
        return $this;
    }

    /**
     * @return array|false|string
     */
    public function fields()
    {
        if (function_exists('get_fields')) {
            return get_fields();
        } else {
            return 'ACF DISABLE';
        }
    }


    /**
     * Get Card Content
     */
    public function load_content_func() {
        if( wp_doing_ajax() ) :
            //var_dump($_POST);
            $post       = absint($_POST['post']);
            $html       = null;

            if( $post <> 0 ) :

                $args = array(
                    'post_type' => ['timeline', 'memorial-const', 'pentagon-renovation'],
                    'post__in'  => [ $post ],
                );
                $query = new WP_Query( $args );
                //var_dump($_POST);
                if( $query->have_posts() ):
                    while( $query->have_posts() ):
                        $query->the_post();
                        ob_start();
                            $html = \App\template('partials/timeline-card-content-ajax', ['query' => $query]);
                        ob_end_clean();
                        echo $html;

                    endwhile;
                    wp_reset_postdata();
                endif;
            endif;
            /*wp_send_json_success([
                'html' => $html
            ]);*/

            wp_die();
        endif;
    }


}
