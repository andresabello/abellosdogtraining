import Vue from 'vue'
import Vuex, {
    mapGetters, mapActions
} from 'vuex'
import 'core-js/stable'
import './../scss/app.scss'
import store from './store/index.js'
import VueLazyload from 'vue-lazyload'
import Vue2TouchEvents from 'vue2-touch-events'
import Velocity from "velocity-animate"
import {
    faChevronDown,
    faChevronLeft,
    faChevronRight,
    faChevronUp,
    faPlus,
    faMinus,
    faTimes,
    faTimesCircle,
    faFilter,
    faBuilding,
    faImages,
} from '@fortawesome/free-solid-svg-icons'
import {library} from '@fortawesome/fontawesome-svg-core'
import {FontAwesomeIcon} from '@fortawesome/free-solid-svg-icons'

Vue.use(Vuex)
Vue.use(VueLazyload)
Vue.use(Vue2TouchEvents)

library.add(faChevronDown)
library.add(faChevronUp)
library.add(faTimesCircle)
library.add(faTimes)
library.add(faChevronRight)
library.add(faChevronLeft)
library.add(faMinus)
library.add(faPlus)
library.add(faFilter)
library.add(faBuilding)
library.add(faImages)
Vue.component('font-awesome-icon', FontAwesomeIcon)



let quoteForms = document.querySelectorAll('.contact-form')
quoteForms.forEach((contactForm) => {
    new Vue({
        el: '.contact-form-' + contactForm.dataset.id,
        components: {
            'contact-form': (resolve => {
                require(['./components/forms/ContactForm.vue'], resolve)
            }),
        },
    })
})


let currencyConverterForms = document.querySelectorAll('.currency-converter')
currencyConverterForms.forEach((quoteForm) => {
    new Vue({
        el: '.currency-converter-' + quoteForm.dataset.id,
        components: {
            'currency-converter': (resolve => {
                require(['./components/forms/CurrencyConverter.vue'], resolve)
            }),
        },
    })
})


let tabbedContents = document.querySelectorAll('.tabbed-content')
tabbedContents.forEach((tabbedContent) => {
    new Vue({
        el: '.tabbed-content-' + tabbedContent.dataset.id,
        components: {
            'tabbed-content': () => import('./components/TabbedContent.vue'),
        },
    })
})

if (document.getElementById('main-menu')) {
    new Vue({
        el: '#main-menu',
        store,
        data: {
            counter: 0,
            isChatActive: false,
            isSideBarActive: false,
            isVideoModalActive: false,
            overlayTopPosition: 0,
            overlayRightPosition: -100,
            desktopMenuPosition: 0,
            additionalAdminMenuHeight: 0,
        },
        computed: {
            ...mapGetters({
                phone: 'phone',
                isMobile: 'isMobile',
                topPosition: 'topPosition',
                isMenuSticky: 'isMenuSticky',
                isMenuActive: 'isMenuActive',
                isMobileMenuActive: 'isMobileMenuActive',
                isSecondMenuSticky: 'isSecondMenuSticky',
                isGetHelpMenuActive: 'isGetHelpMenuActive',
            }),
        },
        beforeMount () {
            this.resize()
            window.addEventListener('resize', this.resize)
            window.addEventListener('scroll', this.scroll)
        },
        mounted () {
            this.desktopMenuPosition = document.getElementById('nav-container').offsetTop
            setTimeout(() => {
                this.isChatActive = true
            }, 15000)
        },
        methods: {
            resize () {
                if (window.innerWidth <= 991) {
                    this.setIsMobile()
                } else {
                    this.setIsDesktop()
                }
            },
            scroll () {
                if (window.pageYOffset >= this.desktopMenuPosition && !this.isMenuSticky && !this.isSecondMenuSticky) {
                    this.stickMenu()
                    return
                }

                if (window.pageYOffset < this.desktopMenuPosition && this.isMenuSticky) {
                    this.unStickMenu()
                }
            },
            openMenu (el, done) {
                if (!el || el === 'undefined') return
                Velocity(el, { right: 0 }, { duration: 500, complete: done })
            },
            closeMenu (el, done) {
                if (!el || el === 'undefined') return
                Velocity(el, { right: '-100%' }, { duration: 500 }).then(() => {
                    this.purgeAllItems()
                })
            },
            toggleMenu () {
                let mainMenu = document.getElementById('main-menu')
                let overlay = mainMenu.querySelector('.overlay')

                this.overlayTopPosition = document.getElementById('nav-container').offsetTop +
                    document.getElementById('nav-container').offsetHeight

                this.toggleMenuService()

                if (overlay.style.display === 'block') {
                    overlay.style.display = 'none'
                    this.overlayRightPosition = '-100%'
                    let children = mainMenu.querySelectorAll('.sub-menu')
                    children.forEach((child) => {
                        let el = document.getElementById('sub-menu-' + child.dataset.id)
                        el.style.display = 'none'
                    })
                    return
                }

                overlay.style.display = 'block'
                this.overlayRightPosition = 0
            },
            itemColumns (size) {
                if (typeof size === 'undefined' || size <= 0 || size > 12 || size === '') {
                    return 'col-12'
                }

                if (size === '5' ||
                    size === '6' ||
                    size === '7' ||
                    size === '8' ||
                    size === '9' ||
                    size === '10') {
                    return 'col'
                }

                return 'col-' + size
            },
            ...mapActions({
                stickMenu: 'stickMenu',
                // toggleItem: 'toggleItem',
                unStickMenu: 'unStickMenu',
                setIsMobile: 'setIsMobile',
                setIsDesktop: 'setIsDesktop',
                purgeAllItems: 'purgeAllItems',
                addActiveItem: 'addActiveItem',
                toggleMenuService: 'toggleMenu',
                // toggleIsMobile: 'toggleIsMobile',
                removeActiveItem: 'removeActiveItem',
                toggleGetHelpMenu: 'toggleGetHelpMenu',
                setTopPositionService: 'setTopPosition',
            }),
        },
        components: {
            'burger': () => import('./components/nav/Burger'),
        }
    })
}

let videoContainers = document.querySelectorAll('.video-container')
videoContainers.forEach((container) => {
    new Vue({
        el: '.video-container-' + container.dataset.id,
        store,
        components: {
            'video-wrapper': () => import("./components/VideoWrapper"),
        },
    })
})

let ytVideoContainers = document.querySelectorAll('.yt-player')
if (ytVideoContainers.length) {
    let tag = document.createElement('script')
    let firstScriptTag = document.getElementsByTagName('script')[0]
    tag.src = 'https://www.youtube.com/player_api'
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag)
    ytVideoContainers.forEach((container) => {
        new Vue({
            el: '.yt-player-' + container.dataset.id,
            components: {
                'yt-player': () => import('./components/YouTube'),
            },
        })
    })
}

let stickyMenus = document.querySelectorAll('.sticky-menu')
stickyMenus.forEach((menu) => {
    new Vue({
        el: '.sticky-menu-' + menu.dataset.id,
        store,
        components: {
            'sticky-menu': () => import('./components/nav/StickyMenu.vue'),
        },
    })
})


document.addEventListener("DOMContentLoaded", function () {
    var lazyloadImages;

    if ("IntersectionObserver" in window) {
        lazyloadImages = document.querySelectorAll(".lazy");
        var imageObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    var image = entry.target;
                    image.src = image.dataset.src;
                    image.classList.remove("lazy");
                    imageObserver.unobserve(image);
                }
            });
        });

        lazyloadImages.forEach(function (image) {
            imageObserver.observe(image);
        });
    } else {
        var lazyloadThrottleTimeout;
        lazyloadImages = document.querySelectorAll(".lazy");

        function lazyload() {
            if (lazyloadThrottleTimeout) {
                clearTimeout(lazyloadThrottleTimeout);
            }

            lazyloadThrottleTimeout = setTimeout(function () {
                var scrollTop = window.pageYOffset;
                lazyloadImages.forEach(function (img) {
                    if (img.offsetTop < (window.innerHeight + scrollTop)) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                    }
                });
                if (lazyloadImages.length == 0) {
                    document.removeEventListener("scroll", lazyload);
                    window.removeEventListener("resize", lazyload);
                    window.removeEventListener("orientationChange", lazyload);
                }
            }, 20);
        }

        document.addEventListener("scroll", lazyload);
        window.addEventListener("resize", lazyload);
        window.addEventListener("orientationChange", lazyload);
    }
})

let accordions = document.querySelectorAll('.accordion-wrapper')
accordions.forEach((accordion) => {
    new Vue({
        el: '.accordion-wrapper-' + accordion.dataset.id,
        components: {
            'accordion-wrapper': () => import("./components/accordion/AccordionWrapper"),
        },
    })
})


var last = null, x0, x1, x2, x3, y0, y1, y2, y3, link, timeout
let mainMenu = document.getElementById('main-menu')
if (mainMenu.dataset.ismobile !== 'true') {
    mainMenu.addEventListener('mouseleave', function (event) {
        event.preventDefault()
        mainMenu.dataset.hovering = 'off'
        clearTimeout(timeout)
        let items = mainMenu.querySelectorAll('.hover-item[data-hovering=\'true\']')
        items.forEach(item => {
            item.dataset.hovering = 'false'
            closeSubMenu(item)
        })
    })

    let menuItems = document.querySelectorAll('.hover-item')
    let timer

    menuItems.forEach((item) => {
        if (typeof item.dataset.id === 'undefined' || item.dataset.id === '') return

        item.addEventListener('mouseover', function () {
            if (item.dataset.hovering === 'true') return
            item.dataset.hovering = 'true'

            timer = setTimeout(function () {
                openSubMenu(item)
            }, 300)
        })

        item.addEventListener('mouseleave', function () {
            if (item.dataset.hovering === 'false') return

            item.dataset.hovering = 'false'
            closeSubMenu(item)
            clearTimeout(timer)
        })
    })
} else {
    let toggleIcons = document.querySelectorAll('.dropdown-toggle-icon')
    toggleIcons.forEach((icon) => {
        icon.onclick = function (event) {
            event.preventDefault()
            icon.classList.toggle('dropdown-active')
            let el = document.getElementById('sub-menu-' + icon.dataset.id)
            toggle(el)
        }
    })
}

let imageSliders = document.querySelectorAll('.image-slider')
imageSliders.forEach((slider) => {
    new Vue({
        el: '.image-slider-' + slider.dataset.id,
        store,
        components: {
            'image-slider': () => import('./components/utilities/ImageSlider.vue'),
        },
    })
})

function openSubMenu (parent) {
    let id = parent.dataset.id
    let el = document.getElementById('sub-menu-' + id)
    if (typeof el === 'undefined' || !el) return

    let effect = 'fadeIn'
    let options = {
        display: 'block',
        duration: 200,
    }
    if (parent.dataset.flyout === 'left') {
        el.style.left = '-100%'
    }

    if (mainMenu.dataset.ismobile === 'true') {
        options.duration = 200
        effect = 'slideDown'
    }
    if (el.dataset.full === 'true') {
        el.style.width = itemWidth(el)
        el.style.left = itemLeft(el)
    }
    Velocity(el, effect, options)
}

function closeSubMenu (parent) {
    let id = parent.dataset.id
    let el = document.getElementById('sub-menu-' + id)
    if (typeof el === 'undefined' || !el) return

    let effect = 'fadeOut'
    let options = {
        display: 'none',
        duration: 100,
    }

    if (mainMenu.dataset.ismobile === 'true') {
        options.duration = 300
        effect = 'slideUp'
    }

    Velocity(el, effect, options).then(() => {
        parent.dataset.hovering = 'false'
    })
}

function toggle (el) {
    if (el.style.display === 'block') {
        closeSubMenu(el)
        let children = el.querySelectorAll('.sub-menu')
        children.forEach((child) => {
            let el = document.getElementById('sub-menu-' + child.dataset.id)
            el.style.display = 'none'
        })
        return
    }
    openSubMenu(el)
}

function itemWidth (item) {
    let width = document.getElementById('nav-container').offsetWidth
    if (item.dataset.from === '_blank') {
        return width - item.parentElement.parentElement.offsetLeft + 'px'
    }

    return width + 'px'
}

function itemLeft (item) {
    if (item.dataset.from === '_blank') {
        return 0
    }

    return (-item.parentElement.parentElement.offsetLeft) + 'px'
}

