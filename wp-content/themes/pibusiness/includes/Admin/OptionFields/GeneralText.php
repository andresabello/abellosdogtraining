<?php

namespace App\Admin\OptionFields;

class GeneralText extends Field
{

    public function render($value)
    {
        $optionValue = $this->options[$value] ?? null;
        $name = $this->optionKey . '[' . $value . ']';

        ob_start();
        ?>
        <input type="text" id="<?= $value ?>" name="<?= $name ?>" value="<?= $optionValue ?>" class="block">
        <?php
        $output = ob_get_contents();
        ob_end_clean();

        echo $output;
    }
}