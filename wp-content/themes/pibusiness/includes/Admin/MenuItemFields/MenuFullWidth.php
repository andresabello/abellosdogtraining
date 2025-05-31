<?php

namespace App\Admin\MenuItemFields;

/**
 * Class MenuType
 */
class MenuFullWidth implements MenuTypeField
{
    /**
     * @param $menuItem
     * @return mixed
     */
    public function render($menuItem)
    {
        $menuItem->full_width = get_post_meta($menuItem->ID, 'menu_full_width', true);
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
        if (empty($_POST['menu-item-full-width'][$menuItemDbId])) {
            delete_post_meta($menuItemDbId, 'menu_full_width');
            return;
        }

        update_post_meta($menuItemDbId, 'menu_full_width', $_POST['menu-item-full-width'][$menuItemDbId]);
    }
}