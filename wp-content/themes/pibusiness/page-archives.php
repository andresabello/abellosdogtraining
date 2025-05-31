<?php
/*
* Template Name: Archives	
*/
?>
<?php get_header(); ?>
    <div class="container">
        <div class="row">
            <div class="col-xl-8">
                <h2>Archives by Month: </h2>
                <ul>
                    <?php wp_get_archives('type=monthly'); ?>
                </ul>
                <h2>Archives by Subject: </h2>
                <ul>
                    <?php wp_list_categories('hierarchical=0&title_li='); ?>
                </ul>
            </div>
            <div class="col-xl-4">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
<?php get_footer(); ?>