import {currentGameApi} from '../../api'
import {defineStore} from "pinia";

export default defineStore('games', {
    state: () => ({
        currentGame: {},
    }),
    getters: {

    },
    actions: {
        async getCurrentGame() {
            this.currentGame = await currentGameApi.getCurrentGame();
        },
    },
    persistedState: {
        persist: false,
    },
})
