<template>
    <div class="w-screen h-screen">
        <div class="w-full h-full flex flex-col justify-center items-center">
            <div
                v-for="(row, index) in board"
                class="flex flex-row"
            >
                <NumberSquareComponent
                    :guessed-number="row[0] ?? null"
                    :correct-number="currentGame.number_one"
                    :submitted="isRowSubmitted(index)"
                />
                <NumberSquareComponent
                    :guessed-number="row[1] ?? null"
                    :correct-number="currentGame.number_two"
                    :submitted="isRowSubmitted(index)"
                />
                <NumberSquareComponent
                    :guessed-number="row[2] ?? null"
                    :correct-number="currentGame.number_three"
                    :submitted="isRowSubmitted(index)"
                />
            </div>

            <div class="flex flex-row">
                <InputNumbersComponent
                    @number-selected="onNumberSelected"
                    @number-deleted="onNumberDeleted"
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
import {forEach} from "lodash";

export default {
    components: {
        InputNumbersComponent,
        NumberSquareComponent,
    },
    data() {},
    computed: {
        ...mapState(useGameStore, ['currentGame', 'board']),
        ...mapState(useGuessStore, ['currentGuess', 'guesses']),
        ...mapState(useAttemptStore, ['currentAttempt']),
        ...mapState(usePlayerStore, ['currentPlayer']),
    },
    methods: {
        ...mapActions(useGuessStore, ['addNumberToGuess', 'removeNumberFromGuess']),
        isRowSubmitted(index) {
            return this.board[index].length === 3 && this.board[index][2] !== null;
        },
        onNumberSelected(number) {
            this.addNumberToGuess(number);
        },
        onNumberDeleted() {
            this.removeNumberFromGuess();
        },
        handleKey(event) {
            console.log({ event })
        }
    }
}
</script>
