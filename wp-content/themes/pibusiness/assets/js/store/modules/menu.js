import {
    ADD_ACTIVE_ITEM,
    REMOVE_ACTIVE_ITEM,
    PURGE_ACTIVE_ITEMS,
    SET_STICKY_MENU,
    UNSET_STICKY_MENU,
} from '../mutation-types'

const state = {
    activeMenuItems: [],
    isMenuSticky: false,
}

const getters = {
    isMenuSticky: state => state.isMenuSticky,
    activeMenuItems: state => state.activeMenuItems,
}

const actions = {
    addActiveItem ({commit}, id) {
        commit(ADD_ACTIVE_ITEM, id)
    },
    removeActiveItem ({commit}, id) {
        commit(REMOVE_ACTIVE_ITEM, id)
    },
    purgeAllItems ({commit}) {
        commit(PURGE_ACTIVE_ITEMS)
    },
    stickMenu ({commit}) {
        commit(SET_STICKY_MENU)
    },
    unStickMenu ({commit}) {
        commit(UNSET_STICKY_MENU)
    },
}

const mutations = {
    [ADD_ACTIVE_ITEM] (state, id) {
        state.activeMenuItems.push(id)
    },
    [REMOVE_ACTIVE_ITEM] (state, id) {
        let index = state.activeMenuItems.findIndex((item) => {
            return item === id
        })
        state.activeMenuItems.splice(index, 1)
    },
    [PURGE_ACTIVE_ITEMS] (state) {
        state.activeMenuItems.forEach((item) => {
            let el = document.getElementById('sub-menu-' + item)
            el.style.display = 'none'
        })
        state.activeMenuItems = []
    },
    [SET_STICKY_MENU] (state) {
        state.isMenuSticky = true
    },
    [UNSET_STICKY_MENU] (state) {
        state.isMenuSticky = false
    },
}

export default {
    state,
    getters,
    actions,
    mutations,
}
