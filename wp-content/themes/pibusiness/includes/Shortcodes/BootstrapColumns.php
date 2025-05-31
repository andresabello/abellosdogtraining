<?php

namespace App\Shortcodes;

/**
 * Class Button
 */
class BootstrapColumns implements ShortCodePresenter
{
    /**
     * @var array
     */
    protected static $defaultAttributes = [
        'size' => '12',
        'type' => 'md',
        'classes' => '',
        'id' => '',
        'inner_wrapper' => false
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
        if ($filteredAttributes['inner_wrapper']) {
            return self::getWrappedTemplate($content, $filteredAttributes);
        }

        return self::getUnwrappedContent($content, $filteredAttributes);
    }

    /**
     * @param $content
     * @param array $filteredAttributes
     *
     * @return false|string
     */
    private static function getWrappedTemplate($content, array $filteredAttributes)
    {
        $content = str_replace(['<p></p>', '<p> </p>'], '', $content);
        $columnSize = $filteredAttributes['type'] === 'xs' ? 'col' : 'col-' . $filteredAttributes['type'];
        ob_start();
        ?>
        <div class="<?= $columnSize ?>-<?= $filteredAttributes['size'] ?>">
            <div class='column-content <?= $filteredAttributes['classes'] ?>' id="<?= $filteredAttributes['id'] ?>">
                <?= do_shortcode($content); ?>
            </div>
        </div>

        <?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    /**
     * @param $content
     * @param array $filteredAttributes
     *
     * @return false|string
     */
    private static function getUnwrappedContent($content, array $filteredAttributes)
    {
        $columnSize = $filteredAttributes['type'] === 'xs' ? 'col' : 'col-' . $filteredAttributes['type'];
        $printedId = $filteredAttributes['id'] ? "id={$filteredAttributes['id']}" : null;

        ob_start(); ?>
        <div class="<?= $columnSize ?>-<?= $filteredAttributes['size'] ?> <?= $filteredAttributes['classes'] ?>" <?= $printedId ?>>
            <?= do_shortcode($content); ?>
        </div>

        <?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}