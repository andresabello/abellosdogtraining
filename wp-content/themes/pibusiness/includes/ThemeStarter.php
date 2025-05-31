<?php

namespace App;

use App\Admin\LoadAdminFunctionality;
use App\Admin\MenuItemFields\ColumnSize;
use App\Admin\MenuItemFields\Flyout;
use App\Admin\MenuItemFields\HasBrochure;
use App\Admin\MenuItemFields\IconHtml;
use App\Admin\MenuItemFields\MenuFullWidth;
use App\Admin\MenuItemFields\MenuIcon;
use App\Admin\MenuItemFields\MenuImage;
use App\Admin\ThemeOptions\OptionsPage;
use App\Shortcodes\AccordionShortcode;
use App\Shortcodes\BootstrapColumns;
use App\Shortcodes\BootstrapRows;
use App\Shortcodes\Components;
use App\Shortcodes\MainMenuShortcode;
use App\Shortcodes\TabbedContent;
use App\Shortcodes\VideoContainer;


/**
 * Class StartTheme
 */
class ThemeStarter
{
    /**
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $themeName
     */
    protected $themeName = '';

    /**
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version
     */
    protected $version = '2.0.0';


    /**
     *
     * @since    1.0.0
     * @access   protected
     * @var      Loader $loader
     */
    protected $loader;

    /**
     * @var
     */
    protected $themeVersion;

    /**
     * StartTheme constructor.
     * @param string $themeName
     * @param string $themeVersion
     */
    public function __construct(string $themeName, string $themeVersion)
    {
        $this->setThemeName($themeName);
        $this->setThemeVersion($themeVersion);

        $this->loadDependencies();
        $this->setLocale();
        $this->defineAdminHooks();
        $this->definePublicHooks();
        $this->defineDefaultHooks();
    }

    /**
     *
     */
    public function handle()
    {
        $this->loader->run();
    }

    /**
     *
     */
    private function loadDependencies()
    {
        $this->setLoader();
    }

    /**
     *
     */
    private function setLoader()
    {
        $this->loader = $this->getLoader();
    }

    /**
     * @return Loader
     */
    private function getLoader(): Loader
    {
        return new Loader();
    }

    /**
     *
     */
    private function setLocale()
    {
        $themeI18n = new I18n();
        $themeI18n->domain = $this->themeName;
        $this->loader->addAction('theme_setup', $themeI18n, 'load_pi_directory');
    }

    /**
     *
     */
    private function defineAdminHooks()
    {
        $themeAdmin = new LoadAdminFunctionality($this->themeName, $this->version);

        $this->loader->addAction('admin_enqueue_scripts', $themeAdmin, 'enqueueStyles');
        $this->loader->addAction('admin_enqueue_scripts', $themeAdmin, 'enqueueScripts');
        $this->loader->addAction('admin_menu', new OptionsPage($this->themeName), 'add');
        $this->loader->addAction('register_form', $themeAdmin, 'showExtraRegisterFields');
        $this->loader->addAction('register_post', $themeAdmin, 'checkExtraRegisterFields', 10, 3);
        $this->loader->addAction('user_register', $themeAdmin, 'registerExtraFields', 100);
        $this->loader->addFilter('gettext', $themeAdmin, 'editPasswordEmailText');
        $this->loader->addAction('resource_category_edit_form_fields', $themeAdmin, 'resourceCategoryField', 10, 2);
        $this->loader->addAction('edited_resource_category', $themeAdmin, 'saveResourceCategoryTaxonomy', 10, 2);
    }

    /**
     *
     */
    private function definePublicHooks()
    {
        $clientFrontEnd = new LoadPublicFunctionality($this->themeName, $this->version);
        $this->loader->addAction('wp_enqueue_scripts', $clientFrontEnd, 'enqueueStyles');
        $this->loader->addAction('wp_enqueue_scripts', $clientFrontEnd, 'enqueueScripts');

        $menuImage = new MenuImage();
        $this->loader->addFilter('wp_setup_nav_menu_item', $menuImage, 'render');
        $this->loader->addAction('wp_update_nav_menu_item', $menuImage, 'save', 10, 3);

        $menuIcon = new MenuIcon();
        $this->loader->addFilter('wp_setup_nav_menu_item', $menuIcon, 'render');
        $this->loader->addAction('wp_update_nav_menu_item', $menuIcon, 'save', 10, 3);

        $menuFullWidth = new MenuFullWidth();
        $this->loader->addFilter('wp_setup_nav_menu_item', $menuFullWidth, 'render');
        $this->loader->addAction('wp_update_nav_menu_item', $menuFullWidth, 'save', 10, 3);

        $iconHtml = new IconHtml();
        $this->loader->addFilter('wp_setup_nav_menu_item', $iconHtml, 'render');
        $this->loader->addAction('wp_update_nav_menu_item', $iconHtml, 'save', 10, 3);

        $columnSize = new ColumnSize();
        $this->loader->addFilter('wp_setup_nav_menu_item', $columnSize, 'render');
        $this->loader->addAction('wp_update_nav_menu_item', $columnSize, 'save', 10, 3);

        $hasBrochure = new HasBrochure();
        $this->loader->addFilter('wp_setup_nav_menu_item', $hasBrochure, 'render');
        $this->loader->addAction('wp_update_nav_menu_item', $hasBrochure, 'save', 10, 3);

        $flyout = new Flyout();
        $this->loader->addFilter('wp_setup_nav_menu_item', $flyout, 'render');
        $this->loader->addAction('wp_update_nav_menu_item', $flyout, 'save', 10, 3);


        $this->loader->addFilter('wp_edit_nav_menu_walker', $clientFrontEnd, 'editNavWalker', 10, 2);
        $this->loader->addFilter('excerpt_more', $clientFrontEnd, 'setExcerptEnding', 10, 2);
    }

    /**
     *
     */
    private function defineDefaultHooks()
    {
        $this->loader->addShortCode('component', [
            Components::class,
            'render'
        ]);

        $this->loader->addShortCode('col', [
            BootstrapColumns::class,
            'render'
        ]);

        $this->loader->addShortCode('row', [
            BootstrapRows::class,
            'render'
        ]);

        $this->loader->addShortCode('tabbed-content', [
            TabbedContent::class,
            'render'
        ]);

        $this->loader->addShortCode('tabbed-content', [
            TabbedContent::class,
            'render'
        ]);


        $this->loader->addShortCode('main-menu', [
            MainMenuShortcode::class,
            'render'
        ]);

        $this->loader->addShortCode('video-container', [
            VideoContainer::class,
            'render'
        ]);

        $this->loader->addShortCode('accordion', [
            AccordionShortcode::class,
            'render'
        ]);
    }

    /**
     * @param mixed $themeName
     */
    private function setThemeName($themeName): void
    {
        $this->themeName = $themeName;
    }

    /**
     * @param mixed $version
     */
    private function setThemeVersion($version): void
    {
        $this->themeVersion = $version;
    }
}
