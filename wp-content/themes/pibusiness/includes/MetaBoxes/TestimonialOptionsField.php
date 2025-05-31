<?php

namespace App\MetaBoxes;

/**
 * Class ImageGallery
 */
class TestimonialOptionsField extends WordPressMetaBoxAbstract
{
    /**
     * @var string
     */
    protected $nonce = 'testimonial_options';

    /**
     * @var string
     */
    protected $action = 'update_options';

    /**
     * @var string
     */
    protected $key = 'testimonial_options_field';

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
        echo $this->showInputField($settings['author'] ?? null, 'author', 'Author Name', '');
        echo '</div>';
    }


    /**
     * @param $value
     * @param $label
     * @param $text
     * @param $default
     * @return string
     */
    private function showInputField($value, $label, $text, $default)
    {
        $content = '<label for="' . $label . '">';
        $content .= $text;
        $content .= ': </label> ';
        $content .= '<input style="width: 100%; display: block; height: 30px;" type="text" id="' . $label . '" name="' . $label . '"';
        $content .= ' value="' . (!empty($value) ? esc_attr($value) : $default) . '">';
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

        if ( ! isset($_POST['author'])) {
            return;
        }

        $settings = [
            'author' => sanitize_text_field($_POST['author']),
        ];

        update_post_meta($postId, 'settings', wp_json_encode($settings));
    }
}
