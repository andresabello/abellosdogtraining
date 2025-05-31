<?php

namespace App\Menu;

/**
 * Class MenuBuilder
 * @package App\Menu
 */
class MenuBuilder
{
    /**
     * @param string $navigationSlug
     * @return array
     */
    public static function build(string $navigationSlug = 'main'): array
    {

        $items = wp_get_nav_menu_items($navigationSlug);

        if (!$items) {
            return [];
        }

        return self::buildTree($items, 0);
    }

    /**
     * @param array $elements
     * @param int $parentId
     * @return array
     */
    private static function buildTree(array &$elements, int $parentId = 0): array
    {
        $branch = [];
        foreach ($elements as &$element) {

            if ($element->object === 'components') {
                $post = get_post($element->object_id);
                $element->post_content = $post->post_content;
            }

            if ($element->menu_item_parent != $parentId) {
                continue;
            }

            $children = self::buildTree($elements, $element->ID);
            if ($children) {
                $element->children = $children;
            }

            $branch[$element->ID] = $element;
            unset($element);
        }

        usort($branch, function ($a, $b) {
            return $a->menu_order <=> $b->menu_order;
        });

        return $branch;
    }
}