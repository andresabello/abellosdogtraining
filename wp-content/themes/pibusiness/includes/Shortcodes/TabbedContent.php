<?php

namespace App\Shortcodes;

use App\Adapters\PostsGetter;

class TabbedContent implements ShortCodePresenter
{
    /**
     * @var array
     */
    protected static $defaultAttributes = [
        'id' => null,
        'title' => '',
        'text' => '',
        'url' => '',
        'button_text' => '',
        'image' => ''
    ];

    /**
     * @var string
     */
    protected static $key = 'tabbed_content';

    /**
     * @param array $attributes
     * @param string $content
     * @param string $name
     * @return mixed|void
     */
    public static function render($attributes, $content = '', $name = '')
    {
        $filteredAttributes = shortcode_atts(self::$defaultAttributes, $attributes, $name);
        if (!isset($filteredAttributes['id']) && !isset($filteredAttributes['title'])) {
            return;
        }

        $termId = $filteredAttributes['id'];
        $termTitle = $filteredAttributes['title'];
        $term = null;


        if (!empty($termTitle)) {
            $term = get_term_by('name', $termTitle, 'tabbed_content_categories', OBJECT);
        }

        if (empty($termId) && !$term) {
            $term = get_term_by('id', $termId, 'tabbed_content_categories', OBJECT);
        }


        if (!isset($term->term_id)) {
            return ;
        }

        $id = uniqid();
        $returnedTabs = [];
//        $termMeta = get_term_meta($term->term_id, '', true);
        $tabs = (new PostsGetter())
            ->setPostType('tabbed_content')
            ->setPerPage(-1)
            ->setTermField('id')
            ->setTermSlug($term->term_id)
            ->setTaxonomy('tabbed_content_categories')
            ->getPosts();


        foreach ($tabs as $index => $tab) {
            $meta = get_post_meta($tab->ID);
            $srcSet = wp_get_attachment_image_srcset($tab->ID);
            $returnedTabs[$index]['order'] = $tab->menu_order;
            $returnedTabs[$index]['text'] = $tab->post_content;
            $returnedTabs[$index]['image'] = $tab->image_url;
            $returnedTabs[$index]['imageSrcset'] = isset($srcSet) ? $srcSet : null;
            $returnedTabs[$index]['title'] = $tab->post_title;
            $returnedTabs[$index]['button_text'] = isset($meta['button_text'][0]) ? $meta['button_text'][0] : null;
            $returnedTabs[$index]['url'] = isset($meta['url'][0]) ? $meta['url'][0] : null;
        }
        usort($returnedTabs, function ($a, $b) {
            return $a['order'] - $b['order'];
        });
        $returnedTabs = empty($returnedTabs) ? [] : $returnedTabs;
        $returnedTabs = htmlspecialchars(json_encode($returnedTabs));

        ob_start();
        ?>
        <div class="tabbed-content tabbed-content-<?= $id ?>" data-id="<?= $id ?>">
            <div is="tabbed-content" :tabs="<?= $returnedTabs ?>"></div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}