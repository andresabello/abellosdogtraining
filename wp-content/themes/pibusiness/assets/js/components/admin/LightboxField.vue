<template>
    <div class="container-fluid">
        <draggable :list="images" :disabled="!enabled" ghost-class="ghost" @start="dragging = true"
                   @end="onDraggingEnded">

            <div class="lightbox mt-5" v-for="(element, index) in images" :key="index">
                <div class="row">
                    <div class="col-1">
                        <span class="dashicons dashicons-move"></span>
                    </div>
                    <div class="col-10">
                        <div class="row">
                            <div class="col-12">
                                <img :src="element.image.url" :alt="element.image.title" height="300">
                                <button class="button" @click.prevent="changeImage(image)">Change Image</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-1">
                        <span class="dashicons dashicons-dismiss" @click="removeLightbox(index)"></span>
                    </div>
                </div>
            </div>
        </draggable>

        <br v-show="images.length">

        <div class="form-wrapper" v-if="currentFormActive">
            <div class="row">
                <div class="col-12">
                    <h4>Add a new Image</h4>
                </div>
                <div class="col-12">
                    <div class="image-upload-wrapper">
                        <img :src="currentLightbox.image.url" :alt="currentLightbox.image.title"
                             v-if="currentLightbox.image.url" height="300">
                        <button @click.prevent="uploadImage" class="button">Add Image</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <input type="hidden" name="images" id="images" :value="lightboxesJson">
                <button type="button" class="button button-primary" v-show="isCurrentFormDone"
                        @click="saveLightbox">
                    Save Image to Lightbox
                </button>
                <button type="button" class="button button-primary"
                        v-show="this.images.length >= 1 && isCurrentFormEmpty" @click="addLightbox">
                    Add Image To Lightbox
                </button>
            </div>
        </div>

    </div>
</template>

<script>
    import axios from 'axios'
    import draggable from 'vuedraggable'
    import Modal from './../admin/utilities/Modal.vue'

    const initialLightbox = {
        title: '',
        url: '',
        image: '',
    }

    export default {
        name: 'lightbox-field',
        data () {
            return {
                enabled: true,
                dragging: false,
                images: [],
                currentFormActive: true,
                currentLightbox: {...initialLightbox},
                typingTimer: null,
                doneTypingInterval: 2000,
            }
        },
        props: {
            postId: {
                type: Number,
                required: true,
                default () {
                    return null
                },
            },
            currentLightboxes: {
                type: Array,
                default () {
                    return []
                },
            },
        },
        computed: {
            lightboxesJson () {
                return JSON.stringify(this.images)
            },
            isCurrentFormDone () {
                return this.currentLightbox.image !== ''
            },
            isCurrentFormEmpty () {
                return JSON.stringify(this.currentLightbox) === JSON.stringify({...initialLightbox})
            },
        },
        mounted () {
            if (this.currentLightboxes.length) {
                this.currentLightboxes.forEach((currentLightbox) => {
                    this.images.push(currentLightbox)
                })
                this.currentFormActive = false
            }
        },
        methods: {
            saveLightbox () {
                this.currentFormActive = false
                this.images.push(this.currentLightbox)
                this.currentLightbox = {...initialLightbox}
                this.submitImages()
            },
            addLightbox () {
                this.currentFormActive = true
            },
            removeLightbox (index) {
                this.images = this.images.filter((lightbox, currentLightboxIndex) => {
                    return index !== currentLightboxIndex
                })
                this.submitImages()
            },
            uploadImage () {
                this.wpUploadImage(this.currentLightbox)
                this.submitImages()
            },
            changeImage (image) {
                this.wpUploadImage(image)
                this.submitImages()
            },
            wpUploadImage (el) {
                let uploader = wp.media({
                    title: 'Insert image',
                    library: {
                        type: 'image',
                    },
                    button: {
                        text: 'Use this image',
                    },
                    multiple: false,
                }).on('select', () => {
                    el.image = uploader.state().get('selection').first().toJSON()
                }).open()
            },
            onKeyUp () {
                clearTimeout(this.typingTimer)
                this.typingTimer = setTimeout(this.submitImages, this.doneTypingInterval)
            },

            onKeyDown () {
                clearTimeout(this.typingTimer)
            },
            submitImages () {
                let formData = new FormData
                formData.append('action', 'lightbox')
                formData.append('post_id', this.postId)
                formData.append('images', JSON.stringify(this.images))
                axios.post(ajaxObject.url, formData)
            },
            onDraggingEnded () {
                this.dragging = false
                this.submitImages()
            },
        },
        components: {
            draggable,
            Modal,
        },
    }
</script>
<style scoped lang="scss">

    .lightbox {
        margin-bottom: 20px;
        position: relative;
    }
</style>