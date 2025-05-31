<template>
    <div class="container-fluid">
        <draggable :list="images"
                   :disabled="!enabled"
                   ghost-class="ghost"
                   @start="dragging = true"
                   @end="dragging = false">

            <div class="slide" v-for="image in images" :key="image.id">
                <div class="row">
                    <div class="col-1">
                        <span class="dashicons dashicons-move"></span>
                    </div>
                    <div class="col-10">
                        <img :src="image.url" :alt="image.title" class="slide img img-fluid">
                    </div>
                    <div class="col-1">
                        <span class="dashicons dashicons-edit" @click="editImage(image)"></span>
                        <span class="dashicons dashicons-dismiss" @click="removeImage(image.id)"></span>
                    </div>
                </div>
            </div>

        </draggable>

        <br v-show="images.length">

        <div class="row">
            <div class="col-12">
                <button type="button" class="button button-primary" @click="uploadImage">Add Slide</button>
                <label>
                    <input type="text" v-show="false" name="images" :value="imagesJson">
                </label>
            </div>
        </div>

        <modal :active="isModalActive" icons="dashicons dashicons-dismiss" @hide="isModalActive = false">
            <h3 slot="header">
                Image Caption
            </h3>
            <div class="wrapper" slot="content">
                <label>
                    <textarea cols="30" rows="10" v-model="editingImage.caption"></textarea>
                </label>
                <button type="button" class="button button-primary" @click="saveImage" style="margin-top: 20px;">
                    Save Caption
                </button>
            </div>
        </modal>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'
    import Modal from './utilities/Modal.vue'

    export default {
        name: 'image-upload-gallery',
        data () {
            return {
                enabled: true,
                dragging: false,
                images: [],
                isModalActive: false,
                editingImage: {
                    id: null,
                    caption: null,
                },
            }
        },
        props: {
            currentImages: {
                type: Array,
                default () {
                    return []
                },
            },
            max: {
                type: Number,
                default: 5,
            },
        },
        computed: {
            imagesJson () {
                return JSON.stringify(this.images)
            },
        },
        mounted () {
            if (this.currentImages.length) {
                this.currentImages.forEach((currentImage) => {
                    this.images.push(currentImage)
                })
            }
        },
        methods: {
            uploadImage () {
                let uploader = wp.media({
                    title: 'Insert image',
                    library: {
                        type: 'image',
                    },
                    button: {
                        text: 'Use this image',
                    },
                    multiple: true,
                }).on('select', () => {

                    this.images.push(uploader.state().
                        get('selection').
                        first().
                        toJSON(),
                    )
                }).open()
            },
            removeImage (imageId) {
                this.images = this.images.filter((image) => {
                    return image.id !== imageId
                })
            },
            editImage (image) {
                this.isModalActive = true
                this.editingImage = image
            },
            saveImage () {
                this.removeImage(this.editingImage.id)
                this.images.push(this.editingImage)
                this.isModalActive = false
                this.editingImage = {
                    id: null,
                    caption: null,
                }
            },
        },
        components: {
            draggable,
            Modal,
        },
    }
</script>

<style scoped lang="scss">
    .slide {
        position: relative;
        margin-top: 20px;
        margin-bottom: 20px;
        border: 1px dotted #ddd;
        padding: 10px;

        &:last-child {
            margin-bottom: 0;
        }

        img {
            border: 0;
            margin: 0 auto;
        }
    }
</style>