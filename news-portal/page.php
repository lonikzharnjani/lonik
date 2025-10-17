<?php
/**
 * The template for displaying all pages
 *
 * @package News_Portal
 */
get_header(); ?>

<main id="primary" class="site-main">
  <div class="container">
    <?php
    while (have_posts()) : the_post();
      ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
          <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
        </header>

        <div class="entry-content">
          <?php the_content(); ?>
          <?php
          wp_link_pages([
            'before' => '<div class="page-links">' . esc_html__('Pages:', 'news-portal'),
            'after'  => '</div>',
          ]);
          ?>
        </div>
      </article>
      <?php
      if (comments_open() || get_comments_number()) {
        comments_template();
      }
    endwhile;
    ?>
  </div>
</main>

<?php get_footer(); ?>
