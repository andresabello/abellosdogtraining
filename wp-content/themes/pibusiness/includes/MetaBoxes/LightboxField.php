<?php

namespace App\MetaBoxes;

/**
 * Class ModalField
 */
class LightboxField extends WordPressMetaBoxAbstract
{
    /**
     * @var string
     */
    protected $nonce = 'lightbox_field_nonce';

    /**
     * @var string
     */
    protected $action = 'lightbox_field';

    /**
     * @var string
     */
    protected $key = 'lightbox_images';

    /**
     * @param $post
     * @param array $callback_args
     * @return void
     */
    public function render($post, array $callback_args)
    {
        wp_nonce_field($this->action, $this->nonce);
        $images = get_post_meta($post->ID, $this->key, true);
        $images = empty($images) ? json_encode([]) : $images;
        ob_start();
        ?>
        <div id='admin-app'>
            <div is="lightbox-field" :current-lightboxes='<?= $images ?>' :post-id='<?= $post->ID ?>'></div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();

        echo $output;
    }

    /**
     * @param int $postId
     * @return void
     */
    public function save($postId)
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

    /**
     * @param $post
     */
    public function renderShortCode($post)
    {
        echo '<p>Use the following shortcode wherever you want the Lightbox to display:</p>';
        echo '<p>[lightbox id="' . $post->ID . '"]</p>';
        if ($post->post_name) {
            echo PHP_EOL . ' OR ' . PHP_EOL;
            echo '<p>[lightbox title="' . $post->post_name . '"]</p>';
        }
    }
}