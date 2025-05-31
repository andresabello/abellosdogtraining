<?php

namespace App\Admin\MenuItemFields;

/**
 * Class MenuImage
 */
class HasBrochure implements MenuTypeField
{

    /**
     * @param $menuItem
     *
     * @return mixed
     */
    public function render($menuItem)
    {
        $hasBrochure = get_post_meta($menuItem->ID, 'menu-item-has-brochure', true);
        $menuItem->hasBrochure = $hasBrochure;

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
        if (empty($_POST['menu-item-has-brochure'][$menuItemDbId])) {
            return;
        }

        $imageValue = $_POST['menu-item-has-brochure'][$menuItemDbId];
        update_post_meta($menuItemDbId, 'menu-item-has-brochure', $imageValue);
    }

}