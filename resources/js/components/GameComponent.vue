<template>
    <div class="w-full h-auto mx-auto">
        <div class="flex flex-col items-center justify-center w-full h-full">
            <div
                v-for="(row, index) in board"
                class="flex flex-row"
                :key="'board_row_' + index"
            >
                <NumberSquareComponent
                    :guessed-number="row[0] ?? null"
                    :correct-number="currentGame.number_one"
                    :submitted="isRowSubmitted(index)"
                    :hide-numbers="hideNumbers"
                />
                <NumberSquareComponent
                    :guessed-number="row[1] ?? null"
                    :correct-number="currentGame.number_two"
                    :submitted="isRowSubmitted(index)"
                    :hide-numbers="hideNumbers"
                />
                <NumberSquareComponent
                    :guessed-number="row[2] ?? null"
                    :correct-number="currentGame.number_three"
                    :submitted="isRowSubmitted(index)"
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
import {useAttemptStore, useGameStore, useGuessStore, usePlayerStore} from "../store";
import NumberSquareComponent from "./NumberSquareComponent";
import InputNumbersComponent from "./InputNumbersComponent";
import {filter} from "lodash";

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
        ...mapState(useGameStore, ['currentGame']),
        ...mapState(useGuessStore, ['currentGuess', 'guesses', 'board']),
        ...mapState(useAttemptStore, ['currentAttempt']),
        ...mapState(usePlayerStore, ['currentPlayer']),
    },
    methods: {
        ...mapActions(useGuessStore, ['addNumberToGuess', 'removeNumberFromGuess', 'submitGuess']),
        isRowSubmitted(index) {
            return filter(this.guesses, guess => guess.row === index + 1).length > 0;
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
