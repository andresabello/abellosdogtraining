<?php

namespace App\Admin\OptionFields;

/**
 * Class Field
 */
abstract class Field implements OptionField
{
    /**
     * @var array
     */
    protected $optionKey = '';

    /**
     * @var array|mixed|void
     */
    protected $options = [];

    /**
     * MainImage constructor.
     * @param $optionKey
     */
    public function __construct($optionKey)
    {
        $this->optionKey = $optionKey;
        $this->options = get_option($this->optionKey);
    }
}