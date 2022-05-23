<?php


namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Query;
use function App\asset_path;
use function App\debug;
global $posts;
class Search extends Controller
{

    public function __construct(){
        //add_action( 'wp_enqueue_scripts', array( &$this, 'filterScripts' ) );


        add_action('wp_ajax_nopriv_loadmore', array(&$this, 'search_loadmore'));
        add_action('wp_ajax_loadmore', array(&$this, 'search_loadmore'));



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
     * @return array|false
     */
    public function search_loadmore($args = []) {

        /**
         * Ajax
         *
         * Данная секция кода выполняется при условии что это Ajax запрос
         * в противном случае она игнорируется
         *
         */
        if( wp_doing_ajax() ) :
            //var_dump($_POST);
            /**
             * Type
             */

            $defaults = [
                'posts_per_page' => 10,
                'post_status'    => 'publish',
                'no_found_rows' => true,
                //'post_type' => get_post_types( array( 'public' => true ) ),
                's' => sanitize_text_field($_POST['search'] ),
                'paged' => $_POST['page']
            ];

            $args = wp_parse_args( $args, $defaults );

            $search = query_posts($args);
            //var_dump($args);
            if( have_posts() ) :

                // run the loop
                while( have_posts() ): the_post();
                    ?>
                    <div class="search-page__item">
                        <a href=" <?= get_permalink() ?> " class="search-page__item__inner">
                            <h4> <?= get_the_title() ?></h4>
                            <?= get_the_excerpt() ?>

                        </a>
                    </div>
                     <?php


                endwhile;
            else :
                echo '<div class="no-results">No posts found</div>';
            endif;
            die;

        endif;

    }



}
