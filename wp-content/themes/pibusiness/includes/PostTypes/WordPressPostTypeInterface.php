<?php

namespace App\PostTypes;

/**
 * Interface WordPressPostTypeInterface
 */
interface WordPressPostTypeInterface
{
    /**
     * @return mixed
     */
    public function handle();
}