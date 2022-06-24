import {currentGameApi, gameApi} from '../../api'
import {defineStore} from "pinia";
import {useGuessStore} from "../index";
import {forEach, isEmpty} from "lodash";

export default defineStore('games', {
    state: () => ({
        games: [],
        submittedGames: [],
        queuedGames: [],
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
        finalNumber() {
            return this.board[2][2];
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
        addNumberToGameState(row, column, number) {
            this.board[row][column] = number;
        },
        removeNumberFromGameState(row) {
            if (!isEmpty(this.finalNumber)) { // Why checking this.finalNumber === 0
                return;
            }
            this.board[row].pop();
        },
        async getCurrentGame() {
            this.currentGame = await currentGameApi.getCurrentGame();
        },
        initializeBoard() {
            const guessStore = useGuessStore();

            forEach(guessStore.guesses, guess => {
                this.board[guess.row - 1][0] = guess.number_one;
                this.board[guess.row - 1][1] = guess.number_two;
                this.board[guess.row - 1][2] = guess.number_three;
            });
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
    },
    persistedState: {
        persist: false,
    },
})
