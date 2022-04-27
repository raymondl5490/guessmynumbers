import {defineStore} from "pinia";
import {playerApi} from "../../api";
import {filter, get} from "lodash";
import {useGameStore} from "../index";

export default defineStore('players', {
    state: () => ({
        currentPlayer: {},
    }),
    getters: {
        currentAttempt() {
            const gameStore = useGameStore();
            const attempts = get(this.currentPlayer, 'attempts')
            return filter(attempts, attempt => {
                return attempt.game_id === gameStore.currentGame.id
            })[0] ?? {};
        }
    },
    actions: {
        async getPlayer(playerId) {
            this.currentPlayer = await playerApi.getPlayer(playerId);
        },
        async createPlayer() {
            this.currentPlayer = await playerApi.createPlayer();
        }
    }
}, {
    persist: true
})
