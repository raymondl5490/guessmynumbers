<template>

</template>
<script>
import {mapState} from "pinia/dist/pinia.esm-browser";
import {useAttemptStore, useGuessStore} from "../store";

export default {
    computed: {
        ...mapState(useAttemptStore, ['correctNumbers']),
        ...mapState(useGuessStore, ['submittedGuessNumbers', 'guess', 'board', 'lastSubmittedGuessNumbers']),
    },
    methods: {
        isNumberOnBoard(number) {
            const flatBoard = _.flatten(this.board);
            return _.includes(flatBoard, number);
        },
        isNumberCorrect(number) {
            return _.includes(this.correctNumbers, number);
        },
        isNumberInCorrectSpot(number) {
            const findIndices = (values, target) => {
                return _.chain(values)
                    .map((value, index) => {
                        return value === target ? index : null;
                    })
                    .filter((index) => !_.isNull(index))
                    .value();
            };

            const correctIndices = findIndices(this.correctNumbers, number);

            for (let i = 0; i < this.submittedGuessNumbers.length; i++) {
                const guessNumbers = this.submittedGuessNumbers[i];
                if (!_.isEmpty(_.intersection(findIndices(guessNumbers, number), correctIndices))) {
                    return true;
                }
            }
            return false;
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
