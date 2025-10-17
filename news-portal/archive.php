<?php
/**
 * The template for displaying archive pages
 *
 * @package News_Portal
 */
get_header(); ?>

<main id="primary" class="site-main">
  <header class="page-header">
    <div class="container">
      <?php
      the_archive_title('<h1 class="page-title">', '</h1>');
      the_archive_description('<div class="archive-description">', '</div>');
      ?>
    </div>
  </header>

  <div class="container">
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
