<?php

namespace App\MetaBoxes;

/**
 * Class ImageGallery
 */
class ImageGalleryUploadField extends WordPressMetaBoxAbstract
{
    /**
     * @var string
     */
    protected $nonce = 'upload_galley_nonce';

    /**
     * @var string
     */
    protected $action = 'upload_gallery';

    /**
     * @var string
     */
    protected $key = 'pi_image_slider';

    /**
     * @var string
     */
    protected $settingsNonce = 'settings_nonce';

    /**
     * @var string
     */
    protected $settingsAction = 'change_settings';

    /**
     * @param WP_Post $post The object for the current post/page.
     * @param array $callbackArgs
     */
    public function render($post, array $callbackArgs)
    {
        wp_nonce_field($this->action, $this->nonce);
        $images = get_post_meta($post->ID, $this->key, true);
        $images = empty($images) ? '[]' : $images;
        echo "
            <div id='admin-app'>
                <image-upload-gallery
                    :postId='{$post->ID}' 
                    :max='5' 
                    :current-images='$images'>
                </image-upload-gallery>
            </div>
        ";
    }

    /**
     * @param int $postId
     * @return void
     */
    public function save(int $postId)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $this->checkAndSaveImages($postId);
        $this->checkAndSaveSettings($postId);
        return;
    }

    /**
     * @param $post
     */
    public function renderSettings($post)
    {
        wp_nonce_field($this->settingsAction, $this->settingsNonce);
        $settings = get_post_meta($post->ID, 'settings', true);
        $settings = json_decode($settings, true);
        echo '<h3>Main Options</h3>';
        echo '<div class="main-options">';
        echo $this->showInputField($settings['height'] ?? null, 'height', 'Slider Height', '450');
        echo $this->showCheckBoxField($settings['opacity'] ?? null, 'opacity', 'Slide Opacity');
        echo $this->showColorPicker($settings['color'] ?? null, 'color', 'Caption and Background Color', '#000000');
        echo $this->showCheckBoxField($settings['caption'] ?? null, 'caption', 'Caption on slide');
        echo $this->showCheckBoxField($settings['arrow_option'] ?? null, 'arrow_option', 'Enable Next/Prev arrows');
        echo $this->showCheckBoxField($settings['autoplay_option'] ?? null, 'autoplay_option',
            'Enable auto play of slides');
        echo $this->showCheckBoxField($settings['indicator'] ?? null, 'indicator', 'Current slide indicator dots');
        echo $this->showInputField($settings['slide_speed'] ?? null, 'slide_speed', 'Transition speed', '300');
        echo $this->showCheckBoxField($settings['infinite'] ?? null, 'infinite', 'Enable Infinite looping');
        echo $this->showCheckBoxField($settings['pause_hover'] ?? null, 'pause_hover', 'Enable pause on hover');
        echo $this->showInputField($settings['slider_width'] ?? null, 'slider_width',
            'Slider width in pixels', '100%');
        echo $this->showInputField($settings['slide_width'] ?? null, 'slide_width',
            'Slide width in pixels. For each individual slide', '100%');
        echo $this->showInputField($settings['padding'] ?? null, 'padding', 'Padding in between each slide in pixels', '40px');
        echo $this->showInputField($settings['arrow_placement'] ?? null, 'arrow_placement', 'Arrow placement, bottom, sides', '40px');
        echo '</div>';
    }

    /**
     * @param $post
     */
    public function renderShortCode($post)
    {
        echo '<p>Use the following shortcode wherever you want the slider to display:</p>';
        echo '<p>[tt-slider id="' . $post->ID . '"]</p>';
    }

    /**
     * @param $value
     * @param $label
     * @param $text
     * @return string
     */
    protected function showCheckBoxField($value, $label, $text)
    {
        $content = '<fieldset><label for="' . $label . '">';
        $content .= $text;
        $content .= '</label> ';
        $content .= '<input type="checkbox" id="' . $label . '" name="' . $label . '"';
        $content .= ' size="25" ' . ($value == true ? 'checked' : "") . '></fieldset>';
        return $content;
    }

    /**
     * @param $value
     * @param $label
     * @param $text
     * @param $default
     * @return string
     */
    protected function showInputField($value, $label, $text, $default)
    {
        $content = '<fieldset><label for="' . $label . '">';
        $content .= $text;
        $content .= '</label> ';
        $content .= '<input type="text" id="' . $label . '" name="' . $label . '"';
        $content .= ' value="' . (!empty($value) ? esc_attr($value) : $default) . '" size="25"></fieldset>';
        return $content;
    }

    /**
     *  General Color Picker
     * @param $value
     * @param $label
     * @param $text
     * @param $default
     * @return string
     */
    protected function showColorPicker($value, $label, $text, $default)
    {
        $content = '<fieldset><label for="' . $label . '">';
        $content .= $text;
        $content .= '</label> ';
        $content .= '<input type="text" id="' . $label . '" name="' . $label . '"';
        $content .= ' value="' . (!empty($value) ? esc_attr($value) : $default) . '" size="25" class="pi-color-picker"></fieldset>';
        return $content;
    }

    /**
     * @param int $postId
     */
    private function checkAndSaveSettings(int $postId)
    {
        if (!isset($_POST[$this->settingsNonce])) {
            return;
        }

        $settingsNonce = $_POST[$this->settingsNonce];
        if (!wp_verify_nonce($settingsNonce, $this->settingsAction)) {
            return;
        }

        $opacity = isset($_POST['opacity']) ? $_POST['opacity'] : false;
        $opacity = $opacity === 'on' ? true : false;

        $caption = isset($_POST['caption']) ? $_POST['caption'] : false;
        $caption = $caption === 'on' ? true : false;

        $arrow = isset($_POST['arrow_option']) ? $_POST['arrow_option'] : false;
        $arrow = $arrow === 'on' ? true : false;

        $autoPlay = isset($_POST['autoplay_option']) ? $_POST['autoplay_option'] : false;
        $autoPlay = $autoPlay === 'on' ? true : false;

        $sliderIndicator = isset($_POST['indicator']) ? $_POST['indicator'] : false;
        $sliderIndicator = $sliderIndicator === 'on' ? true : false;

        $infiniteLooping = isset($_POST['infinite']) ? $_POST['infinite'] : false;
        $infiniteLooping = $infiniteLooping === 'on' ? true : false;

        $settings = [
            'autoplay_option' => sanitize_text_field($autoPlay),
            'indicator' => sanitize_text_field($sliderIndicator),
            'arrow_option' => sanitize_text_field($arrow),
            'pause_hover' => sanitize_text_field($_POST['pause_hover'] ?? true),
            'slide_speed' => sanitize_text_field($_POST['slide_speed'] ?? '300'),
            'height' => sanitize_text_field($_POST['height'] ?? '450'),
            'slider_width' => sanitize_text_field($_POST['slider_width'] ?? '100%'),
            'slide_width' => sanitize_text_field($_POST['slide_width'] ?? '100%'),
            'opacity' => sanitize_text_field($opacity),
            'caption' => sanitize_text_field($caption),
            'color' => sanitize_text_field($_POST['color'] ?? ''),
            'infinite' => sanitize_text_field($infiniteLooping),
            'padding' => sanitize_text_field($_POST['padding'] ?? '40px'),
            'arrow_placement' => sanitize_text_field($_POST['arrow_placement'] ?? '40px'),
        ];

        update_post_meta($postId, 'settings', wp_json_encode($settings));
    }

    /**
     * @param int $postId
     */
    private function checkAndSaveImages(int $postId)
    {
        if (!isset($_POST[$this->nonce])) {
            return;
        }

        $nonce = $_POST[$this->nonce];
        if (!wp_verify_nonce($nonce, $this->action)) {
            return;
        }

        if (!isset($_POST['images'])) {
            return;
        }

        $images = $_POST['images'];
        $images = wp_unslash($images);
        $images = json_decode($images, true);

        delete_post_meta($postId, $this->key, null);
        if (!count($images)) {
            return;
        }

        update_post_meta($postId, $this->key, wp_json_encode($images));
    }
}
