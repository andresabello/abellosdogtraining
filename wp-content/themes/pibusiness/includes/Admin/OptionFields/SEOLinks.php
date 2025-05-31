<?php

namespace App\Admin\OptionFields;

class SEOLinks extends Field
{

    public function render($value)
    {
        $links = isset($this->options[$value]) ? $this->options[$value] : '[]';
        $name = $this->optionKey . '[' . $value . ']';
        $name = json_encode($name);

        echo "<div id='admin-app'>
                <div is='seo-links-field' 
                    :current-links='$links' 
                    :field-name='$name'> </div>
            </div>";
    }
}