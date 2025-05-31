<?php

namespace App\Shortcodes;

/**
 * Class Button
 */
class Components implements ShortCodePresenter
{
    /**
     * @var array
     */
    protected static $defaultAttributes = [
        'id' => '',
        'component_name' => '',
        'title' => '',
        'background_color' => '',
        'classes' => '',
        'has_container' => true,
        'is_fluid' => true
    ];

    /**
     * @param array $attributes
     * @param string $content
     * @param string $name
     *
     * @return false|string|null
     */
    public static function render($attributes, $content = '', $name = '')
    {
        $filteredAttributes = shortcode_atts(self::$defaultAttributes, $attributes);
        extract($filteredAttributes);

        if (!empty($filteredAttributes['id']) && isset($filteredAttributes['id'])) {
            $component = get_post($filteredAttributes['id']);
        }

        if (!empty($filteredAttributes['component_name']) && isset($filteredAttributes['component_name'])) {
            $component = get_page_by_name($filteredAttributes['component_name']);
        }

        if (!empty($filteredAttributes['title']) && isset($filteredAttributes['title'])) {
            $component = get_page_by_title($filteredAttributes['title'], OBJECT, 'components');
        }

        if (empty($component) || !isset($component)) {
            return '';
        }

        $componentMeta = get_post_meta($component->ID);
        $featuredImage = wp_get_attachment_image_src(get_post_thumbnail_id($component->ID), 'full');

        if (empty($componentMeta) || empty($component)) {
            return null;
        }

        $settings = isset($componentMeta['settings'][0]) ? $componentMeta['settings'][0] : '[]';
        $settings = json_decode($settings, true);
        $useStyles = false;
        $backgroundColor = '';

        if (isset($settings['background_color'])) {
            $backgroundColor = $settings['background_color'];
            $useStyles = true;
        }

        if (!empty($filteredAttributes['background_color'])) {
            $backgroundColor = $filteredAttributes['background_color'];
            $useStyles = true;
        }

        $bgColorStyles = $useStyles ? "style='background-color: $backgroundColor;'" : null;
        $bgContainerStyles = isset($featuredImage[0]) ?
            "style='background-color: $backgroundColor; background-image: url($featuredImage[0]); background-repeat: repeat-x; background-size: cover;'" :
            null;

        $container = $filteredAttributes['has_container'] === 'false' || !$filteredAttributes['has_container'] ? null : 'class="container-fluid"';
        $isFluid = !$filteredAttributes['is_fluid'] || $filteredAttributes['is_fluid'] === 'false' ? false : true;
        if ($container && !$isFluid) {
            $container = 'class="container"';
        }

        ob_start();
        echo "<div class='component {$filteredAttributes['classes']}' $bgColorStyles >";
        if ($container) {
            echo "<div $container $bgContainerStyles>";
            echo '<div class="row" ><div class="col-md-12">';
        }
        echo do_shortcode($component->post_content);
        echo '</div>';
        echo $container ? '</div></div></div>' : null;
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}