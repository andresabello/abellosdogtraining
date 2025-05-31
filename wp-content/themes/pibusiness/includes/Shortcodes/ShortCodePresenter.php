<?php

namespace App\Shortcodes;

/**
 * Interface Presenter
 */
interface ShortCodePresenter
{
    /**
     * @param array $attributes
     * @param string $content
     * @param string $name
     * @return mixed
     */
    public static function render($attributes, $content = '', $name = '');
}