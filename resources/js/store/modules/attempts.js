import {attemptApi} from '../../api';
import {defineStore} from 'pinia';
import { useGameStore, useGuessStore } from '../index';

export default defineStore('attempts', {
    state: () => ({
        currentAttempt: {},
        isPracticeMode: false,
        practiceNumbers: [],
    }),
    getters: {
        // * This getter is used for gaming logic on the frontend.
        correctNumbers() {
            if (this.isPracticeMode) {
                return this.practiceNumbers;
            } else {
                const gameStore = useGameStore();
                return [gameStore.currentGame.number_one, gameStore.currentGame.number_two, gameStore.currentGame.number_three];
            }
        },
        won() {
            if (this.isPracticeMode) {
                const guessStore = useGuessStore();
                return guessStore.wonOnXthGuess;
            } else {
                return (this.currentAttempt && this.currentAttempt.won) ?? false;
            }
        },
        isAttemptEnded() {
            const guessStore = useGuessStore();
            return this.won || guessStore.guesses.length >= 3;
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
        generatePracticeNumbers() {
            this.practiceNumbers = [_.random(0, 9), _.random(0, 9), _.random(0, 9)];
        },
        goToPracticeMode() {
            this.isPracticeMode = true;
            this.generatePracticeNumbers();
            const guessStore = useGuessStore();
            guessStore.resetGuessStore();
        },
        goToRegularMode() {
            this.isPracticeMode = false;
            location.reload();
        }
    },
    persistedState: {
        persist: false,
        // persist: true,
        // includePaths: 'isPracticeMode',
    },
});
