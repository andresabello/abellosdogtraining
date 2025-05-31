<?php

namespace App\Admin\MenuItemFields;

/**
 * Class MenuImage
 */
class ColumnSize implements MenuTypeField
{

    /**
     * @param $menuItem
     *
     * @return mixed
     */
    public function render($menuItem)
    {
        $menuIconHtml = get_post_meta($menuItem->ID, 'menu_item_icon_html', true);
        $menuItem->iconHtml = $menuIconHtml;

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
        if (empty($_POST['menu_item_icon_html'][$menuItemDbId])) {
            return;
        }

        $imageValue = $_POST['menu_item_icon_html'][$menuItemDbId];
        update_post_meta($menuItemDbId, 'menu_item_icon_html', $imageValue);
    }

}