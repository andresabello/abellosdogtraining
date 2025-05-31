<aside>
    <?php if (!function_exists('dynamic_sidebar') ||
        !dynamic_sidebar('Primary Sidebar')) : ?>
        <h3 class="mb-5">Search</h3>
        <?php get_search_form(); ?>
    <?php endif; ?>
</aside>