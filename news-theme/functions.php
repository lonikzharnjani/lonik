<?php
// Theme setup
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
});

// Enqueue assets
add_action('wp_enqueue_scripts', function () {
    $theme_version = wp_get_theme()->get('Version');
    wp_enqueue_style('news-theme-style', get_stylesheet_uri(), [], $theme_version);
    wp_enqueue_style('news-slider-style', get_stylesheet_directory_uri() . '/assets/css/slider.css', [], $theme_version);
    wp_enqueue_script('news-slider-script', get_stylesheet_directory_uri() . '/assets/js/slider.js', ['jquery'], $theme_version, true);
});

// Register 'news' custom post type
add_action('init', function () {
    $labels = [
        'name'               => 'News',
        'singular_name'      => 'News',
        'menu_name'          => 'News',
        'name_admin_bar'     => 'News',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New News',
        'new_item'           => 'New News',
        'edit_item'          => 'Edit News',
        'view_item'          => 'View News',
        'all_items'          => 'All News',
        'search_items'       => 'Search News',
        'not_found'          => 'No news found',
        'not_found_in_trash' => 'No news found in Trash',
    ];

    register_post_type('news', [
        'labels'        => $labels,
        'description'   => 'News posts',
        'public'        => true,
        'has_archive'   => true,
        'rewrite'       => ['slug' => 'news'],
        'show_in_rest'  => true,
        'menu_position' => 5,
        'supports'      => [
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'comments',
            'revisions',
            'custom-fields',
        ],
    ]);
});

// Register hierarchical taxonomy: news_genres for news
add_action('init', function () {
    $labels = [
        'name'              => 'News Genres',
        'singular_name'     => 'News Genre',
        'search_items'      => 'Search News Genres',
        'all_items'         => 'All News Genres',
        'parent_item'       => 'Parent News Genre',
        'parent_item_colon' => 'Parent News Genre:',
        'edit_item'         => 'Edit News Genre',
        'update_item'       => 'Update News Genre',
        'add_new_item'      => 'Add New News Genre',
        'new_item_name'     => 'New News Genre Name',
        'menu_name'         => 'News Genres',
    ];

    $args = [
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => ['slug' => 'news-genre'],
        'show_in_rest'      => true,
    ];

    register_taxonomy('news_genres', ['news'], $args);
});

// Register non-hierarchical taxonomy: news_tags for news
add_action('init', function () {
    $labels = [
        'name'                       => 'News Tags',
        'singular_name'              => 'News Tag',
        'search_items'               => 'Search News Tags',
        'popular_items'              => 'Popular News Tags',
        'all_items'                  => 'All News Tags',
        'edit_item'                  => 'Edit News Tag',
        'update_item'                => 'Update News Tag',
        'add_new_item'               => 'Add New News Tag',
        'new_item_name'              => 'New News Tag Name',
        'separate_items_with_commas' => 'Separate tags with commas',
        'add_or_remove_items'        => 'Add or remove tags',
        'choose_from_most_used'      => 'Choose from the most used tags',
        'not_found'                  => 'No tags found',
        'menu_name'                  => 'News Tags',
    ];

    $args = [
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => ['slug' => 'news-tag'],
        'show_in_rest'          => true,
    ];

    register_taxonomy('news_tags', ['news'], $args);
});

// Shortcode to render the slider
add_shortcode('news_slider', function ($atts) {
    $atts = shortcode_atts([
        'count' => 5,
        'category' => '',
    ], $atts, 'news_slider');

    $query_args = [
        'post_type' => 'news',
        'posts_per_page' => intval($atts['count']),
        'post_status' => 'publish',
    ];

    if (!empty($atts['category'])) {
        $query_args['tax_query'] = [[
            'taxonomy' => 'news_genres',
            'field'    => 'slug',
            'terms'    => array_map('sanitize_title', explode(',', $atts['category'])),
        ]];
    }

    $q = new WP_Query($query_args);

    if (!$q->have_posts()) {
        return '';
    }

    ob_start();
    ?>
    <div class="news-slider" data-autoplay="true">
        <div class="news-slider-track">
            <?php while ($q->have_posts()) : $q->the_post(); ?>
                <article class="news-slide">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail('large');
                        } else {
                            echo '<img src="' . esc_url(get_stylesheet_directory_uri() . '/assets/img/placeholder.jpg') . '" alt="">';
                        } ?>
                        <div class="caption">
                            <h3><?php the_title(); ?></h3>
                            <p><?php echo esc_html(get_the_excerpt()); ?></p>
                        </div>
                    </a>
                </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
        <button class="nav prev" aria-label="Previous">‹</button>
        <button class="nav next" aria-label="Next">›</button>
        <div class="news-dots" aria-hidden="true"></div>
    </div>
    <?php
    return ob_get_clean();
});
