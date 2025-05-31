<?php

namespace App;

class I18n
{

    /**
     *
     * @since    1.0.0
     * @access   private
     * @var      string $domain
     */
    public $domain;

    /**
     *
     * @since    1.0.0
     */
    public function loadThemeTextDomain()
    {
        load_theme_textdomain(
            $this->domain,
            THEME_PATH . '/languages/'
        );
    }
}