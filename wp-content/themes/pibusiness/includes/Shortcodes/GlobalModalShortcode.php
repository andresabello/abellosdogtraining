<?php

namespace App\Shortcodes;

class GlobalModalShortcode implements ShortCodePresenter
{
    /**
     * @var array
     */
    protected static $defaultAttributes = [
        'id' => null,
        'title' => '',
        'classes' => ''
    ];

    /**
     * @param array $attributes
     * @param string $content
     * @param string $name
     * @return mixed|void
     */
    public static function render($attributes, $content = '', $name = '')
    {
        $filteredAttributes = shortcode_atts(self::$defaultAttributes, $attributes, $name);
        if (!isset($filteredAttributes['id']) && !isset($content)) {
            return;
        }

        $content = esc_html(do_shortcode($content));
        ob_start();
        ?>
        <div id="<?= $filteredAttributes['id'] ?>" style="display: none;"
             <?= !empty($filteredAttributes['title']) ? " data-title='{$filteredAttributes['title']}'" : null ?>
             <?= !empty($filteredAttributes['classes']) ? " data-classes='{$filteredAttributes['classes']}'" : null ?>
             data-content="<?= $content ?>"></div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}