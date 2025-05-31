<?php
$piOptions = get_option('pi_options');
$id = uniqid();
?>
<?php get_header(); ?>
<?php if (have_posts()) :
    while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
    <?php endwhile; ?>
<?php else: ?>
    <p>No pages were found. Sorry!</p>
<?php endif; ?>
<?php get_footer(); ?>
