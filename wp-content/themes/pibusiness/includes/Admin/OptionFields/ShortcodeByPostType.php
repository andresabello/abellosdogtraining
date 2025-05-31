<?php

namespace App\Admin\OptionFields;

use WP_Query;

/**
 * Class ShortCodeByPostType
 */
class ShortcodeByPostType extends Field
{
    /**
     * @var string
     */
    private $postType = '';

    /**
     * @param string $postType
     */
    public function setPostType(string $postType)
    {
        $this->postType = $postType;
    }

    /**
     * @param $value
     */
    public function render($value)
    {
        $optionValue = $this->options[$value] ?? null;
        $name = $this->optionKey . '[' . $value . ']';
        $postTypes = $this->getPostTypeQuery()->get_posts();
        ob_start();
        ?>
        <label>
            <select id="<?= $value ?>" name="<?= $name ?>">
                <?php foreach ($postTypes as $key => $postType) : ?>
                    <option value="<?= $postType->ID ?>" <?= $postType === $optionValue ? 'selected="selected"' : null ?>>
                        <?= $postType->post_title ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        echo $output;
    }

    /**
     * @return WP_Query
     */
    private function getPostTypeQuery()
    {
        return new WP_Query([
            'post_type' => $this->postType,
            'order' => 'ASC'
        ]);
    }
}