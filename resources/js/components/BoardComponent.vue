<template>
    <div class="flex flex-col items-center justify-center">
        <div
            v-for="(row, rowIndex) in board"
            class="flex flex-row"
            :key="'board_row_' + rowIndex"
        >
            <NumberSquareComponent
                v-for="colIndex in [0, 1, 2]"
                :key="`board_square_${rowIndex}_${colIndex}`"
                :col-index="colIndex"
                :guessed-number="row[colIndex] ?? null"
                :correct-number="correctNumbers[colIndex]"
                :submitted="isRowSubmitted(rowIndex)"
                :hide-numbers="hideNumbers"
            />
        </div>
    </div>
</template>
<script>
import {mapState} from "pinia";
import {useAttemptStore, useGuessStore} from "../store";
import NumberSquareComponent from "./NumberSquareComponent";

export default {
    components: {
        NumberSquareComponent,
    },
    props: {
        hideNumbers: {
            type: Boolean,
            default: false,
        }
    },
    computed: {
        ...mapState(useAttemptStore, ['correctNumbers']),
        ...mapState(useGuessStore, ['guesses', 'board']),
    },
    methods: {
        isRowSubmitted(index) {
            return index < this.guesses.length;
        },
    }
}
</script>
