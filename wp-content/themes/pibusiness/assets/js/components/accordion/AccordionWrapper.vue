<template>
    <div class="accordion-wrap">
        <div class="title-wrapper">
            <div class="title" @click="toggleActive">
                <slot></slot>
            </div>
            <div class="toggle" @click="toggleActive">
                <i class="fal" :class="{'fa-arrow-right':!active, 'fa-arrow-down': active}" aria-hidden="true"></i>
            </div>
        </div>
        <accordion :active="active">
            <template v-slot:content>
                <p v-html="content"></p>
            </template>
        </accordion>
    </div>
</template>

<script>
    import Accordion from './Accordion.vue'

    export default {
        name: 'AccordionWrapper',
        props: {
            isActiveOnStart: {
                type: Boolean,
                default: false,
            },
            content: {
                type: String,
                required: true,
                default() {
                    return {}
                },
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
        },
        components: {
            'accordion': Accordion,
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../scss/variables.scss";

    .accordion-wrap {
        padding-top: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid $gray-200;

        .title-wrapper {
            display: block;

            .title {
                display: inline-block;
            }

            .toggle {
                display: inline-block;
                width: 30px;
                height: 30px;
                color: $danger;
                text-align: center;
                transition: .3s all ease-in-out;
                cursor: pointer;
                margin-right: 10px;
                float: right;
            }
        }
    }
</style>