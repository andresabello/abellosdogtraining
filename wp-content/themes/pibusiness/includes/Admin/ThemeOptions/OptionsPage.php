<?php

namespace App\Admin\ThemeOptions;

/**
 * Class OptionsPage
 */
class OptionsPage
{
    /**
     * @var
     */
    private $themeName;

    /**
     * @var string
     */
    private $defaultPage = 'general_settings';

    /**
     * @var array
     */
    private $themeSettings = [
        'general_settings' => [
            'value' => 'General Settings',
            'class' => GeneralOptions::class
        ],
        'home_settings' => [
            'value' => 'Home Settings',
            'class' => HomeOptions::class
        ],
        'page_settings'    => [
            'value' => 'Page Settings',
            'class' => PageOptions::class
        ],
        'footer_settings' => [
            'value' => 'Footer Settings',
            'class' => FooterOptions::class
        ],
        'css_settings' => [
            'value' => 'CSS Settings',
            'class' => CSSOptions::class
        ],
    ];

    /**
     * OptionsPage constructor.
     * @param $themeName
     */
    public function __construct($themeName)
    {
        $this->themeName = $themeName;
        $this->registerFields();
    }

    /**
     */
    public function add()
    {
        add_menu_page(
            'Theme Options',
            'Theme Options',
            'manage_options',
            stringToSlug(strtolower($this->themeName)) . '-theme-options',
            [$this, 'createAdminPage'],
            '',
            90
        );
    }

    /**
     */
    public function createAdminPage()
    {
        $tab = isset($_GET['tab']) ? $_GET['tab'] : $this->defaultPage;
        ?>
        <div class="wrap">
            <?php $this->optionsTabs(); ?>
            <br>
            <a href="#">Documentation &rarr;</a>
            <form method="post" action="options.php">
                <?php
                wp_nonce_field('update-options');
                settings_fields($tab);
                do_settings_sections($tab);
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     *
     */
    private function optionsTabs()
    {
        $current_tab = isset($_GET['tab']) ? $_GET['tab'] : $this->defaultPage;
        $output = '<h2 class="nav-tab-wrapper">';
        foreach ($this->themeSettings as $tabKey => $tab) {
            $active = $current_tab == $tabKey ? 'nav-tab-active' : '';
            $output .= '<a 
                class="nav-tab ' . $active . '" 
                href="?page=' . stringToSlug(strtolower($this->themeName)) . '-theme-options' . '&tab=' . $tabKey . '">' . $tab['value']
                . '</a>';
        }
        $output .= '</h2>';
        echo $output;
    }

    /**
     *
     */
    private function registerFields()
    {
        foreach ($this->themeSettings as $setting) {
            $className = $setting['class'];
            add_action('admin_init', [new $className($this->themeName), 'registerFields']);
        }
    }
}