import {attemptApi} from '../../api';
import {defineStore} from 'pinia';
import { useGameStore, useGuessStore } from '../index';

import { ATTEMPT_STATUS_CODES } from '../../utils/constants';

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

        attemptStatus() {
            const guessStore = useGuessStore();

            let status = [];

            if (this.isPracticeMode) {
                status.push(ATTEMPT_STATUS_CODES.MODE_PRACTICE);
            } else {
                status.push(ATTEMPT_STATUS_CODES.MODE_REGULAR);
            }

            if (guessStore.wonOnXthGuess || guessStore.guesses.length >= 3) {
                status.push(ATTEMPT_STATUS_CODES.STATUS_ENDED);
                if (guessStore.wonOnXthGuess) {
                    status.push(ATTEMPT_STATUS_CODES.STATUS_ENDED_WIN);
                    switch (guessStore.wonOnXthGuess) {
                        case 1:
                            status.push(ATTEMPT_STATUS_CODES.STATUS_ENDED_WIN_1);
                            break;
                        case 2:
                            status.push(ATTEMPT_STATUS_CODES.STATUS_ENDED_WIN_2);
                            break;
                        case 3:
                            status.push(ATTEMPT_STATUS_CODES.STATUS_ENDED_WIN_3);
                            break;

                        default:
                            break;
                    }
                } else {
                    status.push(ATTEMPT_STATUS_CODES.STATUS_ENDED_LOSE);
                    switch (guessStore.countCorrectSpotsOfLastSubmittedGuessNumbers) {
                        case 0:
                            status.push(ATTEMPT_STATUS_CODES.STATUS_ENDED_LOSE_0);
                            break;
                        case 1:
                            status.push(ATTEMPT_STATUS_CODES.STATUS_ENDED_LOSE_1);
                            break;
                        case 2:
                            status.push(ATTEMPT_STATUS_CODES.STATUS_ENDED_LOSE_2);
                            break;
                    
                        default:
                            break;
                    }
                }
            } else {
                status.push(ATTEMPT_STATUS_CODES.STATUS_RUNNING);
            }
            return status;
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
