<?php get_header(); ?>
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				    <h1 class="mb-4"><?php the_title(); ?></h1>
				    <div class="byline">
                        <p>by <?php the_author_posts_link(); ?> on <span
                                class="date"> <?php the_time('l F d, Y'); ?></span><br/>
                            Posted in: <?php the_category(', '); ?> | <?php
                            the_tags('Tagged with: ', ' • ', '<br />'); ?></p>
                    </div>
                    <?php if (has_post_thumbnail()) : ?>
                        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                            <?php the_post_thumbnail('full', ['class' => 'img img-fluid']); ?>
                        </a>
                    <?php endif; ?>
					<div class="pt-5">
						<?php the_content('Read More...'); ?>
					</div>
                    
                <?php endwhile; else: ?>
                    <p><?php _e('No posts were found. Sorry!'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>