<template>
    <div class="container-fluid">
        <draggable :list="tabs" :disabled="!enabled" ghost-class="ghost" @start="dragging = true"
                   @end="dragging = false"
                   handle=".handle">
            <div class="tab" v-for="(tab, index) in tabs" :key="index">
                <div class="row">
                    <div class="col-1">
                        <span class="dashicons dashicons-move handle"></span>
                    </div>
                    <div class="col-10">
                        <div class="row">
                            <div class="col-12">
                                <img :src="tab.image.url" :alt="tab.image.title" height="300px">
                                <button class="button" @click.prevent="changeImage(tab)">Change Image</button>
                            </div>
                            <div class="col-12">
                                <label>
                                    Title:
                                    <input type="text" class="block" v-model="tab.title"
                                           :disabled="editingTab !== index" @keyup="onKeyUp" @keydown="onKeyDown">
                                </label>
                            </div>
                            <div class="col-12">
                                <label>
                                    URL:
                                    <input type="text" class="block" v-model="tab.url"
                                           :disabled="editingTab !== index" @keyup="onKeyUp" @keydown="onKeyDown">
                                </label>
                            </div>
                            <div class="col-12">
                                <label>
                                    Text:
                                    <vue-editor class="tab block"
                                                v-model="tab.text"
                                                :disabled="editingTab !== index"
                                                @keyup="onKeyUp"
                                                @keydown="onKeyDown" ></vue-editor>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-1">
                        <span class="dashicons dashicons-edit" @click="editTab(index)"></span>
                        <span class="dashicons dashicons-dismiss" @click="removeTab(index)"></span>
                    </div>
                </div>
            </div>
        </draggable>

        <br v-show="tabs.length">

        <div class="form-wrapper">
            <div class="row">
                <div class="col-12">
                    <h4>Add a new tab</h4>
                </div>

                <div class="col-12">
                    <div class="image-upload-wrapper">
                        <img :src="currentTab.image.url" :alt="currentTab.image.title" v-if="currentTab.image.url"
                             height="300px">
                        <button @click.prevent="uploadImage" class="button">Add Image</button>
                    </div>
                </div>

                <div class="col-12">
                    <label>
                        Title:
                        <input type="text" class="block" v-model="currentTab.title">
                    </label>
                </div>
                <div class="col-12">
                    <label>
                        Button Text:
                        <input type="text" class="block" v-model="currentTab.button_text">
                    </label>
                </div>
                <div class="col-12">
                    <label>
                        URL:
                        <input type="text" class="block" v-model="currentTab.url">
                    </label>
                </div>
                <div class="col-12">
                    <label>
                        Text:
                        <vue-editor class="block" v-model="currentTab.text"></vue-editor>
                    </label>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-12">
                    <input type="hidden" name="tabs" :value="tabsJson">
                    <button type="button" class="button button-primary" @click="addTab">Add Tab</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import draggable from 'vuedraggable'
    import { VueEditor } from 'vue2-editor'
    import Modal from './utilities/Modal.vue'

    const initialTab = {
        title: '',
        text: '',
        url: '',
        button_text: '',
        image: '',
    }

    export default {
        name: 'tabbed-content-field',
        data () {
            return {
                enabled: true,
                dragging: false,
                isModalActive: false,
                tabs: [],
                editingTab: null,
                currentTab: {...initialTab},
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
            currentTabs: {
                type: Array,
                default () {
                    return []
                },
            },
        },
        computed: {
            tabsJson () {
                return JSON.stringify(this.tabs)
            },
        },
        mounted () {
            if (this.currentTabs.length) {
                this.currentTabs.forEach((currentTab) => {
                    this.tabs.push(currentTab)
                })
            }
        },
        methods: {
            addTab () {
                this.tabs.push(this.currentTab)
                this.currentTab = {...initialTab}
                this.submitTabs()
            },
            editTab (index) {
                this.editingTab = index
            },
            removeTab (index) {
                this.tabs = this.tabs.filter((tab, currentTabIndex) => {
                    return index !== currentTabIndex
                })
            },
            uploadImage () {
                this.wpUploadImage(this.currentTab)
                this.submitTabs()
            },
            changeImage (tab) {
                this.wpUploadImage(tab)
                this.submitTabs()
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
            submitTabs () {
                let formData = new FormData
                formData.append('action', 'tabbed_content')
                formData.append('post_id', this.postId)
                formData.append('tabs', JSON.stringify(this.tabs))
                axios.post(ajaxObject.url, formData)
            },
            onKeyUp () {
                clearTimeout(this.typingTimer)
                this.typingTimer = setTimeout(this.submitTabs, this.doneTypingInterval)
            },

            onKeyDown () {
                clearTimeout(this.typingTimer)
            },
        },
        components: {
            draggable,
            Modal,
            VueEditor,
        },
    }
</script>

<style scoped lang="scss">
    .tab {
        margin-bottom: 40px;

        .image-upload-wrapper {
            border: 1px dotted #000;
            padding: 20px;
            text-align: center;

            .button {
                width: 150px;
                margin: 0 auto;
            }
        }
    }
</style>