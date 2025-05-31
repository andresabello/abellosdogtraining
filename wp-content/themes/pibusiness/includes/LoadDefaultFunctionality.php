<?php

namespace App;

/**
 * Class LoadDefaultFunctionality
 */
class LoadDefaultFunctionality
{
    /**
     * @var
     */
    private $themeName;
    /**
     * @var
     */
    private $version;

    /**
     * LoadDefaultFunctionality constructor.
     * @param $themeName
     * @param $version
     */
    public function __construct($themeName, $version)
    {

        $this->themeName = $themeName;
        $this->version = $version;

    }

    /**
     *
     */
    public function pi_setup()
    {
        add_theme_support('automatic-feed-links');
        add_theme_support('post-thumbnails');
        add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption']);
        register_nav_menus(
            [
                'main-menu' => __('Main Menu', $this->themeName)
            ]
        );
    }
}