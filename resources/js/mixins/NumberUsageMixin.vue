<template>

</template>
<script>
import {filter, flatten, forEach, includes, indexOf} from "lodash";
import {mapState} from "pinia/dist/pinia.esm-browser";
import {useAttemptStore, useGuessStore} from "../store";

export default {
    computed: {
        ...mapState(useAttemptStore, ['correctNumbers']),
        ...mapState(useGuessStore, ['submittedGuessNumbers', 'guess', 'board']),
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
            forEach(this.submittedGuessNumbers, existingNumbers => {
                if (existingNumbers[correctIndex] === number) {
                    inCorrectSpot = true;
                }
            });

            return inCorrectSpot;
        },
        isNumberUsedMultipleTimes(number) {
            return _.countBy(this.correctNumbers, (n) => n == number ? 'count' : 'miss')['count'] > 1;
        },
        hasNumberBeenSubmitted(number) {
            return _.includes(_.flatten(this.submittedGuessNumbers), number);
        },
    }
}
</script>
