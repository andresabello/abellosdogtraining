<?php

namespace App\MetaBoxes;

class ProgramsField extends WordPressMetaBoxAbstract
{
    /**
     * @var string
     */
    protected $nonce = 'programs_field_nonce';

    /**
     * @var string
     */
    protected $action = 'programs_field';

    /**
     * @var string
     */
    protected $key = 'programs';

    /**
     * @param $post
     * @param array $callback_args
     * @return void
     */
    public function render($post, array $callback_args)
    {
        wp_nonce_field($this->action, $this->nonce);
        $programs = get_post_meta($post->ID, $this->key, true);
        $programs = empty($programs) ? '[]' : $programs;
        echo "
            <div id='admin-app'>
                <programs-field :current-programs='$programs'>
                </programs-field>
            </div>";
    }

    /**
     * @param int $postId
     * @return void
     */
    public function save(int $postId)
    {
        if (!isset($_POST[$this->nonce])) {
            return;
        }

        $nonce = $_POST[$this->nonce];
        if (!wp_verify_nonce($nonce, $this->action)) {
            return;
        }

        if (!isset($_POST['tabs'])) {
            return;
        }

        $tabs = $_POST['tabs'];
        $tabs = wp_unslash($tabs);
        $tabs = json_decode($tabs, true);
        delete_post_meta($postId, $this->key, null);
        if (!count($tabs)) {
            return;
        }

        update_post_meta($postId, $this->key, wp_json_encode($tabs));
    }
}