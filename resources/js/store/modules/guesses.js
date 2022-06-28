import {defineStore} from "pinia";

import { guessApi } from '../../api';
import {useAttemptStore, useGameStore, usePlayerStore} from "../index";
import {forEach} from "lodash";

export default defineStore('guesses', {
    state: () => ({
        guess: [],
        guesses: [],
    }),
    getters: {
        currentGuess() {
            return {
                row: this.guesses.length + 1,
                number_one: this.guess[0],
                number_two: this.guess[1],
                number_three: this.guess[2],
            }
        },
        /**
         * 
         * @returns guesses in array of array : [ [],[],[] ]
         */
        existingGuessNumbers() {
            const numbers = [];
            forEach(this.guesses, guess => {
                numbers.push([
                    guess.number_one,
                    guess.number_two,
                    guess.number_three
                ]);
            });

            return numbers;
        }
    },
    actions: {
        addNumberToGuess(number) {
            if (this.guess.length >= 3) {
                return;
            }

            if (this.guesses.length >= 3) {
                return;
            }

            this.guess.push(number);

            const gameStore = useGameStore();
            gameStore.addNumberToGameState(this.currentGuess.row - 1, this.guess.length - 1, number);
        },
        async submitGuess() {
            if (this.guess.length < 3) {
                return;
            }

            if (this.guesses.length >= 3) {
                return;
            }

            const gameStore = useGameStore();
            const playerStore = usePlayerStore();
            const attemptStore = useAttemptStore();
            const won = _.isEqual(this.guess, gameStore.correctNumbers);
            await this.saveGuess(playerStore.currentPlayer.id, attemptStore.currentAttempt.id, {...this.currentGuess, won});
            if (won) await attemptStore.winAttempt();
        },
        removeNumberFromGuess() {
            if (!this.guess.length) return;
            this.guess.pop();
            const gameStore = useGameStore();
            gameStore.removeNumberFromGameState(this.currentGuess.row - 1);
        },
        resetGuess() {
            this.guess = [];
        },
        async saveGuess(playerId, attemptId, payload) {
            await guessApi.createGuess(playerId, attemptId, payload);
            await this.getGuesses(playerId, attemptId);
            this.resetGuess();
        },
        async getGuesses(playerId, attemptId) {
            this.guesses = await guessApi.getGuesses(playerId, attemptId);
        }
    },
    persistedState: {
        persist: false,
    },
});
