<?php
/**
 * The template for displaying the footer
 *
 * @package News_Portal
 */
?>
  </div><!-- .container -->
</div><!-- #content -->
<footer class="site-footer">
  <div class="container site-footer-inner">
    <div class="footer-widgets">
      <?php if (is_active_sidebar('footer-1')) : ?>
        <div><?php dynamic_sidebar('footer-1'); ?></div>
      <?php endif; ?>
      <?php if (is_active_sidebar('footer-2')) : ?>
        <div><?php dynamic_sidebar('footer-2'); ?></div>
      <?php endif; ?>
      <?php if (is_active_sidebar('footer-3')) : ?>
        <div><?php dynamic_sidebar('footer-3'); ?></div>
      <?php endif; ?>
    </div>
    <nav class="footer-navigation" aria-label="<?php esc_attr_e('Footer Menu', 'news-portal'); ?>">
      <?php
      wp_nav_menu([
        'theme_location' => 'footer',
        'container'      => false,
        'fallback_cb'    => false,
      ]);
      ?>
    </nav>
    <div class="site-info">
      <span>&copy; <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?>.</span>
    </div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
