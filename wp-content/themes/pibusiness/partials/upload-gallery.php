<ul class="pi-images pi-uploaded <?= $additionalClasses ?>"
    data-field_id="<?= $fieldId ?>"
    data-delete_nonce="<?= $deleteNonce ?>"
    data-reorder_nonce="<?= $reorderNonce ?>"
    data-force_delete="<?= $forceDelete ?>"
    data-max_file_uploads="<?= $maxUploads ?>"
<?php foreach ($images as $image) : ?>
    <?= getTemplate('partials/upload-image.php', [
        'image' => $image,
        'deleteNonce' => $deleteNonce
    ])?>
<?php endforeach; ?>
</ul>

<div id="<?= $fieldId ?>-dragdrop"
     class="'pi-drag-drop drag-drop hide-if-no-js new-files"
     data-upload_nonce="<?= $uploadNonce ?>"
     data-js_options="<?= $fieldOptions ?>">
    <div class="drag-drop-inside">
        <p class="drag-drop-info">Drop images here</p>
        <p>Or</p>
        <p class="drag-drop-buttons">
            <input id="<?= $fieldId ?>-browse-button"
                   type="button"
                   value="Select Files"
                   class="button">
        </p>
    </div>
</div>