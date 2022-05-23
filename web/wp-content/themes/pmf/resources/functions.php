<?php

/**
 * Do not edit anything in this file unless you know what you're doing
 */

use Roots\Sage\Config;
use Roots\Sage\Container;

/**
 * Helper function for prettying up errors
 *
 * @param  string  $message
 * @param  string  $subtitle
 * @param  string  $title
 */
$sage_error = function ($message, $subtitle = '', $title = '') {
    $title   = $title ?: __('Sage &rsaquo; Error', 'pmf');
    $footer  = '<a href="https://roots.io/sage/docs/">roots.io/sage/docs/</a>';
    $message = "<h1>{$title}<br><small>{$subtitle}</small></h1><p>{$message}</p><p>{$footer}</p>";
    wp_die($message, $title);
};

/**
 * Ensure compatible version of PHP is used
 */
if (version_compare('7.1', phpversion(), '>=')) {
    $sage_error(__('You must be using PHP 7.1 or greater.', 'pmf'), __('Invalid PHP version', 'pmf'));
}

/**
 * Ensure compatible version of WordPress is used
 */
if (version_compare('4.7.0', get_bloginfo('version'), '>=')) {
    $sage_error(__('You must be using WordPress 4.7.0 or greater.', 'pmf'), __('Invalid WordPress version', 'pmf'));
}

/**
 * Ensure dependencies are loaded
 */
if ( ! class_exists('Roots\\Sage\\Container')) {
    if ( ! file_exists($composer = __DIR__ . '/../vendor/autoload.php')) {
        $sage_error(
            __('You must run <code>composer install</code> from the Sage directory.', 'pmf'),
            __('Autoloader not found.', 'pmf')
        );
    }
    require_once $composer;
}

/**
 * Sage required files
 *
 * The mapped array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */
array_map(function ($file) use ($sage_error) {
    $file = "../app/{$file}.php";
    if ( ! locate_template($file, true, true)) {
        $sage_error(sprintf(__('Error locating <code>%s</code> for inclusion.', 'pmf'), $file), 'File not found');
    }
}, ['helpers', 'setup', 'filters', 'admin']);

/**
 * Here's what's happening with these hooks:
 * 1. WordPress initially detects theme in themes/sage/resources
 * 2. Upon activation, we tell WordPress that the theme is actually in themes/sage/resources/views
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/sage/resources
 *
 * We do this so that the Template Hierarchy will look in themes/sage/resources/views for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/sage/resources
 *
 * This is not compatible with the WordPress Customizer theme preview prior to theme activation
 *
 * get_template_directory()   -> /srv/www/example.com/current/web/app/themes/sage/resources
 * get_stylesheet_directory() -> /srv/www/example.com/current/web/app/themes/sage/resources
 * locate_template()
 * ├── STYLESHEETPATH         -> /srv/www/example.com/current/web/app/themes/sage/resources/views
 * └── TEMPLATEPATH           -> /srv/www/example.com/current/web/app/themes/sage/resources
 */
array_map(
    'add_filter',
    ['theme_file_path', 'theme_file_uri', 'parent_theme_file_path', 'parent_theme_file_uri'],
    array_fill(0, 4, 'dirname')
);
Container::getInstance()
         ->bindIf('config', function () {
             return new Config([
                 'assets' => require dirname(__DIR__) . '/config/assets.php',
                 'theme'  => require dirname(__DIR__) . '/config/theme.php',
                 'view'   => require dirname(__DIR__) . '/config/view.php',
             ]);
         }, true);

/**
 * @init
 * @cptui_register_my_taxes
 */
add_action('init', 'cptui_register_my_taxes');
function cptui_register_my_taxes()
{
    /**
     * Taxonomy: Categories.
     */

    $labels = [
        "name"          => __("Locations", "pmf"),
        "singular_name" => __("Location", "pmf"),
    ];

    $args = [
        "label"                 => __("Location", "nec"),
        "labels"                => $labels,
        "public"                => true,
        "publicly_queryable"    => true,
        "hierarchical"          => true,
        "show_ui"               => true,
        "show_in_menu"          => true,
        "show_in_nav_menus"     => true,
        "query_var"             => true,
        "rewrite"               => ['slug' => 'location', 'with_front' => true,],
        "show_admin_column"     => true,
        "show_in_rest"          => true,
        "rest_base"             => "location",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "show_in_quick_edit"    => false,
    ];
    register_taxonomy("locations", ["biographies"], $args);
}

/**
 * @init
 * @cptui_register_my_cpts
 */
add_action('init', 'cptui_register_my_cpts');
function cptui_register_my_cpts()
{
    /**
     * Post Type: Biographies.
     */

    $labels = [
        "name" => __("Biographies", "pmf"),
        "singular_name" => __("Biography", "pmf"),
        "add_new_item" => __("Add Biography", "pmf"),
        "edit_item" => __("Edit Biography", "pmf"),
        "new_item" => __("New Biography", "pmf"),
        "view_item" => __("View Biography", "pmf"),
        "search_items" => __("Search Biographies", "pmf"),
    ];

    $args = [
        "label" => __("Biographies", "pmf"),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "rewrite" => ["slug" => "biographies", "with_front" => true],
        "query_var" => true,
        "menu_icon" => "dashicons-businessperson",
        "supports" => ["title", "editor", "thumbnail", "excerpt"],
        "taxonomies" => ["locations"],
    ];

    register_post_type("biographies", $args);
    /**
     * Post Type: Timeline.
     */

    $tl_labels = [
        "name" => __("Timeline", "pmf"),
        "singular_name" => __("Timeline Card", "pmf"),
        "add_new_item" => __("Add Timeline Card", "pmf"),
        "edit_item" => __("Edit Timeline Card", "pmf"),
        "new_item" => __("New Timeline Card", "pmf"),
        "view_item" => __("View Timeline Card", "pmf"),
        "search_items" => __("Search Timeline Card", "pmf"),
    ];

    $tl_args = [
        "label" => __("Timeline", "pmf"),
        "labels" => $tl_labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => true,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "query_var" => true,
        "menu_icon" => "dashicons-text",
        "supports" => ["title", "thumbnail"],

    ];

    register_post_type("timeline", $tl_args);
    /**
     * Post Type: Pentagon Renovation".
     */

    $pr_labels = [
        "name" => __("Pentagon Renovation", "pmf"),
        "singular_name" => __("Timeline Card", "pmf"),
        "add_new_item" => __("Add Timeline Card", "pmf"),
        "edit_item" => __("Edit Timeline Card", "pmf"),
        "new_item" => __("New Timeline Card", "pmf"),
        "view_item" => __("View Timeline Card", "pmf"),
        "search_items" => __("Search Timeline Card", "pmf"),
    ];

    $pr_args = [
        "label" => __("Pentagon Renovation", "pmf"),
        "labels" => $pr_labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => true,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "query_var" => true,
        "menu_icon" => "dashicons-text",
        "supports" => ["title", "thumbnail"],

    ];

    register_post_type("pentagon-renovation", $pr_args);

    /**
     * Post Type: Memorial Construction"
     */

    $mc_labels = [
        "name" => __("Memorial Construction", "pmf"),
        "singular_name" => __("Timeline Card", "pmf"),
        "add_new_item" => __("Add Timeline Card", "pmf"),
        "edit_item" => __("Edit Timeline Card", "pmf"),
        "new_item" => __("New Timeline Card", "pmf"),
        "view_item" => __("View Timeline Card", "pmf"),
        "search_items" => __("Search Timeline Card", "pmf"),
    ];

    $mc_args = [
        "label" => __("Memorial Construction", "pmf"),
        "labels" => $mc_labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => true,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => true,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "query_var" => true,
        "menu_icon" => "dashicons-text",
        "supports" => ["title", "thumbnail"],

    ];

    register_post_type("memorial-const", $mc_args);

    /**
     * Labels
     */
    $labels = [
        "name" => __("Memorial Info", "pmf"),
        "singular_name"         => __("Memorial Info", "pmf"),
        "add_new_item"          => __("Add Memorial Info", "pmf"),
        "edit_item"             => __("Edit Memorial Info", "pmf"),
        "new_item"              => __("New Memorial Info", "pmf"),
        "view_item"             => __("View Memorial Info", "pmf"),
        "search_items"          => __("Search Memorial Info", "pmf"),
    ];

    /**
     * Args
     */
    $args = [
        "label"                 => __("Memorial Info", "pmf"),
        "labels"                => $labels,
        "description"           => "",
        "public"                => true,
        "publicly_queryable"    => true,
        "show_ui"               => true,
        "show_in_rest"          => true,
        "rest_base"             => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "has_archive"           => false,
        "show_in_menu"          => true,
        "show_in_nav_menus"     => true,
        "delete_with_user"      => false,
        "exclude_from_search"   => true,
        "capability_type"       => "post",
        "map_meta_cap"          => true,
        "hierarchical"          => false,
        "query_var"             => true,
        "menu_icon"             => "dashicons-text",
        "supports"              => ["title", "thumbnail"],
    ];

    register_post_type("memorial-info", $args);

}

// output birth date
function birth_date(){
    $birth_date = get_field( 'biography_date_of_birth', get_the_ID() );
    $unknown_date = get_field( 'exact_date_of_birth_is_unknown', get_the_ID() );
    if ($unknown_date){
        $output = new DateTime($birth_date);
        $output = $output->format('Y');
        //var_dump($birth_date);
    }else{
        $output = $birth_date;
    }
    return $output;
}
function birth_year(){
    $birth_date = get_field( 'biography_date_of_birth', get_the_ID() );
    $output = new DateTime($birth_date);
    $output = $output->format('Y');
    return $output;
    }
function calculateAge() {
    if(get_field('biography_date_of_birth')) {
        $birth = new DateTime(get_field('biography_date_of_birth'));
        $death = new DateTime('11.09.2001');
        $age = $death->diff($birth);
        $age = $age->format('%Y');


    }
    return $age;
}
function get_name(){
    $full_name = explode(" ",get_the_title());

    preg_match("/[\d]+/", $full_name[0],$match);


    if(strlen($full_name[0]) > 3 && empty($match) && !ctype_upper($full_name[0])) {
        $first_name = $full_name[0];
    }
    else {
        $first_name = $full_name[1];
    }
    return $first_name."'s";

}
/**
 * Extend WordPress search to include custom fields
 *
 * https://adambalee.com
 */

/**
 * Join posts and postmeta tables
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_join
 */

function cf_search_join( $join ) {
    global $wpdb;
    if ( is_search() ) {
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    return $join;
}
add_filter('posts_join', 'cf_search_join' );

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */

function cf_search_where( $where ) {
    global $pagenow, $wpdb;
    if ( is_search() ) {
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
    }
    return $where;
}
add_filter('posts_where', 'cf_search_where');

/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */

function cf_search_distinct( $where ) {
    global $wpdb;
    if ( is_search() ) {
        return "DISTINCT";
    }
    return $where;
}
add_filter('posts_distinct', 'cf_search_distinct');



add_action( 'init', 'update_my_custom_type', 99 );

function update_my_custom_type() {
    global $wp_post_types;

    if ( post_type_exists( 'staticcontent' ) ) {

        // exclude from search results
        $wp_post_types['staticcontent']->exclude_from_search = true;
    }
}

/**
 * Header search form
 */
add_filter( 'get_search_form', 'header_search_form' );
function header_search_form( $form ) {

    $form = '
	<form role="search" method="get" id="searchform" class="header__searchbox__form" action="' . home_url( '/' ) . '" >
		<input type="text" class="form-control" value="' . get_search_query() . '" name="s" id="s" placeholder="Search" />
		<input type="submit" id="searchsubmit" class="header__btngroup__search" value=" " />
	</form>';

    return $form;
}
/**
 * Custom breadcrumbps
 */
function custom_breadcrumbps(){

    $menu_items = wp_get_nav_menu_items('Header Navigation');
    $breadcrumbps_elements = [];
    $post_id = get_the_ID();
    $parent_item_id = wp_filter_object_list( $menu_items, array( 'object_id' => $post_id ), 'and', 'menu_item_parent' );
    $current_items_array = [];
    if ( ! empty( $parent_item_id ) ) {
        $parent_item_id = array_shift( $parent_item_id );
        foreach ( $menu_items as $navItem ) {
            if ($navItem->ID == $parent_item_id ) {
                $topParentTitle = $navItem->title;
            }
            if($navItem->menu_item_parent == $parent_item_id /*&& $navItem->object_id !== strval($post_id)*/ ){
                $this_array = [];
                $this_array['title'] = $navItem->title;
                $this_array['url'] = $navItem->url;
                $this_array['id'] = $navItem->object_id;
                if($navItem->object_id === strval($post_id)) {
                    $this_array['classes'] = 'active';
                } else {
                    $this_array['classes'] = '';
                }
                $current_items_array[] = $this_array;
            }
        }

        $breadcrumbps_elements['parent'] = $topParentTitle;
        $breadcrumbps_elements['elements'] = $current_items_array;
    }
    $current_level_items = wp_filter_object_list( $menu_items, array( 'object_id' => $post_id ), 'and', 'menu_item_parent' );
    //$breadcrumbps_elements['parent']
    return $breadcrumbps_elements;

}

/**
 * Set cookie for notifications bar
 */
/*function notifications_set_cookies() {

    if( !isset( $_COOKIE['notifications_read'] ) ) {
        //установка куки на 1 год
        //setcookie( 'notifications_read', true, time()+31556926, '/' );
        return true;
    }else {
        return false;
    }
}*/
//add_action( 'init', 'notifications_set_cookies' );


/**
 * Add 'is-mobile' body class
 */
function mobile_body_class( $classes ) {
    if ( wp_is_mobile() ) {
        $classes[] = 'is-mobile';
    }
    return $classes;
}
//add_filter( 'body_class', 'mobile_body_class' );
