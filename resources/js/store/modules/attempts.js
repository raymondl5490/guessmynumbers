import {attemptApi} from '../../api';
import {defineStore} from 'pinia';
import { useGuessStore } from '../index';

export default defineStore('attempts', {
    state: () => ({
        currentAttempt: {},
    }),
    getters: {
        won() {
            return this.currentAttempt.won;
        },
        finished() {
            const guesses = useGuessStore();
            return this.won || guesses.guesses.length >= 3
        },
    },
    actions: {
        async createAttempt(playerId, payload) {
            this.currentAttempt = await attemptApi.createAttempt(playerId, payload);
        },
        async getCurrentAttempt(playerId) {
            this.currentAttempt = await attemptApi.getCurrentAttempt(playerId);
        },
        async winAttempt() {
            this.currentAttempt = await attemptApi.winAttempt(this.currentAttempt.id);
        },
    },
    persistedState: {
        persist: false,
    },
});
