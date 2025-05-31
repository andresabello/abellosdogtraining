import {
    SET_STICKY_SECOND_MENU,
    UNSET_STICKY_SECOND_MENU,
} from '../mutation-types'

const state = {
    isSecondMenuSticky: false,
}

const getters = {
    isSecondMenuSticky: state => state.isSecondMenuSticky,
}

const actions = {
    stickSecondMenu ({commit}) {
        commit(SET_STICKY_SECOND_MENU)
    },
    unStickSecondMenu ({commit}) {
        commit(UNSET_STICKY_SECOND_MENU)
    },
}

const mutations = {
    [SET_STICKY_SECOND_MENU] (state) {
        state.isSecondMenuSticky = true
    },
    [UNSET_STICKY_SECOND_MENU] (state) {
        state.isSecondMenuSticky = false
    },
}

export default {
    state,
    getters,
    actions,
    mutations,
}