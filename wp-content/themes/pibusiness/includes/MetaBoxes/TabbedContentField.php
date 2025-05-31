<?php

namespace App\MetaBoxes;

/**
 * Class TabbedTextField
 */
class TabbedContentField extends WordPressMetaBoxAbstract
{
    /**
     * @var string
     */
    protected $nonce = 'tabbed_content_field_nonce';

    /**
     * @var string
     */
    protected $action = 'tabbed_content_field';

    /**
     * @var string
     */
    protected $key = 'tabbed_content';

    /**
     * @param $post
     * @param array $callback_args
     * @return mixed
     */
    public function render($post, array $callback_args)
    {
        wp_nonce_field($this->action, $this->nonce);
        $tabs = get_post_meta($post->ID, $this->key, true);
        $tabs = empty($tabs) ? '[]' : $tabs;

        if ($tabs !== '[]') {
            $tabs = json_decode($tabs, true);
            foreach ($tabs as $index => $tab) {
                $tabs[$index]['text'] = htmlspecialchars_decode($tab['text']);
            }

            $tabs = json_encode($tabs);
        }

        ob_start();
        ?>

        <div id="admin-app">
            <tabbed-content-field :post-id="<?= $post->ID ?>"
                                  :current-tabs='<?= htmlspecialchars($tabs) ?>'></tabbed-content-field>
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

        $tabs = wp_unslash($_POST['tabs']);
        $tabs = json_decode($tabs, true);

        foreach ($tabs as $index => $tab) {
            $tabs[$index]['text'] = str_replace(
                ['""', '<p><br/></p>', '<p><br></p>', '<p></p>', '<p> </p>'],
                '',
                htmlspecialchars($tab['text'])
            );
        }

        delete_post_meta($postId, $this->key, null);
        if (empty($tabs)) {
            return;
        }

        update_post_meta($postId, $this->key, json_encode($tabs));
    }

    /**
     * @param $post
     * @return void
     */
    public function renderShortCode($post)
    {
        $terms = get_the_terms($post->ID, 'tabbed_content_categories');
        if (!isset($terms[0])) {
            return null;
        }

        echo '<p>Use the following shortcode wherever you want the Tabbed Content to display:</p>';
        echo '<p>[tabbed-content id="' . $terms[0]->term_id . '"]</p>';
        echo PHP_EOL . ' OR ' . PHP_EOL;
        echo '<p>[tabbed-content title="' . $terms[0]->name . '"]</p>';
    }
}