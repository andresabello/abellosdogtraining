<template>
    <div class="pi-modal" v-if="active">
        <div class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <slot name="header"></slot>
                        <span :class="icons" class="icon" @click="hide"></span>
                    </div>
                    <div class="modal-body">
                        <slot name="content"></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'modal',
        props: {
            active: {
                type: Boolean,
                default: false,
                required: true,
            },
            icons: {
                type: String,
                default: 'close',
            },
        },
        methods: {
            hide () {
                this.$emit('hide')
            },
        },
    }
</script>

<style scoped lang="scss">
    .modal {
        display: block;
        background: rgba(35,40,45, .92);
    }
    .icon {
        cursor: pointer;
    }
</style>