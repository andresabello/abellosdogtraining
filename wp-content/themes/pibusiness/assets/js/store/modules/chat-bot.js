import {
    SET_INFORMATION_BUTTON_RIGHT_POSITION,
    TOGGLE_INITIAL_ANIMATION,
    TOGGLE_MOBILE_INFORMATION
} from '../mutation-types'

const state = {
    initialAnimation: {
        fired: false,
    },
    informationButton: {
        active: false,
        right: 0,
    },
    mobileInformationButton: {
        active: true
    }
}

const getters = {
    isInitialAnimationFired: state => state.initialAnimation.fired,
    isMobileMenuActive: state => state.mobileInformationButton.active,
    getInformationButtonMenuRightPosition:
        state => state.informationButton.right,
}

const actions = {
    toggleInitialAnimationFired({commit}) {
        commit(TOGGLE_INITIAL_ANIMATION)
    },
    toggleMobileInformationActive({commit}) {
        commit(TOGGLE_MOBILE_INFORMATION)
    },
    setInformationButtonMenuRightPosition({commit}, rightPosition) {
        commit(SET_INFORMATION_BUTTON_RIGHT_POSITION, rightPosition)
    },
}

const mutations = {
    [TOGGLE_MOBILE_INFORMATION](state) {
        state.mobileInformationButton.active = !state.mobileInformationButton.active
    },
    [TOGGLE_INITIAL_ANIMATION](state) {
        state.initialAnimation.active = !state.initialAnimation.active
    },
    [SET_INFORMATION_BUTTON_RIGHT_POSITION](state, rightPosition) {
        state.informationButton.right = rightPosition + 'px'
    },
}

export default {
    state,
    getters,
    actions,
    mutations,
}
