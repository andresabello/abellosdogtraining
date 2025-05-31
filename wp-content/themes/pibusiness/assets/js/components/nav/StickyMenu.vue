<template>
    <div class="nav-wrapper" :class="{'sticky': isSecondMenuSticky}" id="second-sticky-menu">
        <div class="container">
            <div class="nav-container" ref="header">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="overlay" ref="menu" :style="{
                            top: topPosition + 'px',
                        }">
                        <div class="navbar-collapse pi-menu">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item">
                                    <a href="#home" class="nav-link" @click.prevent="scrollToElement({
                                            url: '#home'
                                         })">
                                        <img src="https://ttcdev.wpengine.com/wp-content/uploads/2019/11/t-logo.png"
                                             alt="Transformations Treatment Center" width="30" :style="{
                                                'margin-top': '-10px'
                                             }">
                                    </a>
                                </li>
                                <li class="nav-item" v-for="item in items" :ref="item.ID" :key="item.id">
                                    <div class="toggle-wrapper">
                                        <div>
                                            <a :href="item.url !== '' ? item.url : '/'" class="nav-link"
                                               :class="{'active': activeMenuItem === item.url.substr(1)}"
                                               @click.prevent="scrollToElement(item)">
                                                <span class="nav-icon" v-if="item.iconHtml !== ''"
                                                      v-html="item.iconHtml"></span>
                                                {{ item.title }}
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</template>

<script>
    import Velocity from 'velocity-animate'
    import {mapActions, mapGetters} from 'vuex'

    export default {
        name: 'sticky-menu',
        props: {
            items: {
                type: Array,
                required: true,
                default() {
                    return []
                },
            },
        },
        data() {
            return {
                topPosition: 0,
                stickingPoint: 0,
                activeMenuItem: null,
                spiedScrolledElements: [],
            }
        },
        computed: {
            ...mapGetters({
                isSecondMenuSticky: 'isSecondMenuSticky',
            }),
        },
        mounted() {
            let currentElement = document.getElementById('second-sticky-menu')
            let currentElementPosition = currentElement.getBoundingClientRect()

            if (currentElementPosition.top < 0) {
                this.stickingPoint = currentElementPosition.top + window.pageYOffset
            }

            if (this.stickingPoint === 0) {
                this.stickingPoint = currentElementPosition.top
            }

            let scrollElements = document.querySelectorAll('.scroll-to')
            scrollElements.forEach((scrollElement) => {
                let currentElement = document.getElementById(scrollElement.id)
                if (!currentElement) return

                this.spiedScrolledElements.push({
                    id: scrollElement.id,
                    topPosition: currentElement.offsetTop,
                    bottomPosition: currentElement.offsetTop + currentElement.offsetHeight,
                })
            })
            window.addEventListener('scroll', this.stick)
        },
        methods: {
            stick() {
                let menuContainer = document.getElementById('nav-container')
                let currentElement = document.getElementById('second-sticky-menu')

                if (!currentElement || !menuContainer) return

                let menuContainerCurrentPosition = menuContainer.getBoundingClientRect()
                let currentElementPosition = currentElement.getBoundingClientRect()

                if (currentElementPosition.top < menuContainerCurrentPosition.top + menuContainer.offsetHeight &&
                    !this.isSecondMenuSticky) {
                    this.stickSecondMenu()
                    this.unStickMenu()
                }

                if (window.pageYOffset < this.stickingPoint && this.isSecondMenuSticky) {
                    this.unStickSecondMenu()
                    this.stickMenu()
                }

                if (this.isSecondMenuSticky) {
                    this.spiedScrolledElements.forEach((spiedElement) => {
                        if (window.pageYOffset >= spiedElement.topPosition - 80 &&
                            window.pageYOffset < spiedElement.bottomPosition) {
                            if (this.activeMenuItem === spiedElement.id) return

                            this.activeMenuItem = spiedElement.id
                        }
                    })
                }
            },
            scrollToElement(item) {
                let elementId = item.url.substr(1)
                let scrollToElement = document.getElementById(elementId)
                if (!scrollToElement) return

                this.activeMenuItem = elementId
                Velocity(scrollToElement, 'scroll', {duration: 1000, easing: 'easeInSine'})
            },
            ...mapActions({
                stickMenu: 'stickMenu',
                unStickMenu: 'unStickMenu',
                stickSecondMenu: 'stickSecondMenu',
                unStickSecondMenu: 'unStickSecondMenu',
            }),
        },
    }
</script>

<style scoped lang="scss">
    @import "../../../scss/variables.scss";

    .nav-wrapper {
        &.sticky {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background-color: $primary;
            padding: 0;
            z-index: 9999;
            border-bottom: 1px solid darken($primary, 20);

            .navbar {
                padding: 10px 0;
            }
        }

        .overlay {
            margin: 0 auto;

            .nav-item {
                &.last-child {
                    border-right: 0;
                }

                &:last-child {
                    .nav-link {
                        &:after {
                            display: none;
                            padding-right: 0;
                        }
                    }
                }

                .nav-link {
                    color: $white;
                    padding: 10px;
                    text-transform: uppercase;
                    font-weight: 700;
                    transition: color .5s ease-in-out;
                    font-size: 1.1rem;

                    &.active, &:hover {
                        color: $secondary;
                    }

                    &:after {
                        display: inline-block;
                        content: " ";
                        background-color: $white;
                        height: 15px;
                        width: 1px;
                        margin-bottom: 0;
                        margin-left: 20px;
                    }
                }
            }
        }
    }

    @media only screen and (max-width: 1024px) {
        #second-sticky-menu {

            .nav-link {
                font-size: .75rem !important;
            }
        }
    }
</style>