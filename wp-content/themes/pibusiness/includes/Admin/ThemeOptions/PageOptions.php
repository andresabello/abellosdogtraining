<?php

namespace App\Admin\ThemeOptions;

use App\Admin\OptionFields\MainImage;
use App\Admin\OptionFields\GeneralText;
use App\Admin\OptionFields\GeneralTextArea;

class PageOptions extends OptionsRegistry
{
    /**
     * @var string
     */
    private $key = 'page_settings';

    /**
     * @return mixed
     */
    public function registerFields()
    {
        $section = 'section_page';
        $mainImage = new MainImage($this->key);
        $generalTextArea = new GeneralTextArea($this->key);
        $generalText = new GeneralText($this->key);

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
            'Page Settings',
            [$this, 'printSectionInfo'],
            $this->key
        );

        add_settings_field(
            'blog_featured_image',
            'Blog Featured Image',
            [$mainImage, 'render'],
            $this->key,
            $section,
            'blog_featured_image'
        );

        add_settings_field(
            'blog_featured_text',
            'Blog Featured Text',
            [$generalTextArea, 'render'],
            $this->key,
            $section,
            'blog_featured_text'
        );

        add_settings_field(
            'blog_post_default_featured_image',
            'Blog Post Default Featured Image',
            [$mainImage, 'render'],
            $this->key,
            $section,
            'blog_post_default_featured_image'
        );

        add_settings_field(
            'blog_featured_amount',
            'Amount of Featured Posts',
            [$generalText, 'render'],
            $this->key,
            $section,
            'blog_featured_amount'
        );

        add_settings_field(
            'blog_featured_id',
            'Featured Posts, Comma delimited',
            [$generalText, 'render'],
            $this->key,
            $section,
            'blog_featured_id'
        );

        add_settings_field(
            'testimonial_featured_image',
            'Testimonial Featured Image',
            [$mainImage, 'render'],
            $this->key,
            $section,
            'testimonial_featured_image'
        );

        add_settings_field(
            'testimonial_featured_text',
            'Testimonial Featured Text',
            [$generalTextArea, 'render'],
            $this->key,
            $section,
            'testimonial_featured_text'
        );

        add_settings_field(
            'resources_featured_image',
            'Resources Featured Image',
            [$mainImage, 'render'],
            $this->key,
            $section,
            'resources_featured_image'
        );

        add_settings_field(
            'resources_featured_text',
            'Resources Featured Text',
            [$generalTextArea, 'render'],
            $this->key,
            $section,
            'resources_featured_text'
        );

        add_settings_field(
            'drugs_featured_image',
            'Drugs Featured Image',
            [$mainImage, 'render'],
            $this->key,
            $section,
            'drugs_featured_image'
        );

        add_settings_field(
            'drugs_featured_text',
            'Drugs Featured Text',
            [$generalTextArea, 'render'],
            $this->key,
            $section,
            'drugs_featured_text'
        );

        add_settings_field(
            'author_featured_image',
            'Author Featured Image',
            [$mainImage, 'render'],
            $this->key,
            $section,
            'author_featured_image'
        );

        add_settings_field(
            'four_title',
            'Title on 404 page',
            [$generalText, 'render'],
            $this->key,
            $section,
            'four_title'
        );

        add_settings_field(
            'four_message',
            'Message on 404 page',
            [$generalTextArea, 'render'],
            $this->key,
            $section,
            'four_message'
        );
    }

    /**
     * @param $input
     *
     * @return mixed
     */
    public function sanitize($input): array
    {
        $newInput = [];

        if (isset($input['blog_featured_image'])) {
            $newInput['blog_featured_image'] = sanitize_text_field($input['blog_featured_image']);
        }

        if (isset($input['blog_post_default_featured_image'])) {
            $newInput['blog_post_default_featured_image'] = sanitize_text_field($input['blog_post_default_featured_image']);
        }

        if (isset($input['blog_featured_text'])) {
            $newInput['blog_featured_text'] = wp_kses_post($input['blog_featured_text']);
        }

        if (isset($input['blog_featured_amount'])) {
            $newInput['blog_featured_amount'] = sanitize_text_field($input['blog_featured_amount']);
        }

        if (isset($input['blog_featured_id'])) {
            $newInput['blog_featured_id'] = sanitize_text_field($input['blog_featured_id']);
        }

        if (isset($input['testimonial_featured_image'])) {
            $newInput['testimonial_featured_image'] = sanitize_text_field($input['testimonial_featured_image']);
        }

        if (isset($input['testimonial_featured_text'])) {
            $newInput['testimonial_featured_text'] = wp_kses_post($input['testimonial_featured_text']);
        }

        if (isset($input['resources_featured_text'])) {
            $newInput['resources_featured_text'] = wp_kses_post($input['resources_featured_text']);
        }

        if (isset($input['resources_featured_image'])) {
            $newInput['resources_featured_image'] = sanitize_text_field($input['resources_featured_image']);
        }

        if (isset($input['drugs_featured_text'])) {
            $newInput['drugs_featured_text'] = wp_kses_post($input['drugs_featured_text']);
        }

        if (isset($input['drugs_featured_image'])) {
            $newInput['drugs_featured_image'] = sanitize_text_field($input['drugs_featured_image']);
        }

        if (isset($input['author_featured_image'])) {
            $newInput['author_featured_image'] = sanitize_text_field($input['author_featured_image']);
        }

        if (isset($input['four_title'])) {
            $newInput['four_title'] = sanitize_text_field($input['four_title']);
        }

        if (isset($input['four_message'])) {
            $newInput['four_message'] = wp_kses_post($input['four_message']);
        }

        return $newInput;
    }
}