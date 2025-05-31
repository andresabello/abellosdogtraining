<template>
    <div class="lightbox-wrapper" v-if="images.length > 0">
        <LightBox :media="images" :show-light-box="false" ref="lightbox" class="lightbox"></LightBox>
        <div class="img-container bg-dark">
            <div class="image-slider"
                 id="image-slider"
                 :style="{
                    width: sliderWidth + 'px',
                    height: height + 'px',
                }">
                <img :src="img.url"
                     :alt="img.title"
                     :id="'image-' + index"
                     :style="{
                        height: height + 'px',
                     }"
                     v-for="(img, index) in images" :key="index"
                     class="img img-fluid" @click="openLightBox(index)">
            </div>
            <div class="previous" @click="slidePrevious">
                <font-awesome-icon icon="chevron-left"
                                   class="remove-btn"/>
            </div>
            <div class="next" @click="slideNext">
                <font-awesome-icon icon="chevron-right"
                                   class="remove-btn"/>
            </div>
        </div>
    </div>

</template>

<script>


import LightBox from 'vue-image-lightbox'
import('vue-image-lightbox/dist/vue-image-lightbox.min.css')


export default {
    name: 'ImageSlider',
    props: {
        images: {
            type: Array,
            required: true,
            default() {
                return []
            },
        },
        autoPlay: {
            type: Boolean,
            default: true,
        },
        controls: {
            type: Boolean,
            default: true,
        },
        arrows: {
            type: Boolean,
            default: true,
        },
        pauseOnHover: {
            type: Boolean,
            default: false,
        },
        sliderSpeed: {
            type: Number,
            default: 300,
        },
        height: {
            type: String,
            default: '400',
        },
        opacity: {
            type: Boolean,
            default: false,
        },
        caption: {
            type: Boolean,
            default: false,
        },
        color: {
            type: String,
            default: '#111111',
        },
        loop: {
            type: Boolean,
            default: true,
        },
        borderRadius: {
            type: String,
            default: '0',
        },
        initialSlideWidth: {
            type: String,
            default: '100%',
        },
        initialPadding: {
            type: String,
            default: '40px',
        },
        arrowPlacement: {
            type: String,
            default: 'sides',
        },
    },
    data() {
        return {
            currentSlide: 0,
            slideWidth: 0,
            isMobile: window.innerWidth <= 991,
            sliderWidth: 1200
        }
    },
    mounted() {
        this.images.forEach((image, index) => {
            let el = document.getElementById('image-' + index)
            el.onload = (e) => {
                this.sliderWidth += e.target.width
            }
        })
    },
    methods: {
        imageClicked(index) {
            this.$emit('image-clicked', index)
        },

        slidePrevious() {
            if (this.currentSlide <= 0) {
                this.currentSlide = this.images.length - 1
            } else {
                this.currentSlide--
            }

            let imageSlider = document.getElementById('image-slider')
            let leftMargin = 0
            this.images.slice(0, this.currentSlide).forEach((image, index) => {
                leftMargin += document.getElementById('image-' + index).offsetWidth + 20
            })

            imageSlider.style.marginLeft = -1 * leftMargin + 'px'
        },
        slideNext() {

            if (this.currentSlide >= this.images.length - 1) {
                this.currentSlide = 0
            } else {
                this.currentSlide++
            }

            let imageSlider = document.getElementById('image-slider')
            let leftMargin = 0
            this.images.slice(0, this.currentSlide).forEach((image, index) => {
                leftMargin += document.getElementById('image-' + index).offsetWidth + 20
            })

            imageSlider.style.marginLeft = -1 * leftMargin + 'px'
        },
        openLightBox(index) {
            this.$refs.lightbox.showImage(index)
        },
    },
    components: {
        LightBox,
    }
}
</script>

<style scoped lang="scss">

@import "../../../scss/variables";

.img-container {
    position: relative;
    overflow-x: hidden;

    .image-slider {
        height: 90px;
        display: block;
        transition: margin .7s;

        img {
            height: 90px;
            float: left;
            margin-left: 20px;
        }
    }

    .previous, .next {
        background-color: $dark;
        color: $white;
        position: absolute;
        top: 0;
        bottom: 0;
        width: 40px;
        cursor: pointer;
        transition: opacity .5s ease-in-out;

        .remove-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        &:hover {
            opacity: .75;
        }
    }

    .previous {
        left: 0;

        .remove-btn {
            left: 8px;
        }
    }

    .next {
        right: 0;

        .remove-btn {
            right: 8px;
        }
    }
}

</style>
