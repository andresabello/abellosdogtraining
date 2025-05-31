<template>
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
</template>

<script>
    import Velocity from 'velocity-animate'

    export default {
        name: 'accordion',
        props: {
            active: {
                default: false,
            },
        },
        methods: {
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

    .accordion {

        margin-bottom: 20px;

        &:last-child {
            margin-bottom: 0;
        }

        .accordion-header {
            border-radius: 3px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .accordion-content {
            padding: 20px;
        }
    }

    .slide-enter-active {
        right: 0;
    }

    .slide-enter-active, .slide-leave-active {
        transition: all 100ms cubic-bezier(0, 1, 0.5, 1);
    }
</style>