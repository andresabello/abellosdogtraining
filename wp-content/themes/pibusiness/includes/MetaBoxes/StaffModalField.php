<?php

namespace App\MetaBoxes;

/**
 * Class ModalField
 */
class StaffModalField extends WordPressMetaBoxAbstract
{
    /**
     * @var string
     */
    protected $nonce = 'staff_modal_field_nonce';

    /**
     * @var string
     */
    protected $action = 'staff_modal_field';

    /**
     * @var string
     */
    protected $key = 'staff_modal';

    /**
     * @param $post
     * @param array $callback_args
     * @return mixed
     */
    public function render($post, array $callback_args)
    {
        wp_nonce_field($this->action, $this->nonce);
        $modals = get_post_meta($post->ID, $this->key, true);
        $staffOptions = get_post_meta($post->ID, 'staff_options', true);
        $featuredStaffOptions = get_post_meta($post->ID, 'featured_staff_options', true);
        $modals = empty($modals) ? '[]' : $modals;
        $staffOptions = empty($staffOptions) ? '{}' : $staffOptions;
        $featuredStaffOptions = empty($featuredStaffOptions) ? '{}' : $featuredStaffOptions;
        $isSaved = false;

        if ($modals !== '[]') {
            $isSaved = true;
        }

        $isSaved = json_encode($isSaved);

        ob_start();
        ?>
        <div id="admin-app">
            <modal-field :current-modals='<?= htmlspecialchars($modals) ?>'
                         :post-id='<?= $post->ID ?>'
                         :current-featured-options='<?= $featuredStaffOptions ?>'
                         :current-options='<?= $staffOptions ?>'
                         :is-saved='<?= $isSaved ?>'></modal-field>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        echo $output;
    }

    /**
     * @param $post
     * @return void
     */
    public function renderShortCode($post)
    {
        $terms = get_the_terms($post->ID, 'staff_categories');
        if (!isset($terms[0])) {
            return null;
        }

        echo '<p>Use the following shortcode wherever you want the Staff Modal to display:</p>';
        echo '<p>[staff-modal id="' . $terms[0]->term_id . '"]</p>';
        echo PHP_EOL . ' OR ' . PHP_EOL;
        echo '<p>[staff-modal title="' . $terms[0]->name . '"]</p>';
    }

    /**
     * @param int $postId
     * @return mixed
     */
    public function save(int $postId)
    {
        // TODO: Implement save() method.
    }
}