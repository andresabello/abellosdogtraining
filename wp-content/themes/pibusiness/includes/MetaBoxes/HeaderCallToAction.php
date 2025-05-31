<?php

namespace App\MetaBoxes;

/**
 * Class TabbedTextField
 */
class HeaderCallToAction extends WordPressMetaBoxAbstract
{
    /**
     * @var string
     */
    protected $nonce = 'header_cta_field_nonce';

    /**
     * @var string
     */
    protected $action = 'header_cta_field';

    /**
     * @var string
     */
    protected $key = 'header_cta';


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
        echo $this->showInputField($meta ?? null, 'call_to_action', 'Call to Action HTML', '');
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

        if ( ! isset($_POST['call_to_action'])) {
            return;
        }

        $callToAction = $_POST['call_to_action'];
        update_post_meta($postId, $this->key, wp_kses_post($callToAction));
    }

    /**
     * @param $value
     * @param $label
     * @param $text
     * @param $default
     *
     * @return string
     */
    private function showInputField($value, $label, $text, $default)
    {
        $content = '<label for="' . $label . '">' . $text . '</label> ';
        $content .= '<textarea style="width: 100%; display: block; height: 170px;" type="text" id="' . $label . '" name="' . $label . '">';
        $content .= (! empty($value) ? esc_html($value) : $default) . '</textarea>';

        return $content;
    }
}