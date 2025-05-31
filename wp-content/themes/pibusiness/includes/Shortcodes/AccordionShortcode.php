<?php

namespace App\Shortcodes;

/**
 * Class Button
 */
class AccordionShortcode implements ShortCodePresenter
{
    /**
     * @var array
     */
    protected static $defaultAttributes = [
        'title'  => '',
        'opened' => false,
    ];

    /**
     * @param  array  $attributes
     * @param  string  $content
     * @param  string  $name
     *
     * @return mixed
     */
    public static function render($attributes, $content = '', $name = '')
    {
        $filtered = shortcode_atts(self::$defaultAttributes, $attributes, $name);
        $opened   = json_encode((bool)$filtered['opened']);
        $content  = htmlspecialchars(json_encode($content));
        $title    = html_entity_decode($filtered['title']);
        $id       = uniqid();
        ob_start();
        echo "<div class='accordion-wrapper accordion-wrapper-$id' data-id='$id'><div is='accordion-wrapper' :is-active-on-start='$opened' :content='$content'>
                <template>$title</template>
            </div></div>";
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}