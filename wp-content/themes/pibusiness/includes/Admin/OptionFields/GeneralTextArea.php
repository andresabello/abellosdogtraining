<?php

namespace App\Admin\OptionFields;

class GeneralTextArea extends Field
{

    public function render($value)
    {
        $optionValue = $this->options[$value] ?? null;
        $name = $this->optionKey . '[' . $value . ']';

        ob_start();
        ?>
        <label><textarea type="text"
                         id="<?= $value ?>"
                         rows="10"
                         cols="50"
                         class="block"
                         name="<?= $name ?>"><?= $optionValue ?></textarea></label>
        <?php
        $output = ob_get_contents();
        ob_end_clean();

        echo $output;
    }
}