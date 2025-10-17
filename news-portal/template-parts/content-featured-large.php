<?php
/**
 * Featured large post (hero)
 *
 * @package News_Portal
 */
$post = get_post();
if (!$post) { return; }
?>
<a class="featured-large" href="<?php echo esc_url(get_permalink($post)); ?>">
  <?php if (has_post_thumbnail($post)) {
    echo get_the_post_thumbnail($post, 'news-featured');
  } ?>
  <span class="overlay" aria-hidden="true"></span>
  <span class="overlay-content">
    <?php
    $categories = get_the_category($post->ID);
    if (!empty($categories)) {
        echo '<span class="post-category">' . esc_html($categories[0]->name) . '</span>';
    }
    ?>
    <h2 class="post-title"><?php echo esc_html(get_the_title($post)); ?></h2>
  </span>
</a>
