import {currentGameApi, gameApi} from '../../api'
import {defineStore} from "pinia";
import {nextLiveOn, currentLiveOn} from '../../utils';

export default defineStore('games', {
    state: () => ({
        submittedGamesPaginator: null,
        queuedGames: [], // queued order by live_on asc
        finishedGamesPaginator: null,
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
        async getSubmittedGames(page = 1) {
            this.submittedGamesPaginator = await gameApi.submitted(page);
        },
        async getQueuedGames() {
            this.queuedGames = await gameApi.queued();
        },
        async getFinishedGames(page = 1) {
            this.finishedGamesPaginator = await gameApi.finished(page);
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
        async cloneAndQueueGame(gameId) {
            await gameApi.cloneAndQueue(gameId);
            await Promise.all([
                this.getCurrentGame(),
                this.getQueuedGames(),
            ]);
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
                now = nextLiveOn(now);
                this.queuedGames[i].new_live_on = now;
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
