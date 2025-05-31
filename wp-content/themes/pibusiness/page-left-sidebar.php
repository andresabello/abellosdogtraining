<?php
/*
* Template Name: Left Sidebar 
*/
?>
<?php get_header(); ?>
<div class="container my-5">
    <div class="row">
        <div class="col-xl-8">
            <div class="content">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                            <?php the_post_thumbnail('full'); ?>
                        </a>
                    <?php endif; ?>
                    <?php the_content('Read More...'); ?>
                <?php endwhile; else: ?>
                    <p><?php _e('No posts were found. Sorry!'); ?></p>
                <?php endif; ?>
            </div>

        </div>
        <div class="col-xl-4">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>