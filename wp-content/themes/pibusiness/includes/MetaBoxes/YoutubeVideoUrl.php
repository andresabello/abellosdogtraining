<?php

namespace App\MetaBoxes;

/**
 * Class TabbedTextField
 */
class YoutubeVideoUrl extends WordPressMetaBoxAbstract
{
    /**
     * @var string
     */
    protected $nonce = 'youtube_url_field_nonce';

    /**
     * @var string
     */
    protected $action = 'youtube_url_field';

    /**
     * @var string
     */
    protected $key = 'youtube_url';


    /**
     * @param $post
     * @param  array  $callback_args
     *
     * @return mixed
     */
    public function render($post, array $callback_args)
    {
        wp_nonce_field($this->action, $this->nonce);
        $meta = get_post_meta($post->ID, $this->key, true);
        echo '<div class="main-options">';
        echo $this->showInputField($meta ?? null, 'Youtube Video URL (Accepts options)', '');
        echo '</div>';
    }

    /**
     * @param  int  $postId
     *
     * @return void
     */
    public function save(int $postId)
    {
        $postType = get_post_type($postId);
        if ($postType !== 'page') {
            return;
        }

        $nonce = $_POST[$this->nonce] ?? false;
        if ( ! $nonce) {
            return;
        }

        if ( ! wp_verify_nonce($nonce, $this->action)) {
            return;
        }

        if ( ! isset($_POST[$this->key])) {
            return;
        }

        $callToAction = $_POST[$this->key];
        update_post_meta($postId, $this->key, sanitize_text_field($callToAction));
    }

    /**
     * @param $value
     * @param $label
     * @param $text
     * @param $default
     *
     * @return string
     */
    private function showInputField($value, $text, $default)
    {
        $content = '<label for="' . $this->key . '">' . $text . '</label> ';
        $content .= '<input style="width: 100%; display: block; height: 30px;" type="text" id="' . $this->key . '" name="' . $this->key . '" value=' . (! empty($value) ? esc_textarea($value) : $default) . '>';

        return $content;
    }
}