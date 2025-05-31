<?php

namespace App\Admin\MenuItemFields;

/**
 * Class MenuImage
 */
class MenuImage implements MenuTypeField
{

    /**
     * @param $menuItem
     * @return mixed
     */
    public function render($menuItem)
    {
        $menuItemImageId = get_post_meta($menuItem->ID, 'menu_item_image', true);
        $attachment = wp_get_attachment_image_url($menuItemImageId, 'full');
        $menuItem->image = $attachment;
        return $menuItem;
    }

    /**
     * @param $menuId
     * @param $menuItemDbId
     * @param $args
     * @return void
     */
    public function save($menuId, $menuItemDbId, $args)
    {
        if (empty($_POST['menu_item_image'][$menuItemDbId])) {
            return;
        }

        $imageValue = $_POST['menu_item_image'][$menuItemDbId];
        update_post_meta($menuItemDbId, 'menu_item_image', $imageValue);
    }

}