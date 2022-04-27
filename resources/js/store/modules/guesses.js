import {defineStore} from "pinia";

import { guessApi } from '../../api';
import {usePlayerStore} from "../index";

export default defineStore('guesses', {
    state: () => ({
        currentGuess: [],
    }),
    getters: {
        guesses() {
            const playerStore = usePlayerStore();
            return playerStore.currentAttempt.guesses
        }
    },
    actions: {
        addNumberToGuess(number) {
            if (this.currentGuess.length === 3) {
                return;
            }

            this.currentGuess.push(number);
        },
        removeNumberFromGuess() {
            this.currentGuess.pop();
        },
        async saveGuess(playerId, attemptId, payload) {
            await guessApi.createGuess(playerId, attemptId, payload);
            this.currentGuess = [];
        }
    }
});
