<?php

namespace App\Admin\MenuItemFields;

/**
 * Class MenuIcon
 */
class MenuIcon implements MenuTypeField
{

    /**
     * @param $menuItem
     * @return mixed
     */
    public function render($menuItem)
    {
        $menuItemIconId = get_post_meta($menuItem->ID, 'menu_item_icon', true);
        $attachment = wp_get_attachment_image_url($menuItemIconId, 'full');
        $menuItem->icon = $attachment;
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
        if (empty($_POST['menu_item_icon'][$menuItemDbId])) {
            return;
        }

        $iconValue = $_POST['menu_item_icon'][$menuItemDbId];
        update_post_meta($menuItemDbId, 'menu_item_icon', $iconValue);
    }
}