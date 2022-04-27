<template>
    <div
        class="w-20 h-20 m-1 bg-gray-200 text-3xl font-bold text-white flex justify-center items-center"
        :class="style"
    >
        {{ guessedNumber }}
    </div>
</template>
<script>
import {filter, flatten, forEach, includes, indexOf, isEmpty} from "lodash";
import {mapState} from "pinia/dist/pinia.esm-browser";
import {useGameStore, useGuessStore} from "../store";

export default {
    props: {
        correctNumber: {
            type: Number,
            required: true,
        },
        guessedNumber: {
            type: Number,
            default: null,
        },
        submitted: {
            type: Boolean,
            default: false,
        }
    },
    computed: {
        ...mapState(useGameStore, ['board', 'correctNumbers']),
        ...mapState(useGuessStore, ['existingGuessNumbers', 'guess']),
        style() {
            if (this.submitted && this.guessedNumber === this.correctNumber) {
                return 'bg-green-500';
            } else if (this.submitted && this.isNumberCorrect(this.guessedNumber)) {
                return 'bg-yellow-500';
            } else if (this.submitted && this.guessedNumber !== this.correctNumber) {
                return 'bg-gray-500';
            }

            if (this.guessedNumber !== null && this.guessedNumber !== undefined) {
                return 'bg-gray-500'
            }
        }
    },
    methods: {
        isNumberOnBoard(number) {
            const flatBoard = flatten(this.board);
            return includes(flatBoard, number);
        },
        isNumberCorrect(number) {
            return includes(this.correctNumbers, number);
        },
        isNumberInCorrectSpot(number) {
            const correctIndex = indexOf(this.correctNumbers, number);
            let inCorrectSpot = false;
            forEach(this.existingGuessNumbers, existingNumbers => {
                if (existingNumbers[correctIndex] === number) {
                    inCorrectSpot = true;
                }
            });

            return inCorrectSpot;
        },
        isNumberUsedMultipleTimes(number) {
            return filter(this.correctNumbers, number).length > 1;
        },
        hasNumberBeenSubmitted(number) {
            let submitted = false;
            forEach(this.existingGuessNumbers, existingNumbers => {
                if (includes(existingNumbers, number)) {
                    submitted = true;
                }
            });

            return submitted;
        },
        getNumberStyle(number) {
            if (!this.isNumberOnBoard(number)) {
                return;
            }

            if (!this.hasNumberBeenSubmitted(number)) {
                return 'bg-gray-500 text-white';
            }

            if (this.isNumberCorrect(number) && this.isNumberInCorrectSpot(number)) {
                return 'bg-green-500 text-white';
            }

            if (this.isNumberCorrect(number) && !this.isNumberInCorrectSpot(number)) {
                return 'bg-yellow-500 text-white';
            }

            return 'bg-gray-500 text-white';
        },
    }
}
</script>
