<?php


namespace App\Controllers;

use Sober\Controller\Controller;
use WP_Query;
use function App\asset_path;
use function App\debug;
global $posts;
class BiographiesPage extends Controller
{

    public function __construct(){
        //add_action( 'wp_enqueue_scripts', array( &$this, 'filterScripts' ) );


        add_action('wp_ajax_nopriv_taxonomyFilter', array(&$this, 'taxonomyFilter'));
        add_action('wp_ajax_taxonomyFilter', array(&$this, 'taxonomyFilter'));

        add_action('wp_ajax_nopriv_infiniteScroll', array(&$this, 'taxonomyFilter'));
        add_action('wp_ajax_infiniteScroll', array(&$this, 'taxonomyFilter'));
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
     * Get Categories
     * @param array $args
     * @return mixed
     */
    public function getCategories($args = [])
    {

        $defaults = [
            'taxonomy'     => 'locations',
            'type'         => 'post',
            'child_of'     => 0,
            'parent'       => '',
            'orderby'      => 'name',
            'order'        => 'ASC',
            'hide_empty'   => 1,
            'hierarchical' => 1,
            'exclude'      => '',
            'include'      => '',
            'number'       => 0,
            'pad_counts'   => false,
        ];

        $args = wp_parse_args( $args, $defaults );

        $categories = get_categories( $args );

        return $categories;
    }

    /**
     * Get Heroes Cards
     * @param array $args
     * @return mixed
     */
    public function get_heroes()
    {

        global $wp_query;

        $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

        $args = [
            'posts_per_page' => 20,
            'orderby'        => 'meta_value',
            'meta_key'         => 'biography_surname',
            'order'          => 'ASC',
            'post_type'   => 'biographies',
            'paged' => $paged
        ];
        $heroes_loop = new WP_Query($args);
        if($heroes_loop->have_posts()) :



                while($heroes_loop->have_posts()):
                    $heroes = $heroes_loop->posts;

                    return  array_map(function ($post) {
                        return [
                            'post_title' => apply_filters('the_title', $post->post_title),
                            'post_thumbnail_id' => get_post_thumbnail_id( $post->ID ),
                            'post_permalink' => get_permalink($post),
                            'post_birth_year' => substr(get_field( 'biography_date_of_birth',$post ), -4) ,


                        ];
                    }, $heroes);
                endwhile;








        endif;
        return [];
        wp_reset_postdata();
    }



    /**
     * @return array|false
     */
    public function taxonomyFilter($args = []) {

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
            //$type = sanitize_text_field($_POST['type']);
            //$paged =  get_query_var('paged')  ? get_query_var('paged') : 1;
            //$current_paged =

            $defaults = [
                'posts_per_page' => 20,
                'orderby'        => 'meta_value',
                'meta_key'         => 'biography_surname',
                'order'          => 'ASC',
                'post_status'    => 'publish',
                'post_type'      => 'biographies',
                'paged' => $_POST['paged']
            ];

            $args = wp_parse_args( $args, $defaults );

            /**
             * Search Input
             */
            //if( 'search' == $type ) :

                //$html = '<div class="empty">' . __( 'Not Found' ) . '</div>';
                /**
                 * Get Ids Category
                 */
                if( isset( $_POST['sort'] )&& ($_POST)['sort'][0]=='youngest'){
                    $args['orderby'] = 'meta_value_num';
                    $args['meta_key'] = 'biography_date_of_birth';
                    $args['order'] = 'DESC';

                }
                if( isset( $_POST['sort'] )&& ($_POST)['sort'][0]=='oldest'){
                    $args['orderby'] = 'meta_value_num';
                    $args['meta_key'] = 'biography_date_of_birth';
                    $args['order'] = 'ASC';
                }
                if( isset( $_POST['sort'] )&& ($_POST)['sort'][0]=='desc'){
                    $args['orderby'] = 'meta_value';
                    $args['meta_key'] = 'biography_surname';
                    $args['order'] = 'DESC';
                }
                if( isset( $_POST['sort'] )&& ($_POST)['sort'][0]=='asc'){
                    $args['orderby'] = 'meta_value';
                    $args['meta_key'] = 'biography_surname';
                    $args['order'] = 'ASC';
                }

                if( isset( $_POST['heroes'] )&& ($_POST['heroes'][0]!=='all')  ):

                    $args['post_type'] = 'biographies';

                    $args['tax_query'] = [
                        [
                            'taxonomy' => 'locations',
                            'field'    => 'slug',
                            'terms'    => $_POST['heroes'],
                        ]
                    ];
                endif;
                if (isset( $_POST['heroes'] )&& ($_POST['heroes'][0]==='all')):
                    $args['post_type'] = 'biographies';

                endif;
                if (isset( $_POST['search'] )&& !empty($_POST['search'])):
                    $args['meta_query'] = [
                            'relation' => 'OR',
                            [
                                'key' => 'biography_name',
                                'value' => $_POST['search'],
                                'compare' => 'LIKE'
                            ],
                            [
                                'key'=> 'biography_surname',
                                'value' => $_POST['search'],
                                'compare' => 'LIKE'
                            ]
                        ];

                    /*
                    //----рабочий вариант---//

                    global $wpdb;

                    // If you use a custom search form
                    // $keyword = sanitize_text_field( $_POST['keyword'] );

                    // If you use default WordPress search form
                                        $keyword = sanitize_text_field( $_POST['search'] );
                                        $keyword = '%' . $wpdb->esc_like( $keyword ) . '%';

                    // Search in all custom fields
                                        $post_ids_meta = $wpdb->get_col( $wpdb->prepare( "
                        SELECT DISTINCT post_id FROM {$wpdb->postmeta}
                        WHERE meta_value LIKE '%s'
                    ", $keyword ) );

                    // Search in post_title and post_content
                                        $post_ids_post = $wpdb->get_col( $wpdb->prepare( "
                        SELECT DISTINCT ID FROM {$wpdb->posts}
                        WHERE post_title LIKE '%s'
                        OR post_content LIKE '%s'
                    ", $keyword, $keyword ) );

                    $post_ids = array_merge( $post_ids_meta, $post_ids_post );

                    // Query arguments
                    if (!empty ($post_ids)){
                        $args['post__in'] = $post_ids;
                    } else{
                        $args['s'] = sanitize_text_field($_POST['search']);
                    }
                    */

                endif;
                    $query = new WP_Query($args);

            //_e('<pre>' . var_dump($args). '</pre>');
            if( $query->have_posts() ) :
                $max_num_pages = $query->max_num_pages;
                echo '<div id="max-pages" data-maxpages="'.$max_num_pages.'"></div>';
                while( $query->have_posts() ): $query->the_post(); ?>


                    <!-- Col -->
                        <div class="heroes-list__list__col fade-deactive">

                        <!-- item -->
                        <a href=" <?= get_permalink(); ?> " class="heroes__list__item">

                          <div class="heroes__list__item__text">
                            <small><?= birth_year(); ?></small>
                            <h5 class="title"><?= the_title(); ?></h5>
                          </div>
                                        <? if( has_post_thumbnail() ): ?>
                          <!-- Image -->
                            <!--
                            <img
                              src="<?= wp_get_attachment_url(get_post_thumbnail_id( $post->ID ) ) ?>"
                              alt="<?= get_the_title(); ?> - photo"
                              title="<?= get_the_title() ?>"
                            >-->
                            <div class="heroes__list__item__image" style = "background-image: url(<?= wp_get_attachment_url(get_post_thumbnail_id( $post->ID ) ) ?>)"></div>

                            <!-- End Image -->
                                        <? endif; ?>


                        </a>
                        <!-- end item -->

                      </div>
                      <!-- End Col2 -->
               <?php endwhile;
                wp_reset_postdata();
            else :
                echo '<div class="no-results">No posts found</div>';
            endif;

            die();

        endif;

    }



}
