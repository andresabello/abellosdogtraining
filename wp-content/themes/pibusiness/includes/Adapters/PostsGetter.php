<?php

namespace App\Adapters;

/**
 * Class PostsGetter
 * @package App\Adapters
 */
class PostsGetter
{
    /**
     * @var
     */
    protected $page;


    /**
     * @var
     */
    protected $slug;

    /**
     * @var
     */
    protected $postType;

    /**
     * @var
     */
    protected $termSlug;

    /**
     * @var
     */
    protected $termField = 'slug';

    /**
     * @var
     */
    protected $taxonomy;

    /**
     * @var
     */
    protected $perPage;

    /**
     * @var
     */
    protected $included = [];

    /**
     * @var
     */
    protected $excluded = [];

    /**
     * @var string
     */
    protected $status = 'publish';

    /**
     * @param array $args
     * @return int[]|\WP_Post[]
     */
    public function getPosts(array $args = [])
    {
        if (count($this->included)) {
            $args['post__in'] = $this->included;
        }

        if (count($this->excluded)) {
            $args['post__not_in'] = $this->excluded;
        }

        if (!count($this->included) && !count($this->excluded)) {
            $args = array_merge($args, [
                'post_type' => $this->postType,
                'post_status' => $this->status,
                'posts_per_page' => $this->perPage,
                'offset' => $this->page,
            ]);


            if (!empty($this->termSlug)) {
                $args = $this->getCategory($args);
            }
        }
        $posts = get_posts($args);
        foreach ($posts as &$post) {
            $imageId = get_post_thumbnail_id($post->ID);
            $post->image_url = wp_get_attachment_image_url($imageId, 'full');
            $post->image_sizes = wp_get_attachment_image_sizes($imageId, 'full');
            $post->image_srcset = wp_get_attachment_image_srcset($imageId, 'full');
            $post->link = get_permalink($post->ID);
        }

        return $posts;
    }

    /**
     * @param mixed $included
     * @return PostsGetter
     */
    public function setIncluded($included): PostsGetter
    {
        $this->included = $included;
        return $this;
    }


    /**
     * @param mixed $excluded
     * @return PostsGetter
     */
    public function setExcluded($excluded): PostsGetter
    {
        $this->excluded = $excluded;
        return $this;
    }

    /**
     * @param mixed $page
     * @return PostsGetter
     */
    public function setPage($page): PostsGetter
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @param mixed $perPage
     * @return PostsGetter
     */
    public function setPerPage($perPage): PostsGetter
    {
        $this->perPage = $perPage;
        return $this;
    }

    /**
     * @param mixed $slug
     * @return PostsGetter
     */
    public function setSlug($slug): PostsGetter
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @param mixed $postType
     * @return PostsGetter
     */
    public function setPostType($postType): PostsGetter
    {
        $this->postType = $postType;
        return $this;
    }

    /**
     * @param mixed $termSlug
     * @return PostsGetter
     */
    public function setTermSlug($termSlug): PostsGetter
    {
        $this->termSlug = $termSlug;
        return $this;
    }

    /**
     * @param mixed $taxonomy
     * @return PostsGetter
     */
    public function setTaxonomy($taxonomy): PostsGetter
    {
        $this->taxonomy = $taxonomy;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getTermField()
    {
        return $this->termField;
    }

    /**
     * @param mixed $termField
     * @return PostsGetter
     */
    public function setTermField($termField): PostsGetter
    {
        $this->termField = $termField;
        return $this;
    }

    /**
     * @param array $args
     * @return array
     */
    private function getCategory(array $args): array
    {
        if ($this->postType === 'post') {
            $args['category_name'] = $this->termSlug;
            return $args;
        }

        $args['tax_query'] = [
            [
                'taxonomy' => $this->taxonomy,
                'field' => $this->termField,
                'terms' => $this->termSlug,
            ]
        ];
        return $args;
    }
}