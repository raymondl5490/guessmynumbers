import {currentGameApi} from '../../api'
import {defineStore} from "pinia";
import {useGuessStore} from "../index";
import {forEach, isEmpty} from "lodash";

export default defineStore('games', {
    state: () => ({
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
        }
    },
    actions: {
        addNumberToGameState(row, column, number) {
            this.board[row][column] = number;
        },
        removeNumberFromGameState(row) {
            if (!isEmpty(this.finalNumber) || this.finalNumber === 0) {
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
        }
    },
    persistedState: {
        persist: false,
    },
})
