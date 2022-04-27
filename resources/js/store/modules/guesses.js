import {defineStore} from "pinia";

import { guessApi } from '../../api';
import {usePlayerStore} from "../index";
import {concat} from "lodash";

export default defineStore('guesses', {
    state: () => ({
        guess: [],
    }),
    getters: {
        currentGuess() {
            const playerStore = usePlayerStore();
            return {
                row: playerStore.currentAttempt.guesses ? playerStore.currentAttempt.guesses.length + 1 : 1,
                number_one: this.guess[0],
                number_two: this.guess[1],
                number_three: this.guess[2],
            }
        },
        guesses() {
            const playerStore = usePlayerStore();
            const guesses = playerStore.currentAttempt.guesses ?? []
            return concat(guesses, this.currentGuess);
        }
    },
    actions: {
        async addNumberToGuess(number) {
            this.guess.push(number);

            if (this.guess.length === 3) {
                const playerStore = usePlayerStore();
                await this.saveGuess(playerStore.currentPlayer.id, playerStore.currentAttempt.id, this.currentGuess);
            }
        },
        removeNumberFromGuess() {
            this.guess.pop();
        },
        async saveGuess(playerId, attemptId, payload) {
            const playerStore = usePlayerStore();
            await guessApi.createGuess(playerId, attemptId, payload);
            this.guess = [];
            await playerStore.getPlayer(playerStore.currentPlayer.id);
        }
    }
});
