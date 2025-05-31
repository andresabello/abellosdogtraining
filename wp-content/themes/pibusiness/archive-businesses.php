<?php
/*
* Template Name: Businesses	
*/
?>
<?php get_header(); ?>
    <div class="container">
        <div class="row">
            <div class="col-xl-8" id="directory">
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                    <?php
                    $custom = get_post_custom($post->ID);
                    $website = $custom["website"][0];
                    $email = $custom["email"][0];
                    $logo = get_the_post_thumbnail($post->ID);
                    ?>
                    <div class="business clearfix">
                        <div class="info">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p><?php the_excerpt(); ?></p>
                            <p class="contact"><?php if ($website != "" || $website != "http://") {
                                    print "<a href=\"$website\">Site</a> / ";
                                }
                                if ($email != "") {
                                    print "<a href=\"mailto:$email\">Contact</a>";
                                } ?></p>
                        </div>
                        <?php print $logo; ?>
                    </div>
                <?php endwhile; else: ?> <p><?php _e('No posts were found. Sorry!'); ?></p>
                <?php endif; ?>
                <div class="navi">
                    <div class="right">
                        <?php previous_posts_link('Previous'); ?> / <?php next_posts_link('Next'); ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>