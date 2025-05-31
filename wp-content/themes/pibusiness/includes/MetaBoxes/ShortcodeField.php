<?php

namespace App\MetaBoxes;

/**
 * Class ImageGallery
 */
class ShortcodeField extends WordPressMetaBoxAbstract
{

    /**
     * @var
     */
    private $name;

    /**
     * ShortcodeField constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

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

        return;
    }

    /**
     * @param $post
     * @param  array  $callbackArgs
     */
    public function render($post, array $callbackArgs)
    {
        echo '<p>Use the following shortcode wherever you want the slider to display:</p>';
        echo "<p>[{$this->name} id='{$post->ID}']</p>";
        echo "<p>[{$this->name} title='{$post->post_title}']</p>";
    }
}
