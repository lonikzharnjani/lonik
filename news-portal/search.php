<?php
/**
 * The template for displaying search results pages
 *
 * @package News_Portal
 */
get_header(); ?>

<main id="primary" class="site-main">
  <div class="container">
    <header class="page-header">
      <h1 class="page-title"><?php printf(esc_html__('Search Results for: %s', 'news-portal'), '<span>' . get_search_query() . '</span>'); ?></h1>
    </header>

    <div class="content-grid">
      <div>
        <?php if (have_posts()) : ?>
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
  </div>
</main>

<?php get_footer(); ?>
