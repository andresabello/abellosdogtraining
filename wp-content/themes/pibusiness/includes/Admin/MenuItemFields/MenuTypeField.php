<?php

namespace App\Admin\MenuItemFields;

/**
 * Interface MenuTypeField
 */
interface MenuTypeField
{
    /**
     * @param $menuItem
     * @return mixed
     */
    public function render($menuItem);

    /**
     * @param $menuId
     * @param $menuItemDbId
     * @param $args
     * @return mixed
     */
    public function save($menuId, $menuItemDbId, $args);
}