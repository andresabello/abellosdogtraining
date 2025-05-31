<?php

namespace App\Admin\ThemeOptions;

use App\Admin\OptionFields\GeneralText;
use App\Admin\OptionFields\GeneralTextArea;
use App\Admin\OptionFields\MainImage;
use App\Admin\OptionFields\ShortcodeByPostType;

class HomeOptions extends OptionsRegistry
{
    /**
     * @var string
     */
    private $key = 'home_settings';

    /**
     * @return mixed
     */
    public function registerFields()
    {

        $section = 'section_home';
        $generalText = new GeneralText($this->key);
        $generalTextarea = new GeneralTextArea($this->key);
        $mainImage = new MainImage($this->key);

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
            'Home Settings',
            [$this, 'printSectionInfo'],
            $this->key
        );

        add_settings_field(
            'pi_feature_one_title',
            'Feature 1 Title',
            [$generalText, 'render'],
            $this->key,
            $section,
            'pi_feature_one_title'
        );

        add_settings_field(
            'pi_feature_one_text',
            'Feature 1 Text',
            [$generalTextarea, 'render'],
            $this->key,
            $section,
            'pi_feature_one_text'
        );

        add_settings_field(
            'pi_feature_two_title',
            'Feature 2 Title',
            [$generalText, 'render'],
            $this->key,
            $section,
            'pi_feature_two_title'
        );

        add_settings_field(
            'pi_feature_two_text',
            'Feature 2 Text',
            [$generalTextarea, 'render'],
            $this->key,
            $section,
            'pi_feature_two_text'
        );

        add_settings_field(
            'pi_feature_three_title',
            'Feature 3 Title',
            [$generalText, 'render'],
            $this->key,
            $section,
            'pi_feature_three_title'
        );

        add_settings_field(
            'pi_feature_three_text',
            'Feature 3 Text',
            [$generalTextarea, 'render'],
            $this->key,
            $section,
            'pi_feature_three_text'
        );

        add_settings_field(
            'pi_separator',
            '',
            [$this, 'separator'],
            $this->key,
            $section
        );

        $sliderSelect = new ShortcodeByPostType($this->key);
        $sliderSelect->setPostType('slider');

        add_settings_field(
            'pi_home_slider',
            'Home Slider',
            [$sliderSelect, 'render'],
            $this->key,
            $section,
            'pi_home_slider'
        );

        $tabbedText = new ShortcodeByPostType($this->key);
        $tabbedText->setPostType('tabbed_text');

        add_settings_field(
            'pi_home_tabbed_text',
            'Home Tabbed text',
            [$tabbedText, 'render'],
            $this->key,
            $section,
            'pi_home_tabbed_text'
        );


        $tabbedContent = new ShortcodeByPostType($this->key);
        $tabbedContent->setPostType('tabbed_content');

        add_settings_field(
            'pi_home_tabbed_content',
            'Home Tabbed Content',
            [$tabbedContent, 'render'],
            $this->key,
            $section,
            'pi_home_tabbed_content'
        );

        add_settings_field(
            'pi_home_tabbed_content_title',
            'Home Tabbed Content Title',
            [$generalText, 'render'],
            $this->key,
            $section,
            'pi_home_tabbed_content_title'

        );

        add_settings_field(
            'pi_home_tabbed_content_text',
            'Home Tabbed Content Text',
            [$generalTextarea, 'render'],
            $this->key,
            $section,
            'pi_home_tabbed_content_text'
        );

        add_settings_field(
            'pi_second_separator',
            '',
            [$this, 'separator'],
            $this->key,
            $section
        );

        add_settings_field(
            'pi_home_video_url',
            'Home Youtube URL',
            [$generalText, 'render'],
            $this->key,
            $section,
            'pi_home_video_url'
        );

        add_settings_field(
            'pi_home_advocacy_image',
            'Home Advocacy Image',
            [$mainImage, 'render'],
            $this->key,
            $section,
            'pi_home_advocacy_image'
        );

        add_settings_field(
            'pi_home_advocacy_title',
            'Home Advocacy Title',
            [$generalText, 'render'],
            $this->key,
            $section,
            'pi_home_advocacy_title'
        );

        add_settings_field(
            'pi_home_advocacy_text',
            'Home Advocacy Text',
            [$generalTextarea, 'render'],
            $this->key,
            $section,
            'pi_home_advocacy_text'
        );

        add_settings_field(
            'pi_home_advocacy_url',
            'Home Advocacy URL',
            [$generalText, 'render'],
            $this->key,
            $section,
            'pi_home_advocacy_url'
        );

        add_settings_field(
            'pi_third_separator',
            '',
            [$this, 'separator'],
            $this->key,
            $section
        );

        add_settings_field(
            'pi_home_partnerships_image',
            'Partnerships Image',
            [$mainImage, 'render'],
            $this->key,
            $section,
            'pi_home_partnerships_image'
        );

        add_settings_field(
            'pi_home_partnerships_title',
            'Partnerships Title',
            [$generalText, 'render'],
            $this->key,
            $section,
            'pi_home_partnerships_title'
        );

        add_settings_field(
            'pi_home_partnerships_text',
            'Partnerships text',
            [$generalTextarea, 'render'],
            $this->key,
            $section,
            'pi_home_partnerships_text'
        );

        add_settings_field(
            'pi_home_partnerships_url',
            'Partnerships URL',
            [$generalText, 'render'],
            $this->key,
            $section,
            'pi_home_partnerships_url'
        );

        add_settings_field(
            'pi_fourth_separator',
            '',
            [$this, 'separator'],
            $this->key,
            $section
        );

        add_settings_field(
            'insurance_logos',
            'Insurance Logos',
            [$mainImage, 'render'],
            $this->key,
            $section,
            'insurance_logos'
        );

        add_settings_field(
            'pi_home_insurance_title',
            'Insurance Title',
            [$generalText, 'render'],
            $this->key,
            $section,
            'pi_home_insurance_title'
        );

        add_settings_field(
            'pi_home_insurance_text',
            'Insurance text',
            [$generalTextarea, 'render'],
            $this->key,
            $section,
            'pi_home_insurance_text'
        );

        add_settings_field(
            'pi_fifth_separator',
            '',
            [$this, 'separator'],
            $this->key,
            $section
        );

        add_settings_field(
            'pi_home_programs_title',
            'Programs Title',
            [$generalText, 'render'],
            $this->key,
            $section,
            'pi_home_programs_title'
        );

        add_settings_field(
            'pi_home_programs_text',
            'Programs text',
            [$generalTextarea, 'render'],
            $this->key,
            $section,
            'pi_home_programs_text'
        );

        add_settings_field(
            'video_url',
            'Video URL',
            [$generalText, 'render'],
            $this->key,
            $section,
            'video_url'
        );

        add_settings_field(
            'video_background_url',
            'Video Background URL',
            [$generalText, 'render'],
            $this->key,
            $section,
            'video_background_url'
        );

    }

    /**
     * @param $input
     * @return array
     */
    public function sanitize($input)
    {
        $newInput = [];

        if (isset($input['pi_feature_one_title'])) {
            $newInput['pi_feature_one_title'] = sanitize_text_field($input['pi_feature_one_title']);
        }

        if (isset($input['pi_feature_one_text'])) {
            $newInput['pi_feature_one_text'] = wp_kses_post($input['pi_feature_one_text']);
        }

        if (isset($input['pi_feature_two_title'])) {
            $newInput['pi_feature_two_title'] = sanitize_text_field($input['pi_feature_two_title']);
        }

        if (isset($input['pi_feature_two_text'])) {
            $newInput['pi_feature_two_text'] = wp_kses_post($input['pi_feature_two_text']);
        }

        if (isset($input['pi_feature_three_title'])) {
            $newInput['pi_feature_three_title'] = sanitize_text_field($input['pi_feature_three_title']);
        }

        if (isset($input['pi_feature_three_text'])) {
            $newInput['pi_feature_three_text'] = wp_kses_post($input['pi_feature_three_text']);
        }

        if (isset($input['pi_home_slider'])) {
            $newInput['pi_home_slider'] = sanitize_text_field($input['pi_home_slider']);
        }

        if (isset($input['pi_home_tabbed_text'])) {
            $newInput['pi_home_tabbed_text'] = sanitize_text_field($input['pi_home_tabbed_text']);
        }

        if (isset($input['pi_home_tabbed_content'])) {
            $newInput['pi_home_tabbed_content'] = sanitize_text_field($input['pi_home_tabbed_content']);
        }

        if (isset($input['pi_home_video_url'])) {
            $newInput['pi_home_video_url'] = sanitize_text_field($input['pi_home_video_url']);
        }

        if (isset($input['pi_home_partnerships_image'])) {
            $newInput['pi_home_partnerships_image'] = sanitize_text_field($input['pi_home_partnerships_image']);
        }

        if (isset($input['pi_home_partnerships_title'])) {
            $newInput['pi_home_partnerships_title'] = sanitize_text_field($input['pi_home_partnerships_title']);
        }

        if (isset($input['pi_home_partnerships_url'])) {
            $newInput['pi_home_partnerships_url'] = sanitize_text_field($input['pi_home_partnerships_url']);
        }


        if (isset($input['pi_home_partnerships_text'])) {
            $newInput['pi_home_partnerships_text'] = wp_kses_post($input['pi_home_partnerships_text']);
        }

        if (isset($input['pi_home_advocacy_text'])) {
            $newInput['pi_home_advocacy_text'] = wp_kses_post($input['pi_home_advocacy_text']);
        }

        if (isset($input['pi_home_advocacy_title'])) {
            $newInput['pi_home_advocacy_title'] = sanitize_text_field($input['pi_home_advocacy_title']);
        }

        if (isset($input['pi_home_advocacy_url'])) {
            $newInput['pi_home_advocacy_url'] = sanitize_text_field($input['pi_home_advocacy_url']);
        }

        if (isset($input['pi_home_advocacy_image'])) {
            $newInput['pi_home_advocacy_image'] = sanitize_text_field($input['pi_home_advocacy_image']);
        }

        if (isset($input['pi_home_insurance_title'])) {
            $newInput['pi_home_insurance_title'] = sanitize_text_field($input['pi_home_insurance_title']);
        }

        if (isset($input['pi_home_insurance_text'])) {
            $newInput['pi_home_insurance_text'] = sanitize_text_field($input['pi_home_insurance_text']);
        }

        if (isset($input['pi_home_tabbed_content_title'])) {
            $newInput['pi_home_tabbed_content_title'] = sanitize_text_field($input['pi_home_tabbed_content_title']);
        }

        if (isset($input['pi_home_tabbed_content_text'])) {
            $newInput['pi_home_tabbed_content_text'] = wp_kses_post($input['pi_home_tabbed_content_text']);
        }

        if (isset($input['pi_home_programs_title'])) {
            $newInput['pi_home_programs_title'] = sanitize_text_field($input['pi_home_programs_title']);
        }

        if (isset($input['pi_home_programs_text'])) {
            $newInput['pi_home_programs_text'] = wp_kses_post($input['pi_home_programs_text']);
        }

        if (isset($input['insurance_logos'])) {
            $newInput['insurance_logos'] = sanitize_text_field($input['insurance_logos']);
        }

        if (isset($input['video_opacity'])) {
            $newInput['video_opacity'] = sanitize_text_field($input['video_opacity']);
        }

        if (isset($input['video_url'])) {
            $newInput['video_url'] = sanitize_text_field($input['video_url']);
        }

        if (isset($input['video_background_url'])) {
            $newInput['video_background_url'] = sanitize_text_field($input['video_background_url']);
        }

        return $newInput;
    }

}