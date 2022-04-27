<template>
    <div class="w-screen h-screen">
        <div class="w-full h-full flex flex-col justify-center items-center">
            <div
                v-for="row in rows"
                class="flex flex-row"
            >
                <NumberSquareComponent :guessed-number="row[0] ?? null"/>
                <NumberSquareComponent :guessed-number="row[1] ?? null"/>
                <NumberSquareComponent :guessed-number="row[2] ?? null"/>
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
import {useGameStore, useGuessStore, usePlayerStore} from "../store";
import NumberSquareComponent from "./NumberSquareComponent";
import InputNumbersComponent from "./InputNumbersComponent";
import {forEach} from "lodash";

export default {
    components: {
        InputNumbersComponent,
        NumberSquareComponent,
    },
    data() {
        return {
            gridColumns: 3,
            gridRows: 3,
        }
    },
    computed: {
        ...mapState(useGameStore, ['currentGame']),
        ...mapState(useGuessStore, ['currentGuess', 'guesses']),
        ...mapState(usePlayerStore, ['currentPlayer', 'currentAttempt']),
        rows() {
            const rows = [
                [],
                [],
                []
            ];

            forEach(this.guesses, guess => {
                console.log({ guess })
                rows[guess.row - 1][0] = guess.number_one ?? null;
                rows[guess.row - 1][1] = guess.number_two ?? null;
                rows[guess.row - 1][2] = guess.number_three ?? null;
            })

            return rows;
        }
    },
    methods: {
        ...mapActions(useGuessStore, ['addNumberToGuess', 'removeNumberFromGuess']),
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
