import { attemptApi } from '../../api'

const state = () => ({
    currentAttempt: {}
})

const getters = {}

const actions = {
    async createAttempt({commit}, gameId) {
        const currentAttempt = await attemptApi.createAttempt(gameId);
        commit('setCurrentAttempt', currentAttempt)
    },
}

const mutations = {
    setCurrentAttempt(state, value) {
        state.currentAttempt = value
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
