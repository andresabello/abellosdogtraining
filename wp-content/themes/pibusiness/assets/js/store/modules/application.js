import {
    SET_LOGO,
    SET_PHONE,
    TOGGLE_MENU,
    TOGGLE_IS_MOBILE,
    TOGGLE_OVERLAY,
    SET_TOP_POSITION,
    TOGGLE_GET_HELP_MENU,
} from '../mutation-types'
import HttpClient from '../../api/http-client.js'

const client = new HttpClient()

const state = {
    menu: {
        active: false,
    },
    getHelpMenu: {
        active: false,
    },
    overlay: {
        active: false,
    },
    window: {
        width: {

        }
    },
    isMobile: false,
    phone: '',
    mobileLogo: {
        image: {
            source_url: '',
            title: {
                rendered: '',
            },
        },
    },
    topPosition: 0,
}

const getters = {
    isGetHelpMenuActive: state => state.getHelpMenu.active,
    isOverlayActive: state => state.overlay.active,
    isMenuActive: state => state.menu.active,
    isMobile: state => state.isMobile,
    phone: state => state.phone,
    mobileLogo: state => state.mobileLogo,
    topPosition: state => state.topPosition,
}

const actions = {
    getOptions ({dispatch}) {
        client.get('tt/v1/theme-options/general_settings').then(({data}) => {
            if (typeof data.pi_number !== 'undefined') {
                dispatch('setPhone', data.pi_number)
            }

            if (typeof data.pi_mobile_logo_value !== 'undefined') {
                client.getMedia(data.pi_mobile_logo_value).then((response) => {
                    dispatch('setLogo', response.data)
                })
            }
        })
    },
    toggleMenu ({commit}) {
        commit(TOGGLE_MENU)
    },
    toggleOverlay ({commit}) {
        commit(TOGGLE_OVERLAY)
    },
    toggleGetHelpMenu ({commit}) {
        commit(TOGGLE_GET_HELP_MENU)
    },
    setIsMobile ({commit}) {
        commit(TOGGLE_IS_MOBILE, true)
    },
    setIsDesktop ({commit}) {
        commit(TOGGLE_IS_MOBILE, false)
    },
    setPhone ({commit}, phone) {
        commit(SET_PHONE, phone)
    },
    setLogo ({commit}, logo) {
        commit(SET_LOGO, logo)
    },
    setTopPosition ({commit}, topPosition) {
        commit(SET_TOP_POSITION, topPosition)
    },
}

const mutations = {
    [TOGGLE_MENU] (state) {
        state.menu.active = !state.menu.active
    },
    [TOGGLE_OVERLAY] (state) {
        state.overlay.active = !state.overlay.active
    },
    [TOGGLE_GET_HELP_MENU] (state) {
        state.getHelpMenu.active = !state.getHelpMenu.active
    },
    [SET_PHONE] (state, phone) {
        state.phone = phone
    },
    [SET_LOGO] (state, logo) {
        state.mobileLogo.image = logo
    },
    [TOGGLE_IS_MOBILE] (state, value) {
        state.isMobile = value
    },
    [SET_TOP_POSITION] (state, topPosition) {
        state.topPosition = topPosition + 'px'
    },
}

export default {
    state,
    getters,
    actions,
    mutations,
}