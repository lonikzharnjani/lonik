<?php
/**
 * Featured small list item
 *
 * @package News_Portal
 */
?>
<div class="item">
  <a href="<?php the_permalink(); ?>">
    <div class="thumb">
      <?php if (has_post_thumbnail()) {
        the_post_thumbnail('thumbnail');
      } ?>
    </div>
  </a>
  <div class="content">
    <a href="<?php the_permalink(); ?>"><h3 class="title"><?php the_title(); ?></h3></a>
    <div class="post-meta">
      <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date()); ?></time>
    </div>
  </div>
</div>
