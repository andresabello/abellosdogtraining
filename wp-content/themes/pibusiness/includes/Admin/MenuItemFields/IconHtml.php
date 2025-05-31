<?php

namespace App\Admin\MenuItemFields;

/**
 * Class MenuImage
 */
class IconHtml implements MenuTypeField
{

    /**
     * @param $menuItem
     *
     * @return mixed
     */
    public function render($menuItem)
    {
        $menuItemColumnSize = get_post_meta($menuItem->ID, 'menu-item-column-size', true);
        $menuItem->columnSize = $menuItemColumnSize;

        return $menuItem;
    }

    /**
     * @param $menuId
     * @param $menuItemDbId
     * @param $args
     *
     * @return void
     */
    public function save($menuId, $menuItemDbId, $args)
    {
        if (empty($_POST['menu-item-column-size'][$menuItemDbId])) {
            return;
        }

        $imageValue = $_POST['menu-item-column-size'][$menuItemDbId];
        update_post_meta($menuItemDbId, 'menu-item-column-size', $imageValue);
    }

}