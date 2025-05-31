<template>
    <div class="video-wrapper"
         :style="{
                height: !isMobile ? containerHeight : null,
                background: videoBackground !== ''
                ? `url(${videoBackground}) center center/cover no-repeat`
                : '#111111'
         }">
        <div class="video-overlay" :style="{background: videoOverlayBackground}" v-if="videoUrl !== ''"></div>
        <video class="video"
               v-if="videoUrl !== ''"
               ref="video"
               autoplay muted :loop="loop ? 'loop' : ''">
            <source :src="videoUrl" type="video/mp4">
        </video>
        <div class="video-content">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from "vuex"

    export default {
        name: 'video-wrapper',
        props: {
            videoOverlayBackground: {
                type: String,
                default: 'rgba(0, 0, 0, 0.55)',
            },
            videoUrl: {
                type: String,
                default: '',
            },
            videoBackground: {
                type: String,
                default: '',
            },
            autoPlay: {
                type: Boolean,
                default: true,
            },
            controls: {
                type: Boolean,
                default: true,
            },
            fullScreen: {
                type: Boolean,
                default: false,
            },
            loop: {
                type: Boolean,
                default: true,
            },
            showInfo: {
                type: Boolean,
                default: false,
            },
            autoHide: {
                type: Boolean,
                default: true,
            },
            disableKeyBoard: {
                type: Boolean,
                default: true,
            },
            containerHeight: {
                type: String,
                default: '450px',
            },
        },
        data() {
            return {
                player: null,
            }
        },
        computed: {
            ...mapGetters({
                isMobile: 'isMobile'
            }),
        },
        mounted() {

        },
    }
</script>

<style scoped lang="scss">
    .video-wrapper {
        position: relative;
        overflow: hidden;
        background-repeat: no-repeat;
        height: 450px;

        .video-overlay {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .video {
            display: block;
            background-size: cover;
            z-index: 1200;
            pointer-events: none;
            width: 100%;
        }

        .video-content {
            z-index: 1300;
            position: absolute;
            top: 0;
            margin: 0 auto;
            width: 100%;
            text-align: center;
            pointer-events: all;
            height: 100%;
        }
    }

    @media only screen and (min-device-width: 1024px) and (max-device-width: 1366px) and (orientation: portrait) {
        .video-wrapper {
            height: 50vh !important;

            .video {
                display: none;
            }
        }
    }


    @media only screen and (max-width: 1024px) {
        .video-wrapper {
            .video-overlay {
                background: rgba(0, 0, 0, 0.4);
            }

            .video {
                display: none;
            }
        }
    }

    @media only screen and (max-width: 768px) {
        .video-wrapper {
            height: 50vh !important;
        }
    }

    @media only screen and (max-width: 568px) {
        .video-wrapper {
            height: 65vh !important;
        }

        .hero-container {
            .jumbotron {
                margin-top: 0;
            }
        }
    }

    @media only screen and (max-width: 991px) and (orientation: landscape) {
        .video-wrapper {
            height: 280px !important;

            .hero-container {
                height: 270px !important;
            }
        }
    }
</style>
