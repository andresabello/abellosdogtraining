<?php

namespace App\Admin\ThemeOptions;

use App\Admin\OptionFields\ColorPicker;
use App\Admin\OptionFields\FontFamily;
use App\Admin\OptionFields\GeneralText;
use App\Admin\OptionFields\MainImage;

/**
 * Class GeneralOptions
 */
class GeneralOptions extends OptionsRegistry
{
    /**
     * @var string
     */
    private $key = 'general_settings';

    /**
     * @return mixed|void
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
            'section_general',
            'General Settings',
            [$this, 'printSectionInfo'],
            $this->key
        );

        add_settings_field(
            'pi_logo_value',
            'Logo Image',
            [new MainImage($this->key), 'render'],
            $this->key,
            'section_general',
            'pi_logo_value'
        );


        add_settings_field(
            'pi_mobile_logo_value',
            'Mobile Logo Image',
            [new MainImage($this->key), 'render'],
            $this->key,
            'section_general',
            'pi_mobile_logo_value'
        );

        add_settings_field(
            'pi_font_color',
            'Font Color',
            [new ColorPicker($this->key), 'render'],
            $this->key,
            'section_general',
            'pi_font_color'
        );

        add_settings_field(
            'pi_font_family',
            'Font Family',
            [new FontFamily($this->key), 'render'],
            $this->key,
            'section_general',
            'pi_font_family'
        );

        add_settings_field(
            'pi_main_color_picker',
            'Main Color',
            [new ColorPicker($this->key), 'render'],
            $this->key,
            'section_general',
            'pi_main_color_picker'
        );

        add_settings_field(
            'pi_second_color_picker',
            'Secondary Color',
            [new ColorPicker($this->key), 'render'],
            $this->key,
            'section_general',
            'pi_second_color_picker'
        );

        add_settings_field(
            'pi_number',
            'Phone Number',
            [new GeneralText($this->key), 'render'],
            $this->key,
            'section_general',
            'pi_number'
        );

        add_settings_field(
            'support_logos',
            'Support Logos',
            [new MainImage($this->key), 'render'],
            $this->key,
            'section_general',
            'support_logos'
        );
    }

    /**
     * @param $input
     * @return array
     */
    public function sanitize($input)
    {
        $newInput = [];
        $newThemeVariables = [];

        if (isset($input['pi_logo_value'])) {
            $newInput['pi_logo_value'] = sanitize_text_field($input['pi_logo_value']);
        }

        if (isset($input['pi_mobile_logo_value'])) {
            $newInput['pi_mobile_logo_value'] = sanitize_text_field($input['pi_mobile_logo_value']);
        }

        if (isset($input['pi_font_color'])) {
            $newInput['pi_font_color'] = sanitize_text_field($input['pi_font_color']);
            $newThemeVariables['body-color'] = $newInput['pi_font_color'];
        }

        if (isset($input['pi_font_family'])) {
            $newInput['pi_font_family'] = sanitize_text_field($input['pi_font_family']);
            $newThemeVariables['font-family-base'] = "'{$newInput['pi_font_family']}'";
        }

        if (isset($input['pi_main_color_picker'])) {
            $newInput['pi_main_color_picker'] = sanitize_text_field($input['pi_main_color_picker']);
            $newThemeVariables['main-color'] = $newInput['pi_main_color_picker'];
        }

        if (isset($input['pi_second_color_picker'])) {
            $newInput['pi_second_color_picker'] = sanitize_text_field($input['pi_second_color_picker']);
            $secondaryColorHexValue = $newInput['pi_second_color_picker'];
            $newThemeVariables['secondary-color-hex'] = $secondaryColorHexValue;
            $newThemeVariables['secondary-color-rgba'] = $secondaryColorHexValue
                ? hexToRgba($secondaryColorHexValue)
                : '';
        }

        if (isset($input['pi_number'])) {
            $newInput['pi_number'] = sanitize_text_field($input['pi_number']);
        }


        if (isset($input['insurance_logos'])) {
            $newInput['insurance_logos'] = sanitize_text_field($input['insurance_logos']);
        }

        if (isset($input['support_logos'])) {
            $newInput['support_logos'] = sanitize_text_field($input['support_logos']);
        }

        if (count($newThemeVariables)) {
            $content = '';
            foreach ($newThemeVariables as $key => $scssVariable) {
                if (empty($scssVariable)) {
                    continue;
                }

                $content .= "$$key: $scssVariable;" . PHP_EOL;
            }
            file_put_contents(get_template_directory() . '/assets/scss/_theme-variables.scss', $content);
        }

        return $newInput;
    }
}