<?php

namespace App\Admin\OptionFields;

class ColorPicker extends Field
{
    public function render($value)
    {
        $optionValue = $this->options[$value] ?? null;
        $name = $this->optionKey . '[' . $value . ']';

        ob_start();
        ?>
        <label>
            <input type="text" id="<?= $value ?>" name="<?= $name ?>" value="<?= $optionValue ?>"
                   class="pi-color-picker">
        </label>
        <?php
        $output = ob_get_contents();
        ob_end_clean();

        echo $output;
    }
}