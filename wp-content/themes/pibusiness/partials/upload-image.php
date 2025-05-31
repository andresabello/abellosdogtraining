
<li id="item_<?= $image['id'] ?>">
    <img src="<?= $image['src'] ?>" alt=""/>
    <div class="pi-image-bar">
        <a title="Upload Image"
           class="pi-edit-file"
           href="<?= $image['link'] ?>"
           target="_blank">Edit Image</a> |
        <a title="Delete Image" class="pi-delete-file" href="#"
           data-attachment_id="<?= $image['id'] ?>">&times;</a>
    </div>
</li>
