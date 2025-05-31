<?php

namespace App\Admin\MenuItemFields;

class Flyout implements MenuTypeField
{

    /**
     * @inheritDoc
     */
    public function render($menuItem)
    {
        $flyout = get_post_meta($menuItem->ID, 'menu-item-flyout', true);
        $menuItem->flyout = $flyout;

        return $menuItem;
    }

    /**
     * @inheritDoc
     */
    public function save($menuId, $menuItemDbId, $args)
    {
        if (empty($_POST['menu-item-flyout'][$menuItemDbId])) {
            return;
        }

        $imageValue = $_POST['menu-item-flyout'][$menuItemDbId];
        update_post_meta($menuItemDbId, 'menu-item-flyout', $imageValue);
    }
}