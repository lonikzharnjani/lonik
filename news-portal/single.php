<?php
/**
 * The template for displaying all single posts
 *
 * @package News_Portal
 */
get_header(); ?>

<main id="primary" class="site-main">
  <div class="content-grid">
    <div>
      <?php
      while (have_posts()) : the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <header class="entry-header">
            <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
            <div class="post-meta">
              <span class="byline"><?php echo esc_html(get_the_author()); ?></span>
              <span class="sep"> · </span>
              <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
            </div>
          </header>

          <?php if (has_post_thumbnail()) : ?>
            <div class="post-thumb">
              <?php the_post_thumbnail('news-featured'); ?>
            </div>
          <?php endif; ?>

          <div class="entry-content">
            <?php the_content(); ?>
            <?php
            wp_link_pages([
              'before' => '<div class="page-links">' . esc_html__('Pages:', 'news-portal'),
              'after'  => '</div>',
            ]);
            ?>
          </div>

          <footer class="entry-footer">
            <?php the_tags('<span class="tags-links">', ' ', '</span>'); ?>
          </footer>
        </article>

        <?php comments_template(); ?>
        <?php
      endwhile;
      ?>
    </div>

    <?php get_sidebar(); ?>
  </div>
</main>

<?php get_footer(); ?>
