<?php

namespace App\MetaBoxes;

/**
 * Class WordPressMetaBoxAbstract
 */
abstract class WordPressMetaBoxAbstract implements WordPressMetaBoxInterface
{
    /**
     * @var
     */
    protected $nonce;

    /**
     * @var
     */
    protected $action;

    /**
     * @var
     */
    protected $key;
}