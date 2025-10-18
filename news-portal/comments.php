<?php
/**
 * The template for displaying comments
 * If the current post is protected by a password and the visitor has not
 * yet entered the password we will return early without loading the comments.
 *
 * @package News_Portal
 */

if (post_password_required()) {
    return;
}
?>
<div id="comments" class="comments-area">

  <?php if (have_comments()) : ?>
    <h2 class="comments-title">
      <?php
      $comments_number = get_comments_number();
      if ('1' === $comments_number) {
          printf(
              /* translators: %s: post title */
              esc_html__('One thought on “%s”', 'news-portal'),
              '<span>' . get_the_title() . '</span>'
          );
      } else {
          printf(
              /* translators: 1: number of comments, 2: post title */
              esc_html(_nx('%1$s thought on “%2$s”', '%1$s thoughts on “%2$s”', $comments_number, 'comments title', 'news-portal')),
              number_format_i18n($comments_number),
              '<span>' . get_the_title() . '</span>'
          );
      }
      ?>
    </h2>

    <ol class="comment-list">
      <?php
      wp_list_comments([
        'style'      => 'ol',
        'short_ping' => true,
      ]);
      ?>
    </ol>

    <?php the_comments_pagination([
      'prev_text' => '<span class="screen-reader-text">' . esc_html__('Previous', 'news-portal') . '</span>',
      'next_text' => '<span class="screen-reader-text">' . esc_html__('Next', 'news-portal') . '</span>',
    ]); ?>

  <?php endif; // Check for have_comments(). ?>

  <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
    <p class="no-comments"><?php esc_html_e('Comments are closed.', 'news-portal'); ?></p>
  <?php endif; ?>

  <?php comment_form(); ?>

</div><!-- #comments -->
