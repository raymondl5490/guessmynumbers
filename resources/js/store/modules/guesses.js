import {defineStore} from "pinia";

import { guessApi } from '../../api';
import {useAttemptStore, usePlayerStore} from "../index";
import {forEach} from "lodash";

export default defineStore('guesses', {
    state: () => ({
        guess: [],
        guesses: [], // * {number_one, number_two, number_three}[]
    }),
    getters: {
        /**
         * 
         * @returns guess numbers in array of array : [ [],[],[] ]
         */
        submittedGuessNumbers() {
            const numbers = [];
            forEach(this.guesses, guess => {
                numbers.push([
                    guess.number_one,
                    guess.number_two,
                    guess.number_three
                ]);
            });

            return numbers;
        },
        /**
         * 
         * @return Last submitted guess numbers in array; ex: [ 4, 5, 6 ]
         */
        lastSubmittedGuessNumbers() {
            return this.submittedGuessNumbers[this.submittedGuessNumbers.length - 1];
        },
        /**
         * 
         * @return Count correct spots of last submitted guess numbers; ex: 0 ~ 3
         */
        countCorrectSpotsOfLastSubmittedGuessNumbers() {
            const attemptStore = useAttemptStore();
            let count = 0;
            for (let i = 0; i < 3; i++) {
                if (this.lastSubmittedGuessNumbers[i] === attemptStore.correctNumbers[i]) count++;
            }
            return count;
        },

        board() {
            const board = [[], [], []];

            for (let i = 0; i < this.guesses.length; i++) {
                board[i] = [
                    this.guesses[i].number_one,
                    this.guesses[i].number_two,
                    this.guesses[i].number_three,
                ];
            }
            if (this.guesses.length < 3) {
                board[this.guesses.length] = this.guess;
            }
            return board;
        },
        /**
         * 
         * @return number 0: never won, 1: won on first guess row, ...
         */
        wonOnXthGuess() {
            const attemptStore = useAttemptStore();
            let xth = 0;
            _.each(this.guesses, (guess, index) => {
                if (_.isEqual([guess.number_one, guess.number_two, guess.number_three], attemptStore.correctNumbers)) {
                    xth = index + 1;
                }
            });
            return xth;
        },
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
        },
        async submitGuess() {
            if (this.guess.length < 3) {
                return;
            }

            if (this.guesses.length >= 3) {
                return;
            }

            const attemptStore = useAttemptStore();

            const wonCurrentGuess = _.isEqual(this.guess, attemptStore.correctNumbers);
            const currentGuess = {
                row: this.guesses.length + 1,
                number_one: this.guess[0],
                number_two: this.guess[1],
                number_three: this.guess[2],
                won: wonCurrentGuess,
            }

            this.guesses.push({
                number_one: this.guess[0],
                number_two: this.guess[1],
                number_three: this.guess[2],
            });

            this.resetGuess();

            if (!attemptStore.isPracticeMode) {
                const playerStore = usePlayerStore();
                await guessApi.createGuess(
                    playerStore.currentPlayer.id,
                    attemptStore.currentAttempt.id,
                    currentGuess,
                );
                await this.getGuesses(
                    playerStore.currentPlayer.id,
                    attemptStore.currentAttempt.id
                );
                if (wonCurrentGuess) {
                    await attemptStore.winAttempt();
                }
            }
        },
        removeNumberFromGuess() {
            if (!this.guess.length) return;
            this.guess.pop();
        },
        resetGuess() {
            this.guess = [];
        },
        async getGuesses(playerId, attemptId) {
            this.guesses = await guessApi.getGuesses(playerId, attemptId);
        },
        resetGuessStore() {
            this.guesses = [];
            this.guess = [];
        },
    },
    persistedState: {
        persist: false,
    },
});
