<?php
/**
 * News Portal functions and definitions
 *
 * @package News_Portal
 */

if (!defined('NEWS_PORTAL_VERSION')) {
    $theme = wp_get_theme();
    define('NEWS_PORTAL_VERSION', $theme->get('Version'));
}

/**
 * Set the content width in pixels, based on the theme's design.
 */
function news_portal_content_width() {
    $GLOBALS['content_width'] = apply_filters('news_portal_content_width', 800);
}
add_action('after_setup_theme', 'news_portal_content_width', 0);

/**
 * Theme setup.
 */
function news_portal_setup() {
    // Make theme available for translation.
    load_theme_textdomain('news-portal', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title.
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support('post-thumbnails');

    // Custom logo support.
    add_theme_support('custom-logo', [
        'height' => 80,
        'width'  => 80,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    // HTML5 support
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    // Register menus
    register_nav_menus([
        'primary' => __('Primary Menu', 'news-portal'),
        'footer'  => __('Footer Menu', 'news-portal'),
    ]);

    // Image sizes
    add_image_size('news-card', 600, 400, true);
    add_image_size('news-featured', 1200, 675, true);
}
add_action('after_setup_theme', 'news_portal_setup');

/**
 * Register widget areas.
 */
function news_portal_widgets_init() {
    register_sidebar([
        'name'          => __('Primary Sidebar', 'news-portal'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'news-portal'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ]);

    for ($i = 1; $i <= 3; $i++) {
        register_sidebar([
            'name'          => sprintf(__('Footer %d', 'news-portal'), $i),
            'id'            => 'footer-' . $i,
            'description'   => __('Footer widget area.', 'news-portal'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title">',
            'after_title'   => '</h2>',
        ]);
    }
}
add_action('widgets_init', 'news_portal_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function news_portal_scripts() {
    wp_enqueue_style('news-portal-style', get_stylesheet_uri(), [], NEWS_PORTAL_VERSION);

    wp_enqueue_script('news-portal-main', get_template_directory_uri() . '/assets/js/main.js', [], NEWS_PORTAL_VERSION, true);
}
add_action('wp_enqueue_scripts', 'news_portal_scripts');

/**
 * Accessible submenu toggles for primary navigation.
 */
function news_portal_add_menu_aria($atts, $item, $args, $depth) {
    if (($args->theme_location ?? '') === 'primary' && in_array('menu-item-has-children', (array) ($item->classes ?? []), true)) {
        $atts['aria-haspopup'] = 'true';
        $atts['aria-expanded'] = 'false';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'news_portal_add_menu_aria', 10, 4);

function news_portal_append_submenu_toggle($item_output, $item, $depth, $args) {
    if (($args->theme_location ?? '') === 'primary' && in_array('menu-item-has-children', (array) ($item->classes ?? []), true)) {
        $button  = '<button class="submenu-toggle" aria-expanded="false" aria-label="' . esc_attr__('Toggle submenu', 'news-portal') . '">';
        $button .= '<span class="chevron" aria-hidden="true">▾</span>';
        $button .= '</button>';
        $item_output .= $button;
    }
    return $item_output;
}
add_filter('walker_nav_menu_start_el', 'news_portal_append_submenu_toggle', 10, 4);

