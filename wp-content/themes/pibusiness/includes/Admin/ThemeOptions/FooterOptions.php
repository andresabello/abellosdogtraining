<?php

namespace App\Admin\ThemeOptions;

use App\Admin\OptionFields\GeneralText;
use App\Admin\OptionFields\MainImage;

class FooterOptions extends OptionsRegistry
{
    /**
     * @var string
     */
    private $key = 'footer_settings';

    /**
     * @return mixed
     */
    public function registerFields()
    {
        $section = 'section_footer';

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
            $section,
            'Footer Settings',
            [$this, 'printSectionInfo'],
            $this->key
        );

        add_settings_field(
            'pi_footer_small_logo',
            'Footer Small Logo',
            [new MainImage($this->key), 'render'],
            $this->key,
            $section,
            'pi_footer_small_logo'
        );

        add_settings_field(
            'pi_footer_small_logo_url',
            'Footer Small Logo URL',
            [new GeneralText($this->key), 'render'],
            $this->key,
            $section,
            'pi_footer_small_logo_url'
        );


        add_settings_field(
            'pi_footer_insurances_logo',
            'Footer Insurances Logo',
            [new MainImage($this->key), 'render'],
            $this->key,
            $section,
            'pi_footer_insurances_logo'
        );

        add_settings_field(
            'pi_footer_insurances_logo_url',
            'Footer Insurances Logo URL',
            [new GeneralText($this->key), 'render'],
            $this->key,
            $section,
            'pi_footer_insurances_logo_url'
        );

    }

    /**
     * @param $input
     * @return array
     */
    public function sanitize($input)
    {
        $newInput = [];

        if (isset($input['pi_footer_small_logo'])) {
            $newInput['pi_footer_small_logo'] = sanitize_text_field($input['pi_footer_small_logo']);
        }

        if (isset($input['pi_footer_small_logo_url'])) {
            $newInput['pi_footer_small_logo_url'] = sanitize_text_field($input['pi_footer_small_logo_url']);
        }

        if (isset($input['pi_footer_insurances_logo'])) {
            $newInput['pi_footer_insurances_logo'] = sanitize_text_field($input['pi_footer_insurances_logo']);
        }

        if (isset($input['pi_footer_insurances_logo_url'])) {
            $newInput['pi_footer_insurances_logo_url'] = sanitize_text_field($input['pi_footer_insurances_logo_url']);
        }

        return $newInput;
    }

}