<template>
    <div class="accordion-wrapper">
        <div class="title-wrapper" @click="toggleActive">
            <div class="toggle">
                <i class="fal" :class="{'fa-plus':!active, 'fa-minus': active}" aria-hidden="true"></i>
            </div>
            <div class="title">
                <slot name="title"></slot>
            </div>
        </div>
        <div :active="active">
            <transition @enter="openAccordion" @leave="closeAccordion" :css="false">
                <div class="accordion" v-show="active">
                    <div class="accordion-content">
                        <div class="row">
                            <div class="col-12">
                                <slot name="content"></slot>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
    import Velocity from "velocity-animate"

    export default {
        name: 'CategoryAccordion',
        props: {
            isActiveOnStart: {
                type: Boolean,
                default: false,
            },
        },
        data() {
            return {
                active: false,
            }
        },
        mounted() {
            this.isToggleActiveOnStart()
        },
        methods: {
            isToggleActiveOnStart() {
                this.active = this.isActiveOnStart
            },
            toggleActive() {
                this.active = !this.active
            },
            openAccordion(el, done) {
                let options = {duration: 300}
                Velocity(el, 'slideDown', options)
            },
            closeAccordion(el, done) {
                let options = {duration: 300}
                Velocity(el, 'slideUp', options)
            },
        }
    }
</script>

<style scoped lang="scss">
    @import "../../../scss/variables.scss";

    .accordion-wrapper {
        background-color: $primary;
        border-radius: 40px;

        .title-wrapper {
            background-color: $primary;
            color: $white;
            cursor: pointer;
            display: block;
            transition: .3s all ease-in-out;
            border-radius: 10px;

            &:hover {
                background-color: lighten($primary, 10);
            }

            .title {
                display: inline-block;
                padding: 15px 0;
                width: 80%;

                h5 {
                    font-weight: 100 !important;
                }
            }

            .toggle {
                display: inline-block;
                height: 30px;
                text-align: center;
                margin: 10px;
            }
        }

        .accordion {
            .accordion-content {
                padding: 20px;
            }
        }
    }
</style>