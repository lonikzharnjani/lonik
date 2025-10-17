<?php
/**
 * Template part for displaying a post in list/card
 *
 * @package News_Portal
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
  <div class="post-thumb">
    <a href="<?php the_permalink(); ?>">
      <?php if (has_post_thumbnail()) {
        the_post_thumbnail('news-card');
      } else {
        echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/img/placeholder-600x400.svg') . '" alt="" />';
      } ?>
    </a>
  </div>
  <header class="entry-header">
    <?php
    $categories = get_the_category();
    if (!empty($categories)) {
        echo '<span class="post-category">' . esc_html($categories[0]->name) . '</span>';
    }
    ?>
    <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <div class="post-meta">
      <span class="byline"><?php echo esc_html(get_the_author()); ?></span>
      <span class="sep"> · </span>
      <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
    </div>
  </header>
  <div class="post-excerpt">
    <?php the_excerpt(); ?>
  </div>
</article>
