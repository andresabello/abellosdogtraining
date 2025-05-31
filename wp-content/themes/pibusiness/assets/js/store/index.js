import Vue from 'vue'
import Vuex from 'vuex'
import Menu from './modules/menu.js'
import SecondMenu from './modules/second-menu.js'
import App from './modules/application.js'
import ChatBot from './modules/chat-bot.js'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        App,
        Menu,
        ChatBot,
        SecondMenu
    },
})
