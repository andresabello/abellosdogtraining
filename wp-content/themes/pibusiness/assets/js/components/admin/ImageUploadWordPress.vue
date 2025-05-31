<template>
    <div class="upload">
        <input type="button"
               class="button button-upload pi-upload-image "
               value="Upload Image">

        <img :src="image.src" class="preview-upload">
    </div>
</template>

<script>
    export default {
        name: 'ImageUploadWordPress',
        data() {
            return {
                image: {
                    src: ''
                }
            }
        }
    }
</script>

<style scoped>

</style>