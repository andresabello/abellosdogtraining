<?php get_header(); ?>
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-12">
                
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<div class="row bg-1 mb-5">
                        <div class="col-lg-12 p-lg-5">
							<div class="row">
								<div class="col-lg-4">
									<?php if (has_post_thumbnail()) : ?>
										<div class="text-center">
											<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
												<?php the_post_thumbnail('full', ['class' => 'img img-fluid']); ?>
											</a>
										</div>
									<?php endif; ?>
								</div>
								<div class="col-lg-8">
									<h2 class="my-4"><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a></h2>
                          			<?php the_excerpt('Read More...'); ?>
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="btn btn-link">Read More</a>
								</div>
							</div>
                        </div>
					</div>
                    <?php endwhile; else: ?>
                        <p><?php _e('No posts were found. Sorry!'); ?></p>
                    <?php endif; ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>