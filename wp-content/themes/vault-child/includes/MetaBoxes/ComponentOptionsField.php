<?php
require_once(__DIR__ . '/WordPressMetaBoxAbstract.php');
require __DIR__ . '/ShortcodeField.php';
/**
 * Class ImageGallery
 */
class ComponentOptionsField extends WordPressMetaBoxAbstract
{
    /**
     * @var string
     */
    protected $nonce = 'component_options';

    /**
     * @var string
     */
    protected $action = 'update_options';

    /**
     * @var string
     */
    protected $key = 'component_options_field';

    /**
     * @param  int  $postId
     *
     * @return void
     */
    public function save(int $postId)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $this->checkAndSaveOptions($postId);

        return;
    }

    /**
     * @param $post
     * @param  array  $callbackArgs
     */
    public function render($post, $callbackArgs)
    {
        wp_nonce_field($this->action, $this->nonce);
        $settings = get_post_meta($post->ID, 'settings', true);
        $settings = json_decode($settings, true);
        echo '<div class="main-options">';
        echo $this->showColorPicker($settings['background_color'] ?? null, 'background_color', 'Background Color',
            '#ffffff');
        echo '</div>';
    }

    /**
     *  General Color Picker
     *
     * @param $value
     * @param $label
     * @param $text
     * @param $default
     *
     * @return string
     */
    private function showColorPicker($value, $label, $text, $default)
    {
        $content = '<label for="' . $label . '">';
        $content .= $text;
        $content .= '</label> ';
        $content .= '<input type="text" id="' . $label . '" name="' . $label . '"';
        $content .= ' value="' . (! empty($value) ? esc_attr($value) : $default) . '"class="pi-color-picker">';

        return $content;
    }

    /**
     * @param  int  $postId
     */
    private function checkAndSaveOptions(int $postId)
    {
        if ( ! isset($_POST[$this->nonce])) {
            return;
        }

        $settingsNonce = $_POST[$this->nonce];
        if ( ! wp_verify_nonce($settingsNonce, $this->action)) {
            return;
        }

        if ( ! isset($_POST['background_color']) || $_POST['background_color'] === '#ffffff') {
            return;
        }

        $settings = [
            'background_color' => sanitize_text_field($_POST['background_color']),
        ];

        update_post_meta($postId, 'settings', wp_json_encode($settings));
    }
}
