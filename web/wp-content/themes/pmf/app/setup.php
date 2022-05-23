<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    wp_dequeue_script('jquery');
    wp_dequeue_script('jquery-core');
    wp_dequeue_script('jquery-migrate');
    wp_enqueue_script('jquery', false, array(), false, true);
    wp_enqueue_script('jquery-core', false, array(), false, true);
    wp_enqueue_script('jquery-migrate', false, array(), false, true);

    /**
     * Fonts
     */
    wp_enqueue_style('font-app', 'https://use.typekit.net/bwn2kcp.css?display=swap', false, null);
    wp_enqueue_style('font-inter', 'https://fonts.googleapis.com/css2?family=Inter:wght@500&display=swap', false, null);

    /**
     * Sage Css
     */
    wp_enqueue_style('sage/main.css', asset_path('styles/main.css'), false, null);

    /**
     * Js
     */
    wp_enqueue_script('sage/main.js', asset_path('scripts/main.js'), ['jquery'], null, true);

    wp_localize_script('sage/main.js', 'pmf', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }



}, 100);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil-clean-up');
    add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'pmf'),
        'header_menu'        => __('Header Navigation', 'pmf'),
        'footer_about_menu'  => __('Footer Navigation About', 'pmf'),
        'footer_social_menu' => __('Footer Navigation Social', 'pmf'),
        'footer_bottom_menu' => __('Footer Navigation Bottom', 'pmf'),
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable post excerpts (use for search result)
     */
    add_post_type_support( 'page', 'excerpt' );


    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));
}, 20);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
                         'name' => __('Primary', 'pmf'),
                         'id'   => 'sidebar-primary'
                     ] + $config);
    register_sidebar([
                         'name' => __('Footer', 'pmf'),
                         'id'   => 'sidebar-footer'
                     ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if ( ! file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();

        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });
});

/**
 * Remove emoji
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/**
 * Remove feed links
 */
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link', 10);
remove_action('wp_head', 'start_post_rel_link', 10);
remove_action('wp_head', 'adjacent_posts_rel_link', 10);
remove_action('wp_head', 'wp_generator');

/**
 * Theme Settings page
 */
if (function_exists('acf_add_options_page')) {
    $parent = acf_add_options_page(
        [
            'page_title' => 'Theme General Settings',
            'menu_title' => 'Theme Settings',
            'menu_slug'  => 'theme-general-settings',
            'capability' => 'edit_posts',
            'redirect'   => false
        ]
    );
}

/**
 * hide admin bar
 */
show_admin_bar(false);
/**
 * Image sizes
 */
if ( function_exists( 'add_image_size' ) ) {
    add_image_size( '92x92', 92, 92, array('center','center') );
    add_image_size( '280x280', 280, 280, array('center','center') );
    add_image_size( '282x376', 282, 376, true );
    add_image_size( '486x376', 486, 376, true );
    add_image_size( '288x288', 288, 288, array('center','center') );
    add_image_size( '300x180', 300, 180, array('center','center') );
    add_image_size( '300x300', 300, 300, array('center','center') );
    add_image_size( '300x400', 300, 400, true );
    add_image_size( '500x399', 500, 399, true );
    add_image_size( '400x280', 400, 280, array('center','center') );
    add_image_size( '490x650', 490, 650, true );
    add_image_size( '800x600', 800, 600, true );
    add_image_size( 'h315', 9999999, 315 );
    add_image_size( 'h530', 9999999, 530 );
    add_image_size( 'h640', 9999999, 640 );
    add_image_size( 'w460', 460, 9999999 );
    add_image_size( '465x350', 465, 350, true );
    add_image_size( '270x360', 270, 360, true );
}
