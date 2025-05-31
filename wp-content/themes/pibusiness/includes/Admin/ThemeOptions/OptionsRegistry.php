<?php

namespace App\Admin\ThemeOptions;

/**
 * Class OptionsRegistry
 */
abstract class OptionsRegistry implements Options
{
    private $themeName;

    /**
     * OptionsRegistry constructor.
     * @param $themeName
     */
    public function __construct($themeName)
    {
        $this->themeName = $themeName;
    }

    /**
     */
    public function printSectionInfo()
    {
        print '<p>Enter & Upload your settings below:</p>';
    }


    /**
     */
    public function separator()
    {
        print '<hr>';
    }
}