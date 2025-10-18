<?php
/**
 * Front page template
 *
 * @package News_Portal
 */
get_header(); ?>

<main id="primary" class="site-main">
  <section class="featured-section">
    <div class="featured-grid">
      <div>
        <?php
        $hero = new WP_Query([
          'posts_per_page' => 1,
          'ignore_sticky_posts' => 1,
        ]);
        if ($hero->have_posts()) :
          while ($hero->have_posts()) : $hero->the_post();
            get_template_part('template-parts/content', 'featured-large');
          endwhile;
          wp_reset_postdata();
        endif;
        ?>
      </div>
      <div class="featured-small">
        <?php
        $side = new WP_Query([
          'posts_per_page' => 4,
          'offset' => 1,
          'ignore_sticky_posts' => 1,
        ]);
        if ($side->have_posts()) :
          while ($side->have_posts()) : $side->the_post();
            get_template_part('template-parts/content', 'featured-small');
          endwhile;
          wp_reset_postdata();
        endif;
        ?>
      </div>
    </div>
  </section>

  <section class="featured-section">
    <?php echo do_shortcode('[news_portal_slider posts="5" interval="5000"]'); ?>
  </section>

  <div class="content-grid">
    <div>
      <h2><?php esc_html_e('Latest', 'news-portal'); ?></h2>
      <?php
      $latest = new WP_Query([
        'posts_per_page' => 6,
        'ignore_sticky_posts' => 1,
      ]);
      if ($latest->have_posts()) :
        while ($latest->have_posts()) : $latest->the_post();
          get_template_part('template-parts/content', 'card');
        endwhile;
        wp_reset_postdata();
      else:
        get_template_part('template-parts/content', 'none');
      endif;
      ?>
    </div>
    <?php get_sidebar(); ?>
  </div>
</main>

<?php get_footer(); ?>
