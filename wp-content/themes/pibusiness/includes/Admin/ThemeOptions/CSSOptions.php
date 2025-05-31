<?php

namespace App\Admin\ThemeOptions;

use App\Admin\OptionFields\GeneralTextArea;

class CSSOptions extends OptionsRegistry
{
    /**
     * @var string
     */
    private $key = 'css_settings';

    /**
     * @return mixed
     */
    public function registerFields()
    {
        register_setting(
            $this->key,
            $this->key,
            [
                'sanitize_callback' => [
                    $this,
                    'sanitize'
                ]
            ]
        );

        add_settings_section(
            'section_css',
            'Enter Custom CSS',
            [$this, 'printSectionInfo'],
            $this->key
        );
        add_settings_field(
            'css_value',
            'CSS Code',
            [new GeneralTextArea($this->key), 'render'],
            $this->key,
            'section_css',
            'css_value'
        );

    }
}