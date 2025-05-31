<?php

namespace App\Shortcodes;

/**
 * Class Button
 */
class BootstrapRows implements ShortCodePresenter
{
    /**
     * @var array
     */
    protected static $defaultAttributes = [
        'background_image' => '',
        'background_color' => '',
        'classes' => '',
        'id' => '',
    ];

    /**
     * @param array $attributes
     * @param string $content
     * @param string $name
     *
     * @return mixed
     */
    public static function render($attributes, $content = '', $name = '')
    {
        $filteredAttributes = shortcode_atts(self::$defaultAttributes, $attributes);

        $useStyles = false;
        $bgColor = '';

        if (!empty($filteredAttributes['background_color'])) {
            $bgColor = 'background-color:' . $filteredAttributes['background_color'] . ';';
            $useStyles = true;
        }
        if (!empty($filteredAttributes['background_image'])) {
            $bgImage = "background: url('{$filteredAttributes['background_image']}') no-repeat center center / cover no-repeat $bgColor;";
            $useStyles = true;
        }

        $printedId = $filteredAttributes['id'] ? "id={$filteredAttributes['id']}" : null;
        $styles = $useStyles ? "styles='$bgColor $bgImage'" : '';
        $output = "<section $printedId class='section {$filteredAttributes['classes']}' $styles>";
        $output .= '<div class="container"><div class="row">';
        $output .= do_shortcode($content);
        $output .= '</div></div></section>';

        return $output;
    }
}