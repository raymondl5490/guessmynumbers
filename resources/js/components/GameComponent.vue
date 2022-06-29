<template>
    <div class="w-full h-auto mx-auto">
        <div class="flex flex-col items-center justify-center w-full h-full">
            <div
                v-for="(row, rowIndex) in board"
                class="flex flex-row"
                :key="'board_row_' + rowIndex"
            >
                <NumberSquareComponent
                    v-for="colIndex in [0, 1, 2]"
                    :key="`board_square_${rowIndex}_${colIndex}`"
                    :guessed-number="row[colIndex] ?? null"
                    :correct-number="correctNumbers[colIndex]"
                    :submitted="isRowSubmitted(rowIndex)"
                    :hide-numbers="hideNumbers"
                />
            </div>

            <div
                v-if="!hideNumbers"
                class="flex flex-row"
            >
                <InputNumbersComponent
                    @number-selected="onNumberSelected"
                    @number-deleted="onNumberDeleted"
                    @submit="onSubmitGuess"
                />
            </div>
        </div>
    </div>
</template>
<script>
import {mapActions, mapState} from "pinia";
import {useAttemptStore, useGuessStore, usePlayerStore} from "../store";
import NumberSquareComponent from "./NumberSquareComponent";
import InputNumbersComponent from "./InputNumbersComponent";

export default {
    components: {
        InputNumbersComponent,
        NumberSquareComponent,
    },
    props: {
        hideNumbers: {
            type: Boolean,
            default: false,
        }
    },
    data() {
        return {
            squareOneClasses: '',
            squareTwoClasses: '',
            squareThreeClasses: '',
        }
    },
    computed: {
        ...mapState(useAttemptStore, ['correctNumbers']),
        ...mapState(useGuessStore, ['guesses', 'board']),
        ...mapState(usePlayerStore, ['currentPlayer']),
    },
    methods: {
        ...mapActions(useGuessStore, ['addNumberToGuess', 'removeNumberFromGuess', 'submitGuess']),
        isRowSubmitted(index) {
            return index < this.guesses.length;
        },
        onNumberSelected(number) {
            this.addNumberToGuess(number);
        },
        onNumberDeleted() {
            this.removeNumberFromGuess();
        },
        async onSubmitGuess() {
            await this.submitGuess()
        },
    }
}
</script>
