<?php get_header(); ?>
<main class="container">
  <h1>News</h1>
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>">
      <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <div><?php the_excerpt(); ?></div>
    </article>
  <?php endwhile; else: ?>
    <p>No posts found.</p>
  <?php endif; ?>
</main>
<?php get_footer(); ?>
