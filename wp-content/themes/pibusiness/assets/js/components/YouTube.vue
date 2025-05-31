<template>
    <div :style="{height: containerHeight}" class="video-wrapper" :id="'wrapper-'+uniqueId">
        <div v-if="lazy" class="youtube" :style="{
            'padding-top': isVideoPlaying ?  0 : '56.25%'
        }">
            <div :id="'yt-player-' + uniqueId" v-if="isVideoPlaying"></div>
            <img :src="imageSrc" alt="" class="img img-fluid" v-if="!isVideoPlaying">
            <transition :duration="300">
                <div class="play-button" @click="onPlayVideo" v-if="!isVideoPlaying"></div>
            </transition>
        </div>
        <div v-else class="youtube" :id="'yt-player-' + uniqueId"></div>
    </div>
</template>

<script>

    export default {
        name: 'yt-player',
        props: {
            videoId: {
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
            lazy: {
                type: Boolean,
                default: true,
            },
            videoUrl: {
                type: String,
                default: ''
            },
            containerHeight: {
                type: String,
                default: '450px',
            },
        },
        data() {
            return {
                player: null,
                imageSrc: null,
                videoSrc: null,
                youtubeID: null,
                done: false,
                uniqueId: Math.random().toString(36).substr(2, 9),
                width: null,
                isVideoPlaying: false
            }
        },
        computed: {
            height() {
                return this.width / (16 / 9)
            }
        },
        mounted() {
            this.width = document.getElementById('wrapper-' + this.uniqueId).offsetWidth

            if (this.videoUrl !== '') {
                this.setVideoID()
            }

            if (this.videoId !== '') {
                this.youtubeID = this.videoId
            }

            if (this.lazy) {
                this.imageSrc = 'https://img.youtube.com/vi/' + this.youtubeID + '/hqdefault.jpg'
            }

            if (!document.getElementById('youtube-script')) {
                let tag = document.createElement('script')
                tag.setAttribute('id', 'youtube-script')
                tag.src = 'https://www.youtube.com/iframe_api'
                let firstScriptTag = document.getElementsByTagName('script')[0]
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag)
            }

            if (!this.lazy) {
                console.log('not lazy')
                setTimeout(() => {
                    this.youtubeAPIReady()
                }, 1000)
            }
        },
        methods: {
            onPlayVideo() {
                if (!this.lazy) return
                console.log('play')
                this.isVideoPlaying = true
                setTimeout(() => {
                    this.youtubeAPIReady()
                }, 1000)
            },
            onStopVideo() {
                this.isVideoPlaying = false
            },
            setVideoID() {
                if (this.videoUrl.includes('youtube.com')) {
                    let videoId = this.searchUrl('v', this.videoUrl)
                    this.youtubeID = videoId !== null ? videoId : ''
                    return
                }

                let videoId = this.videoUrl.split('/').pop()
                this.youtubeID = videoId ? videoId : ''
            },
            youtubeAPIReady() {
                this.player = new YT.Player('yt-player-' + this.uniqueId, {
                    height: this.height,
                    width: this.width,
                    videoId: this.youtubeID,
                    playerVars: {
                        'enablejsapi': true,
                        'autoplay': this.autoPlay ? 1 : 0,
                        'controls': this.controls ? 1 : 0,
                        'loop': this.loop ? 1 : 0,
                        'origin': window.location.href,
                        'showInfo': this.showInfo ? 1 : 0,
                        'fs': this.fullScreen ? 1 : 0
                    },
                    events: {
                        'onReady': this.onPlayerReady,
                    }
                })
            },
            searchUrl(name, url) {
                if (!url) url = location.href

                name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]")
                let regexS = "[\\?&]" + name + "=([^&#]*)"
                let regex = new RegExp(regexS)
                let results = regex.exec(url)
                return results == null ? null : results[1]
            },
            onPlayerReady(event) {
                event.target.playVideo()
            },
        },
    }
</script>

<style scoped lang="scss">
    .video-wrapper {
        position: relative;
        overflow: hidden;

        .youtube {
            background-color: #000;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            cursor: pointer;

            img {
                width: 100%;
                top: -16.84%;
                left: 0;
                opacity: 0.7;
            }

            .play-button {
                width: 90px;
                height: 60px;
                background-color: #333;
                box-shadow: 0 0 30px rgba(0, 0, 0, 0.6);
                z-index: 1;
                opacity: 0.8;
                border-radius: 6px;

                &:before {
                    content: "";
                    border-style: solid;
                    border-width: 15px 0 15px 26.0px;
                    border-color: transparent transparent transparent #fff;
                }
            }

            .play-button, img {
                cursor: pointer;
            }

            img, iframe, .play-button, .play-button:before {
                position: absolute;
            }

            .play-button, .play-button:before {
                top: 50%;
                left: 50%;
                transform: translate3d(-50%, -50%, 0);
            }

            iframe {
                height: 100%;
                width: 100%;
                top: 0;
                left: 0;
            }
        }
    }
</style>
