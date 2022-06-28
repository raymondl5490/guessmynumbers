import {attemptApi} from '../../api';
import {defineStore} from 'pinia';

export default defineStore('attempts', {
    state: () => ({
        currentAttempt: {},
    }),
    getters: {},
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
}, {
    persist: true,
});
