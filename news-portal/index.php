<?php
/**
 * Main template file
 *
 * @package News_Portal
 */

get_header(); ?>

<main id="primary" class="site-main">
  <div class="content-grid">
    <div>
      <?php if (have_posts()) : ?>
        <?php if (is_home() && !is_front_page()) : ?>
          <header>
            <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
          </header>
        <?php endif; ?>

        <?php while (have_posts()) : the_post(); ?>
          <?php get_template_part('template-parts/content', 'card'); ?>
        <?php endwhile; ?>

        <nav class="pagination" aria-label="<?php esc_attr_e('Posts', 'news-portal'); ?>">
          <?php echo paginate_links(); ?>
        </nav>

      <?php else : ?>
        <?php get_template_part('template-parts/content', 'none'); ?>
      <?php endif; ?>
    </div>

    <?php get_sidebar(); ?>
  </div>
</main>

<?php get_footer();
