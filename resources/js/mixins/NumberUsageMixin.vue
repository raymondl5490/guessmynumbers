<template>

</template>
<script>
import {filter, flatten, forEach, includes, indexOf} from "lodash";
import {mapState} from "pinia/dist/pinia.esm-browser";
import {useAttemptStore, useGuessStore} from "../store";

export default {
    computed: {
        ...mapState(useAttemptStore, ['correctNumbers']),
        ...mapState(useGuessStore, ['existingGuessNumbers', 'guess', 'board']),
    },
    methods: {
        isNumberOnBoard(number) {
            const flatBoard = flatten(this.board);
            return includes(flatBoard, number);
        },
        isNumberCorrect(number) {
            return includes(this.correctNumbers, number);
        },
        // correntNumber is not provided when this function called from InputNumbersComponent
        isNumberInCorrectSpot(number, correctNumber = null) {
            if (correctNumber !== null) {
                return number === correctNumber
            }

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
        // correntNumber is not provided when this function called from InputNumbersComponent
        getNumberStyle(number, isCurrentGuess = false, correctNumber = null) {
            if (!this.isNumberOnBoard(number)) {
                return '';
            }

            if (!this.hasNumberBeenSubmitted(number) || isCurrentGuess) {
                return 'bg-gray-500 text-white';
            }

            if (this.isNumberCorrect(number) && this.isNumberInCorrectSpot(number, correctNumber)) {
                return 'bg-green-600 text-white';
            }

            if (this.isNumberCorrect(number) && !this.isNumberInCorrectSpot(number, correctNumber)) {
                return 'bg-yellow-500 text-white';
            }

            return 'bg-gray-500 text-white';
        },
    }
}
</script>
