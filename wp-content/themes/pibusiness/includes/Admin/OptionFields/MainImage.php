<?php

namespace App\Admin\OptionFields;

/**
 * Class MainImage. Renders image upload field in admin
 */
class MainImage extends Field
{
    /**
     * @param $value
     * @return void
     */
    public function render($value)
    {
        $templateData = [
            'value' => '',
            'name' => $this->optionKey . '[' . $value . ']',
            'imageSrc' => '',
        ];

        if ($value && isset($this->options[$value])) {
            $attachmentId = $this->options[$value];
            $attachmentUrl = wp_get_attachment_image_url($attachmentId, 'full');
            $templateData['imageSrc'] = esc_url($attachmentUrl);
            $templateData['value'] = $this->options[$value];
        }

        print getTemplate('partials/upload-field.php', $templateData);
    }

}