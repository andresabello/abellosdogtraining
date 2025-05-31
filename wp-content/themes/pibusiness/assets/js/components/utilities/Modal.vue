<template>
    <div class="modal" tabindex="-1" role="dialog" aria-hidden="true" v-if="active" @click.self="hide">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <i class="fas fa-times-circle float-right d-inline-block mt-2 mr-2 text-right" @click="hide"></i>
                <div class="modal-body pt-0">
                    <slot name="content"></slot>
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
        },
        methods: {
            hide() {
                this.$emit('hide')
            },
        },
    }
</script>

<style scoped lang="scss">
    @import "./../../../scss/variables.scss";

    .modal {
        display: block;
        background: rgba(0, 0, 0, .88);
        z-index: 11000;
        overflow-y: auto;

        .modal-dialog {
            max-width: none;
            width: 80%;
        }

        .modal-content {
            .modal-header {
                border-bottom: 0;
            }

            .modal-body {
                overflow-y: auto;
                padding: 20px 60px;
            }
        }

        .fas {
            cursor: pointer;
            color: $primary;
            transition: color .3s ease-in-out;
            font-size: 1.75rem;

            &:hover {
                color: lighten($primary, 20)
            }
        }

    }

    @media only screen and (max-width: 991px) {
        .modal {
            .modal-dialog {
                max-width: none;
                width: 100% !important;
            }

            .modal-content {
                .modal-body {
                    padding: 20px 20px 120px 20px;
                }
            }
        }
    }
</style>