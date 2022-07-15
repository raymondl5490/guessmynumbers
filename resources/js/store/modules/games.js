import {currentGameApi, gameApi} from '../../api'
import {defineStore} from "pinia";
import {nextLiveOn, currentLiveOn} from '../../utils';

export default defineStore('games', {
    state: () => ({
        submittedGames: [],
        queuedGames: [], // queued order by live_on asc
        finishedGames: [],
        currentGame: {},
    }),
    actions: {
        async refreshGames() {
            await Promise.all([
                this.getCurrentGame(),
                this.getSubmittedGames(),
                this.getQueuedGames(),
                this.getFinishedGames(),
            ]);
        },
        async getSubmittedGames() {
            this.submittedGames = await gameApi.submitted();
        },
        async getQueuedGames() {
            this.queuedGames = await gameApi.queued();
        },
        async getFinishedGames() {
            this.finishedGames = await gameApi.finished();
        },
        async getCurrentGame() {
            this.currentGame = await currentGameApi.getCurrentGame();
        },
        async createGame(payload) {
            await gameApi.store(payload);
            await this.getSubmittedGames();
        },
        async updateGame(gameId, payload) {
            await gameApi.update(gameId, payload);
            await this.refreshGames();
        },
        async approveGame(gameId) {
            await gameApi.approve(gameId);
            await this.refreshGames();
        },
        async removeGame(gameId) {
            await gameApi.remove(gameId);
            await this.refreshGames();
        },
        async handleQueueChange(oldIndex, newIndex) {
            const oldItem = this.queuedGames[oldIndex];
            this.queuedGames.splice(oldIndex, 1);
            this.queuedGames.splice(newIndex, 0, oldItem);
            await this.syncQueuedGames();
        },
        async syncQueuedGames() {
            let now = currentLiveOn();

            for (let i = 0; i < this.queuedGames.length; i++) {
                this.queuedGames[i].new_live_on = now;
                now = nextLiveOn(now);
            }

            await Promise.all(
                _.map(this.queuedGames, async (game) =>
                    gameApi.updateLiveOn(game.id, {
                        live_on: game.new_live_on,
                    })
                )
            );

            await this.getQueuedGames();
        },
    },
    persistedState: {
        persist: false,
    },
})
