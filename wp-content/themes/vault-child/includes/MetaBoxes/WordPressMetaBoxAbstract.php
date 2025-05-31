<?php
require_once(__DIR__ . '/WordPressMetaBoxInterfaceEl.php');
/**
 * Class WordPressMetaBoxAbstract
 */
abstract class WordPressMetaBoxAbstract implements WordPressMetaBoxInterfaceEl
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