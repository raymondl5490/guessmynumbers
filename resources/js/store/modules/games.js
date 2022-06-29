import {currentGameApi, gameApi} from '../../api'
import {defineStore} from "pinia";
import {useGuessStore} from "../index";
import {forEach, isEmpty} from "lodash";
import {nextLiveOn} from '../../utils';

export default defineStore('games', {
    state: () => ({
        games: [],
        submittedGames: [],
        queuedGames: [], // queued order by live_on asc
        finishedGames: [],
        currentGame: {},
        board: [
            [],
            [],
            [],
        ],
    }),
    getters: {
        correctNumbers() {
            return [this.currentGame.number_one, this.currentGame.number_two, this.currentGame.number_three];
        },
        getGameById(store) {
            return (gameId) => _.find(store.games, {'id': gameId})
        },
    },
    actions: {
        async getAllGames() {
            this.games = await gameApi.index();
        },
        async refreshGames() {
            await Promise.all([
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
        async reorderGames(oldIndex, newIndex) {
            const queuedGames = this.queuedGames;
            const oldItem = queuedGames[oldIndex];
            queuedGames.splice(oldIndex, 1);
            queuedGames.splice(newIndex, 0, oldItem);

            let now = this.currentGame.live_on;

            for (let i = 0; i < queuedGames.length; i++) {
                now = nextLiveOn(now);
                queuedGames[i].new_live_on = now;
            }

            await Promise.all(
                _.map(queuedGames, async (game) =>
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
