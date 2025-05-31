<template>
    <div class="container-fluid">
        <draggable :list="links"
                   :disabled="!enabled"
                   ghost-class="ghost"
                   @start="dragging = true"
                   @end="dragging = false"
                   handle=".handle">
            <div class="link" v-for="(link, index) in links" :key="index">
                <div class="row">
                    <div class="col-1">
                        <span class="dashicons dashicons-move handle"></span>
                    </div>
                    <div class="col-10">
                        <div class="row">
                            <div class="col-12">
                                <label>
                                    Text:
                                    <input type="text"
                                           class="block"
                                           v-model="link.text"
                                           :disabled="editingLink !== index">
                                </label>
                            </div>
                            <div class="col-12">
                                <label>
                                    URL:
                                    <input type="text"
                                           class="block"
                                           v-model="link.url"
                                           :disabled="editingLink !== index">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-1">
                        <span class="dashicons dashicons-edit" @click="editLink(index)"></span>
                        <span class="dashicons dashicons-dismiss" @click="removeLink(index)"></span>
                    </div>
                </div>
            </div>
        </draggable>
        <div class="row">
            <div class="col-12">
                <label>
                    Text:
                    <input type="text" v-model="currentLink.text" class="block">
                </label>
            </div>
            <div class="col-12">
                <label>
                    Url:
                    <input type="text" v-model="currentLink.url" class="block">
                </label>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-12">
                <button type="button" class="button button-primary" @click="addLink">Add Link</button>
            </div>
        </div>
        <label>
            <input type="text" v-show="false" :name="fieldName" :value="linksJson">
        </label>
    </div>
</template>

<script>
    import draggable from 'vuedraggable'

    const initialLink = {
        text: '',
        url: '',
    }

    export default {
        name: 'SEOLinkWrapper',
        data () {
            return {
                enabled: true,
                dragging: false,
                links: [],
                editingLink: null,
                currentLink: {...initialLink},
            }
        },
        props: {
            currentLinks: {
                type: Array,
                default () {
                    return []
                },
            },
            fieldName: {
                type: String,
                default: ''
            }
        },
        mounted () {
            if (this.currentLinks.length) {
                this.currentLinks.forEach((currentLink) => {
                    this.links.push(currentLink)
                })
            }
        },
        methods: {
            addLink () {
                this.links.push(this.currentLink)
                this.currentLink = {...initialLink}
            },
            editLink (index) {
                this.editingLink = index
            },
            removeLink (index) {
                this.links = this.links.filter((link, currentLinkIndex) => {
                    return index !== currentLinkIndex
                })
            },
        },
        computed: {
            linksJson () {
                return JSON.stringify(this.links)
            },
        },
        components: {
            draggable,
        },
    }
</script>

<style scoped lang="scss">
    .link {
        margin-bottom: 20px;
    }
</style>