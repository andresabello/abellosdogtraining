<?php

namespace App\PostTypes;

use Exception;
use App\MetaBoxes\TabbedContentField;
use App\MetaBoxes\ImageGalleryUploadField;

class TabbedContentPostType extends WordPressPostTypeAbstract
{
    /**
     * @var ImageGalleryUploadField
     */
    protected $tabbedContentBox;

    /**
     * @var string
     */
    protected $postTypeName = 'tabbed_content';

    /**
     * RegisterSlider constructor.
     * @param string $themeName
     * @param array $options
     */
    public function __construct(string $themeName, array $options = [])
    {
        $this->themeName = $themeName;
        $this->options = $options;
        $this->defaultOptions['supports'] = ['title', 'editor', 'thumbnail', 'excerpt', 'page-attributes'];
        $this->defaultOptions['public'] = false;
        $this->defaultOptions['publicly_queryable'] = false;
        $this->defaultOptions['menu_position'] = 77;
        $this->defaultOptions['menu_icon'] = 'dashicons-index-card';
        $this->tabbedContentBox = $this->getTabbedContentField();
    }

    /**
     * @throws Exception
     */
    public function handle()
    {
        $options = $this->setOptionsAndLabels();
        if (post_type_exists($this->postTypeName)) {
            throw new Exception('Post type already exists');
        }

        register_post_type($this->postTypeName, $options);
        $this->registerTaxonomy();
        add_action('add_meta_boxes', [$this, 'addMetaBoxes']);
        add_action('save_post', [$this->tabbedContentBox, 'save']);
    }

    /**
     *
     */
    public function addMetaBoxes()
    {
        add_meta_box(
            'pi_tabbed_content_shortcode',
            __('Tabbed Content Shortcode', $this->themeName),
            [$this->tabbedContentBox, 'renderShortCode'],
            $this->postTypeName,
            'side',
            'low'
        );
    }

    protected function getTabbedContentField(): TabbedContentField
    {
        return new TabbedContentField();
    }

    /**
     *
     */
    private function registerTaxonomy()
    {
        $labels = [
            'name' => _x('Tabbed Content Categories', 'taxonomy general name', 'transformations'),
            'singular_name' => _x('Tabbed Content', 'taxonomy singular name', 'transformations'),
            'search_items' => __('Search Tabbed Content Categories', 'transformations'),
            'popular_items' => __('Popular Tabbed Content Categories', 'transformations'),
            'all_items' => __('All Tabbed Content Categories', 'transformations'),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => __('Edit Tabbed Content Category', 'transformations'),
            'update_item' => __('Update Tabbed Content Category', 'transformations'),
            'add_new_item' => __('Add New Tabbed Content Category', 'transformations'),
            'new_item_name' => __('New Tabbed Content Category', 'transformations'),
            'separate_items_with_commas' => __('Separate drug categories with commas', 'transformations'),
            'add_or_remove_items' => __('Add or remove drug categories', 'transformations'),
            'choose_from_most_used' => __('Choose from the most used categories', 'transformations'),
            'not_found' => __('No staff categories found.', 'transformations'),
            'menu_name' => __('Tabbed Content Categories', 'transformations'),
        ];

        register_taxonomy(
            'tabbed_content_categories',
            $this->postTypeName,
            [
                'labels' => $labels,
                'public' => false,
                'show_ui' => true,
                'show_in_nav_menus' => true,
                'show_admin_column' => true,
                'rewrite' => false,
                'hierarchical' => true,
            ]
        );
    }

}