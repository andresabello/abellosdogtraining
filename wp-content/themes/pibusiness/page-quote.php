<?php
/*
* Template Name: Full Width. With Container
*/
?>
<?php get_header(); ?>
    <div class="container my-5">
        <div class="row">
            <div class="col-xl-12">
                <div class="content">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <?php if (has_post_thumbnail()) : ?>
							<div class="row">
								<div class="col-xl-8 offset-xl-2">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                		<?php the_post_thumbnail('full', ['class' => 'img img-fluid']); ?>
                            		</a>
								</div>
							</div>
                         
                        <?php endif; ?>
                        <?php the_content('Read More...'); ?>
                    <?php endwhile; else: ?>
                        <p><?php _e('No posts were found. Sorry!'); ?></p>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
<?php get_footer(); ?>