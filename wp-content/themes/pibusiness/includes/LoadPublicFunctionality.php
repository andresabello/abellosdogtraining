<?php

namespace App;

use App\Admin\MenuItemFields\CustomEditMenuNavWalker;

/**
 * Class LoadFunctionality
 */
class LoadPublicFunctionality
{

    /**
     * @var
     */
    private $themeName;
    /**
     * @var
     */
    private $version;

    /**
     * LoadFunctionality constructor.
     * @param $themeName
     * @param $version
     */
    public function __construct($themeName, $version)
    {
        $this->themeName = $themeName;
        $this->version = $version;
    }

    /**
     *
     */
    public function enqueueStyles()
    {
        wp_dequeue_style('bootstrap');
        wp_dequeue_style('fsn_bootstrap');
        wp_dequeue_style('fsn_core');
        wp_enqueue_style($this->themeName, $this->findAsset('front.css'), [], $this->version);

        $options = get_option('general_settings');
        $font = $options['pi_font_family'] ?? '';
        $this->setFont($font);
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueueScripts()
    {
        wp_dequeue_script('bootstrap');
        wp_dequeue_script('modernizr');
        wp_dequeue_script('images_loaded');
        wp_dequeue_script('fsn_core');
        wp_dequeue_script('fsn_core_query');
        wp_dequeue_script('jquery');

        wp_enqueue_script('wp-api');
        wp_localize_script('wp-api', 'wpApiSettings', [
            'root' => esc_url_raw(rest_url()),
            'nonce' => wp_create_nonce('wp_rest')
        ]);
        wp_enqueue_script('vendors', $this->findAsset('vendors.js'), null, $this->version, true);
        wp_enqueue_script('runtime', $this->findAsset('runtime.js'), null, $this->version, true);
        wp_enqueue_script('main', $this->findAsset('front.js'), ['vendors', 'runtime'], $this->version, true);
        wp_localize_script('main', 'ajaxObject', [
            'url' => admin_url('admin-ajax.php')
        ]);
    }

    /**
     * @return string
     */
    public function editNavWalker()
    {
        return CustomEditMenuNavWalker::class;
    }


    /**
     * @param string $font
     */
    private function setFont(string $font)
    {
        if ($font === 'Droid Sans') {
            wp_enqueue_style('droid-sans', 'http://fonts.googleapis.com/css?family=Droid+Sans:400,700');
            return;
        }

        if ($font === 'Open Sans') {
            wp_enqueue_style('open-sans', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800&display=swap');
            return;
        }

        if ($font === 'Lato') {
            wp_enqueue_style('lato', 'http://fonts.googleapis.com/css?family=Lato:400,700');
            return;
        }

        if ($font === 'Bitter') {
            wp_enqueue_style('Bitter', 'http://fonts.googleapis.com/css?family=Bitter:400,700');
            return;
        }

        if ($font === 'Roboto') {
            wp_enqueue_style('roboto',
                'https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap');

            return;
        }

        if ($font === 'Nunito Sans') {
            wp_enqueue_style('nunito-sans',
                'https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900&display=swap');

            return;
        }

        if ($font === 'Quicksand') {
            wp_enqueue_style('quicksand',
                'https://fonts.googleapis.com/css?family=Quicksand:300,400,700&display=swap');
            return;
        }

        if ($font === 'PT Sans') {
            wp_enqueue_style('pt_sans',
                'https://fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap');
            return;
        }

        if ($font === 'Hind') {
            wp_enqueue_style('hind',
                'https://fonts.googleapis.com/css2?family=Hind:wght@300;400;700&display=swap');
            return;
        }

        if ($font === 'Mulish') {
            wp_enqueue_style('mulish',
                'https://fonts.googleapis.com/css2?family=Mulish:wght@100;400;800&display=swap');

            return;
        }

        return;
    }

    /**
     * @param $excerpt
     * @return string
     */
    public function setExcerptEnding($excerpt)
    {
        return '...';
    }

    /**
     * @param $path
     * @return mixed|string
     */
    protected function findAsset($path)
    {
        if (!file_exists(ASSETS . '/dist/manifest.json')) {
            return '/wp-content/themes/pibusiness/assets/dist/' . $path;
        }

        $manifest = file_get_contents(ASSETS . '/dist/manifest.json');
        $manifest = json_decode($manifest, true);
        return $manifest[$path];
    }
}