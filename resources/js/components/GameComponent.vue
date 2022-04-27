<template>
    <div class="w-screen h-screen">
        <div class="w-full h-full flex flex-col justify-center items-center">
            <div class="flex flex-row">
                <NumberSquareComponent/>
                <NumberSquareComponent/>
                <NumberSquareComponent/>
            </div>
            <div class="flex flex-row">
                <NumberSquareComponent/>
                <NumberSquareComponent/>
                <NumberSquareComponent/>
            </div>
            <div class="flex flex-row">
                <NumberSquareComponent/>
                <NumberSquareComponent/>
                <NumberSquareComponent/>
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
