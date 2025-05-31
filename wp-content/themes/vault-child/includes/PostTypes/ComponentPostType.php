<?php

require __DIR__ . '/WordPressPostTypeAbstract.php';

/**
 * Class ProgramsPostType
 */
class ComponentPostType extends WordPressPostTypeAbstract
{

    /**
     * @var string
     */
    protected $postTypeName = 'components';

    /**
     * @var
     */
    private $componentMetaBox;

    /**
     * @var
     */
    private $shortcodeMetaBox;

    /**
     * RegisterSlider constructor.
     *
     * @param string $themeName
     * @param array $options
     */
    public function __construct(string $themeName, array $options = [])
    {
        $this->themeName = $themeName;
        $this->options = $options;
        $this->defaultOptions['supports'] = ['title', 'editor', 'thumbnail'];
        $this->defaultOptions['public'] = false;
        $this->defaultOptions['publicly_queryable'] = false;
        $this->defaultOptions['show_in_rest'] = false;
        $this->defaultOptions['menu_position'] = 79;
        $this->defaultOptions['show_in_nav_menus'] = true;
        $this->defaultOptions['menu_icon'] = 'dashicons-tagcloud';
        $this->componentMetaBox = new ComponentOptionsField();
        $this->shortcodeMetaBox = new ShortcodeField('component');
    }

    /**
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        $options = $this->setOptionsAndLabels();
        if (post_type_exists($this->postTypeName)) {
            throw new Exception('Post type already exists');
        }

        register_post_type($this->postTypeName, $options);
        add_action('add_meta_boxes', [$this, 'addComponentMetaBoxes']);
        add_action('save_post', [$this->componentMetaBox, 'save']);
    }

    /**
     *
     */
    public function addComponentMetaBoxes()
    {
        add_meta_box(
            'component_options',
            __('Component Options', $this->themeName),
            [$this->componentMetaBox, 'render'],
            stringToSlug($this->postTypeName),
            'side',
            'low'
        );

        add_meta_box(
            'component_shortcode',
            __('Component Shortcode', $this->themeName),
            [$this->shortcodeMetaBox, 'render'],
            stringToSlug($this->postTypeName),
            'side',
            'low'
        );
    }
}