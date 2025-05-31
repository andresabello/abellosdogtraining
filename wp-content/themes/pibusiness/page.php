<?php get_header(); ?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="row">
			<div class="col-12">
				<?php if (has_post_thumbnail()) : ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<?php the_post_thumbnail('full'); ?>
					</a>
				<?php endif; ?>
			</div>
		</div>
	
		<?php the_content('Read More...'); ?>
		<?php endwhile; else: ?>
			<p><?php _e('No posts were found. Sorry!'); ?></p>
		<?php endif; ?>
<?php get_footer(); ?>