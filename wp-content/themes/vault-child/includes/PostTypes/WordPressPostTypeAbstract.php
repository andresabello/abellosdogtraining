<?php
require __DIR__ . '/WordPressPostTypeInterface.php';

abstract class WordPressPostTypeAbstract implements WordPressPostTypeInterface
{
    /**
     * @var string
     */
    protected $themeName;

    /**
     * @var string
     */
    protected $postTypeName;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var array
     */
    protected $defaultOptions = [
        'labels' => [],
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'supports' => ['title', 'author', 'thumbnail', 'excerpt', 'comments'],
        'rewrite' => [
            'slug' => '',
        ]
    ];

    /**
     * @return array
     */
    protected function setOptionsAndLabels(): array
    {
        $singular = $this->cleanStringToHumanForm($this->postTypeName);
        $plural = strtolower(substr($singular, -1)) === 's' ? $singular : $singular . 's';
        $slug = stringToSlug($this->postTypeName);

        $labels = [
            'name' => sprintf(__('%s', $this->themeName), $plural),
            'singular_name' => sprintf(__('%s', $this->themeName), $singular),
            'menu_name' => sprintf(__('%s', $this->themeName), $plural),
            'all_items' => sprintf(__('%s', $this->themeName), $plural),
            'add_new' => __('Add New', $this->themeName),
            'add_new_item' => sprintf(__('Add New %s', $this->themeName), $singular),
            'edit_item' => sprintf(__('Edit %s', $this->themeName), $singular),
            'new_item' => sprintf(__('New %s', $this->themeName), $singular),
            'view_item' => sprintf(__('View %s', $this->themeName), $singular),
            'search_items' => sprintf(__('Search %s', $this->themeName), $plural),
            'not_found' => sprintf(__('No %s found', $this->themeName), $plural),
            'not_found_in_trash' => sprintf(__('No %s found in Trash', $this->themeName), $plural),
            'parent_item_colon' => sprintf(__('Parent %s:', $this->themeName), $singular)
        ];

        $this->defaultOptions['labels'] = $labels;
        $this->defaultOptions['rewrite']['slug'] = $slug;

        return array_replace_recursive($this->defaultOptions, $this->options);
    }

    /**
     * @param $string
     * @return string
     */
    private function cleanStringToHumanForm($string)
    {
        return ucwords(strtolower(str_replace(['_', '-'], " ", $string)));
    }
}