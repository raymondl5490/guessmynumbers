import { currentGameApi } from '../../api'

const state = () => ({
    currentGame: {}
})

const getters = {}

const actions = {
    async getCurrentGame({commit}) {
        const currentGame = await currentGameApi.getCurrentGame();
        commit('setCurrentGame', currentGame)
    },
}

const mutations = {
    setCurrentGame(state, value) {
        state.currentGame = value
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
