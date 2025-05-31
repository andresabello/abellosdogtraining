<template>
    <div class="container-fluid">

        <div class="section-options" v-if="featuredModals.length">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title">Featured Staff</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>
                        Columns:
                        <select v-model="featuredOptions.columns">
                            <option v-for="column in columnSizes" :value="column">{{column}}</option>
                        </select>
                    </label>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-12">
                    Section Color:
                    <button type="button" class="button" @click="toggleSectionColorPicker"
                            v-text="!isColorPickerActive ? 'Choose Color' : 'Hide Color Picker'"></button>
                    <label>
                        <input type="text" v-model="featuredOptions.background.hex">
                    </label>
                    <sketch-picker :value="colors" v-model="featuredOptions.background"
                                   v-show="isColorPickerActive"></sketch-picker>
                </div>
            </div>
        </div>

        <draggable :list="featuredModals" :disabled="!enabled" ghost-class="ghost" @start="dragging = true"
                   @end="onDraggingEnded">
            <div class="modal mt-5" v-for="(modal, index) in featuredModals" :key="index">
                <div class="row">
                    <div class="col-1">
                        <span class="dashicons dashicons-move"></span>
                    </div>
                    <div class="col-10">
                        <div class="row">
                            <div class="col-12">
                                <img :src="modal.image.url" :alt="modal.image.title" height="300">
                                <button class="button" @click.prevent="changeImage(modal)">Change Image</button>
                            </div>
                            <div class="col-12">
                                <label>
                                    Name:
                                    <input type="text" class="block" v-model="modal.name"
                                           :disabled="editingModal !== index" @keyup="onKeyUp" @keydown="onKeyDown">
                                </label>
                            </div>
                            <div class="col-12">
                                <label>
                                    Staff Title:
                                    <input type="text" class="block" v-model="modal.title"
                                           :disabled="editingModal !== index" @keyup="onKeyUp" @keydown="onKeyDown">
                                </label>
                            </div>
                            <div class="col-12">
                                <label>
                                    Video URL:
                                    <input type="text" class="block" v-model="modal.videoUrl"
                                           :disabled="editingModal !== index" @keyup="onKeyUp" @keydown="onKeyDown">
                                </label>
                            </div>
                            <div class="col-12">
                                <label>
                                    Certifications:
                                    <input type="text" class="block" v-model="modal.certifications"
                                           :disabled="editingModal !== index" @keyup="onKeyUp" @keydown="onKeyDown">
                                </label>
                            </div>
                            <div class="col-12">
                                <label>
                                    Description:
                                    <vue-editor v-model="modal.description"
                                                :disabled="editingModal !== index"></vue-editor>
                                </label>
                            </div>
                            <div class="col-12">
                                <label>
                                    Excerpt:
                                    <textarea class="modal block" rows="5" v-model="modal.excerpt"
                                              :disabled="editingModal !== index" @keyup="onKeyUp"
                                              @keydown="onKeyDown"></textarea>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-1">
                        <span class="dashicons dashicons-edit" @click="editModal(index)"></span>
                        <span class="dashicons dashicons-dismiss" @click="removeModal(index)"></span>
                    </div>
                </div>
            </div>
        </draggable>

        <br v-show="featuredModals.length">

        <div class="section-options" v-if="modals.length">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title">Staff</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>
                        Columns:
                        <select v-model="options.columns" name="staff_columns">
                            <option v-for="column in columnSizes" :value="column">{{column}}</option>
                        </select>
                    </label>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-12">
                    Section Color:
                    <button type="button" class="button" @click="toggleSectionColorPicker"
                            v-text="!isColorPickerActive ? 'Choose Color' : 'Hide Color Picker'"></button>
                    <label>
                        <input type="text" v-model="options.background.hex" name="staff_section_color">
                    </label>
                    <sketch-picker :value="colors" v-model="options.background"
                                   v-show="isColorPickerActive"></sketch-picker>
                </div>
            </div>
        </div>

        <draggable :list="modals" :disabled="!enabled" ghost-class="ghost" @start="dragging = true"
                   @end="onDraggingEnded">
            <div class="modal mt-5" v-for="(modal, index) in modals" :key="index">
                <div class="row">
                    <div class="col-1">
                        <span class="dashicons dashicons-move"></span>
                    </div>
                    <div class="col-10">
                        <div class="row">
                            <div class="col-12">
                                <img :src="modal.image.url" :alt="modal.image.title" height="300">
                                <button class="button" @click.prevent="changeImage(modal)">Change Image</button>
                            </div>
                            <div class="col-12">
                                <div class="checkbox-field">
                                    <label>
                                        Featured:
                                        <input type="checkbox" v-model="modal.featured"
                                               :disabled="editingModal !== index" @keyup="onKeyUp" @keydown="onKeyDown">
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <label>
                                    Name:
                                    <input type="text" class="block" v-model="modal.name"
                                           :disabled="editingModal !== index" @keyup="onKeyUp" @keydown="onKeyDown">
                                </label>
                            </div>
                            <div class="col-12">
                                <label>
                                    Staff Title:
                                    <input type="text" class="block" v-model="modal.title"
                                           :disabled="editingModal !== index" @keyup="onKeyUp" @keydown="onKeyDown">
                                </label>
                            </div>
                            <div class="col-12">
                                <label>
                                    Video URL:
                                    <input type="text" class="block" v-model="modal.videoUrl"
                                           :disabled="editingModal !== index" @keyup="onKeyUp" @keydown="onKeyDown">
                                </label>
                            </div>
                            <div class="col-12">
                                <label>
                                    Certifications:
                                    <input type="text" class="block" v-model="modal.certifications"
                                           :disabled="editingModal !== index" @keyup="onKeyUp" @keydown="onKeyDown">
                                </label>
                            </div>
                            <div class="col-12">
                                <label>
                                    Description:
                                    <vue-editor v-model="modal.description"
                                                :disabled="editingModal !== index"></vue-editor>
                                </label>
                            </div>
                            <div class="col-12">
                                <label>
                                    Excerpt:
                                    <textarea class="modal block" rows="5" v-model="modal.excerpt"
                                              :disabled="editingModal !== index" @keyup="onKeyUp"
                                              @keydown="onKeyDown"></textarea>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-1">
                        <span class="dashicons dashicons-edit" @click="editModal(index)"></span>
                        <span class="dashicons dashicons-dismiss" @click="removeModal(index)"></span>
                    </div>
                </div>
            </div>
        </draggable>

        <br v-show="modals.length">

        <div class="form-wrapper" v-if="currentFormActive">
            <div class="row">
                <div class="col-12">
                    <h4 class="title">Add a new Staff Member</h4>
                </div>
                <div class="col-12">
                    <div class="image-upload-wrapper">
                        <img :src="currentModal.image.url" :alt="currentModal.image.title"
                             v-if="currentModal.image.url" height="300">
                        <button @click.prevent="uploadImage" class="button">Add Image</button>
                    </div>
                </div>
                <div class="col-12">
                    <div class="checkbox-field">
                        Featured:
                        <label>
                            <input type="checkbox" class="checkbox" v-model="currentModal.featured">
                        </label>
                    </div>
                </div>
                <div class="col-12">
                    <label>
                        Name:
                        <input type="text" class="block" v-model="currentModal.name">
                    </label>
                </div>
                <div class="col-12">
                    <label>
                        Staff Title:
                        <input type="text" class="block" v-model="currentModal.title">
                    </label>
                </div>
                <div class="col-12">
                    <label>
                        Video URL:
                        <input type="text" class="block" v-model="currentModal.videoUrl">
                    </label>
                </div>
                <div class="col-12">
                    <label>
                        Certifications:
                        <input type="text" class="block" v-model="currentModal.certifications">
                    </label>
                </div>

                <div class="col-12">
                    <label>
                        Description:
                    </label>
                    <vue-editor v-model="currentModal.description"></vue-editor>
                </div>
                <div class="col-12">
                    <label>
                        Excerpt:
                        <textarea v-model="currentModal.excerpt" ref="editor" class="block" rows="5"></textarea>
                    </label>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                <input type="hidden" name="modal_images" :value="modalsJson">
                <input type="hidden" name="featured_staff_options" :value="featureOptionsJson">
                <input type="hidden" name="staff_options" :value="optionsJson">
                <div class="btn-group">
                    <button type="button" class="button button-primary" @click="saveModal" v-show="isCurrentFormDone">
                        Save Staff Member
                    </button>

                    <button type="button" class="button button-primary" @click="addModal"
                            v-show="(modals.length >= 1 && isCurrentFormEmpty) || (featuredModals.length >= 1 && isCurrentFormEmpty)">
                        Add New Staff Member
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

    import axios from 'axios'
    import draggable from 'vuedraggable'
    import { VueEditor } from 'vue2-editor'
    import { Sketch } from 'vue-color'

    const initialModal = {
        name: '',
        title: '',
        description: '',
        excerpt: '',
        image: '',
        videoUrl: '',
        featured: false,
        certifications: [],
    }

    export default {
        name: 'modal-field',
        data () {
            return {
                columnSizes: [
                    1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12,
                ],
                enabled: true,
                dragging: false,
                options: {
                    columns: 4,
                    background: {
                        hex: '#ffffff',
                    },
                },
                modals: [],
                featuredModals: [],
                featuredOptions: {
                    columns: 4,
                    background: {
                        hex: '#ffffff',
                    },
                },
                colors: '#ffffff',
                editingModal: null,
                currentModal: {...initialModal},
                currentFormActive: true,
                typingTimer: null,
                doneTypingInterval: 2000,
                isColorPickerActive: false,
                updatedSection: '',
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
            currentModals: {
                type: Array,
                default () {
                    return []
                },
            },
            currentOptions: {
                type: Object,
                default () {
                    return {}
                },
            },
            currentFeaturedOptions: {
                type: Object,
                default () {
                    return {}
                },
            },
            isSaved: {
                type: Boolean,
                default: false,
            },
        },
        computed: {
            modalsJson () {
                let allModals = this.modals.concat(this.featuredModals)
                return JSON.stringify(allModals)
            },
            optionsJson () {
                return JSON.stringify(this.options)
            },
            featureOptionsJson () {
                return JSON.stringify(this.featuredOptions)
            },
            isCurrentFormDone () {
                if (this.currentModal.name === '') {
                    return false
                }

                if (this.currentModal.title === '') {
                    return false
                }

                if (this.currentModal.description === '') {
                    return false
                }

                if (this.currentModal.image === '') {
                    return false
                }

                return true
            },
            isCurrentFormEmpty () {
                return JSON.stringify(this.currentModal) === JSON.stringify({...initialModal})
            },
        },
        mounted () {
            if (this.currentModals.length) {
                this.currentModals.forEach((currentModal) => {
                    if (!currentModal || currentModal === 'undefined') {
                        return
                    }

                    if (currentModal.featured) {
                        this.featuredModals.push(currentModal)
                    } else {
                        this.modals.push(currentModal)
                    }
                })
                this.currentFormActive = false
            }

            if (Object.keys(this.currentOptions).length) {
                this.options = this.currentOptions
            }

            if (Object.keys(this.currentFeaturedOptions).length) {
                this.featuredOptions = this.currentFeaturedOptions
            }
        },
        methods: {
            saveModal () {
                this.currentFormActive = false
                if (this.currentModal.featured) {
                    this.featuredModals.push(this.currentModal)
                } else {
                    this.modals.push(this.currentModal)
                }

                this.currentModal = {...initialModal}
                this.submitModals()
            },
            addModal () {
                this.currentFormActive = true
            },
            editModal (index) {
                this.editingModal = index
            },
            removeModal (index) {
                this.modals = this.modals.filter((modal, currentModalIndex) => {
                    return index !== currentModalIndex
                })

                this.featuredModals = this.featuredModals.filter((modal, currentModalIndex) => {
                    return index !== currentModalIndex
                })

                this.submitModals()
            },
            uploadImage () {
                this.wpUploadImage(this.currentModal)
            },
            changeImage (image) {
                this.wpUploadImage(image)
                this.submitModals()
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
                this.typingTimer = setTimeout(this.submitModals, this.doneTypingInterval)
            },

            onKeyDown () {
                clearTimeout(this.typingTimer)
            },
            submitModals () {
                if (!this.isSaved) {
                    return
                }

                let allModals = []
                this.modals.forEach((modal) => {
                    allModals.push(modal)
                })
                this.featuredModals.forEach((modal) => {
                    allModals.push(modal)
                })
                console.log('all modals ready')
                console.log(allModals)
                let formData = new FormData
                formData.append('action', 'modal')
                formData.append('post_id', this.postId)
                formData.append('modals', JSON.stringify(allModals))
                formData.append('staff_options', this.optionsJson)
                formData.append('featured_staff_options', this.featureOptionsJson)
                axios.post(ajaxObject.url, formData, {
                    headers: {
                        'Content-type': 'application/x-www-form-urlencoded',
                    },
                })
            },
            onDraggingEnded () {
                this.dragging = false
                this.submitModals()
            },
            toggleSectionColorPicker () {
                this.isColorPickerActive = !this.isColorPickerActive
            },
            hideColorPicker () {
                this.isColorPickerActive = false
            },
        },
        components: {
            draggable,
            VueEditor,
            'sketch-picker': Sketch,
        },
    }
</script>

<style scoped lang="scss">
    .modal {
        margin-bottom: 20px;
        position: relative;
    }

</style>