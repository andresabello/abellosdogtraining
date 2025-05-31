<?php

namespace App\Admin\OptionFields;

class FontFamily extends Field
{
    private $fonts = [
        'Open Sans',
        'Droid Sans',
        'Lato',
        'Bitter',
        'Helvetica',
        'Georgia',
        'Trebuchet MS',
        'Roboto',
        'Quicksand',
        'PT Sans',
        'Hind',
        'Mulish'
    ];

    public function render($value)
    {
        $optionValue = $this->options[$value] ?? null;
        $name = $this->optionKey . '[' . $value . ']';

        ob_start();
        ?>
        <label>
            <select id="<?= $value ?>" name="<?= $name ?>">
                <?php foreach ($this->fonts as $key => $font) : ?>
                    <option value="<?= $font ?>" <?= $font === $optionValue ? 'selected="selected"' : null ?>>
                        <?= $font ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        echo $output;
    }
}