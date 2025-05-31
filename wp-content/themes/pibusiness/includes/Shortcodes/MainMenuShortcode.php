<?php

namespace App\Shortcodes;

use App\Menu\MenuBuilder;

/**
 * Class Button
 */
class MainMenuShortcode implements ShortCodePresenter
{
    /**
     * @var array
     */
    protected static $defaultAttributes = [
        'name' => 'main',
        'render' => 'dynamic',
        'sticks' => true
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
        $menu = MenuBuilder::build($filteredAttributes['name']);
        $settings = get_option('general_settings');
        $options = get_option('general_settings');
        $phone = $options['pi_number'] ?? '888.999.9999';
        $sticks = $filteredAttributes['sticks'] ?? false;

        set_query_var('menu', $menu);
        set_query_var('phone', $phone);
        set_query_var('sticks', $sticks);
        set_query_var('phoneHref', self::formatPhoneNumber($phone));
        ob_start();
        get_template_part('menu/main');

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    public static function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/\D+/', '', $phone);
        return 'tel:' . $phone;
    }
}