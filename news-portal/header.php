<?php
/**
 * The header for our theme
 *
 * @package News_Portal
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if (function_exists('wp_body_open')) { wp_body_open(); } ?>
<header class="site-header">
  <div class="container site-header-inner">
    <div class="site-branding">
      <?php if (has_custom_logo()) { the_custom_logo(); } ?>
      <div>
        <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></p>
        <?php $description = get_bloginfo('description', 'display'); if ($description || is_customize_preview()) : ?>
          <p class="site-description"><?php echo esc_html($description); ?></p>
        <?php endif; ?>
      </div>
    </div>
    <button id="navToggle" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e('Menu', 'news-portal'); ?></button>
    <nav id="siteNav" class="primary-navigation" aria-label="<?php esc_attr_e('Primary Menu', 'news-portal'); ?>">
      <?php
      wp_nav_menu([
        'theme_location' => 'primary',
        'menu_id'        => 'primary-menu',
        'container'      => false,
        'fallback_cb'    => false,
      ]);
      ?>
    </nav>
  </div>
</header>
<div id="content" class="site-content">
  <div class="container">
