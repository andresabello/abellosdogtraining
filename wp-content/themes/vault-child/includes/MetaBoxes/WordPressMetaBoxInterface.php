<?php

/**
 * Interface WordPressMetaBox
 */
interface WordPressMetaBoxInterface
{
    /**
     * @param $post
     * @param array $callback_args
     * @return mixed
     */
    public function render($post, array $callback_args);

    /**
     * @param int $postId
     * @return mixed
     */
    public function save(int $postId);
}