<template>
    <div class="grid grid-cols-3 gap-x-2 md:gap-x-6 gap-y-1 place-items-center">
        <NumberPadNumber
            v-for="number in [1, 2, 3]"
            :number="number"
            :key="'number_pad_number_' + number"
            :disabled="isAttemptEnded"
            :class="inputNumberStyle(number)"
            @click="handleNumberClick(number)"
        />
        <NumberPadNumber
            v-for="number in [4, 5, 6]"
            :number="number"
            :key="'number_pad_number_' + number"
            :disabled="isAttemptEnded"
            :class="inputNumberStyle(number)"
            @click="handleNumberClick(number)"
        />
        <NumberPadNumber
            v-for="number in [7, 8, 9]"
            :number="number"
            :key="'number_pad_number_' + number"
            :disabled="isAttemptEnded"
            :class="inputNumberStyle(number)"
            @click="handleNumberClick(number)"
        />
        <button
            :disabled="isAttemptEnded"
            class="flex items-center justify-center w-24 h-10 text-red-600 bg-gray-200 rounded-full cursor-pointer md:text-3xl md:w-36 md:h-20 hover:brightness-90"
            @click="handleNumberDeleted"
        >
            <IconComponent icon="arrow-left" />
        </button>
        <NumberPadNumber
            :number="0"
            :key="'number_pad_number_' + 0"
            :disabled="isAttemptEnded"
            :class="inputNumberStyle(0)"
            @click="handleNumberClick(0)"
        />
        <button
            :disabled="isAttemptEnded"
            class="flex items-center justify-center w-24 h-10 text-green-600 bg-gray-200 rounded-full cursor-pointer md:text-3xl md:w-36 md:h-20 hover:brightness-90"
            @click="handleSubmit"
        >
            <IconComponent icon="check" />
        </button>
    </div>
</template>
<script>
import { useGuessStore, useAttemptStore } from "../store";
import NumberUsageMixin from "../mixins/NumberUsageMixin";
import { mapState, mapActions } from "pinia";
import { IconComponent, NumberPadNumber } from "./ui";

export default {
    mixins: [NumberUsageMixin],
    components: {
        IconComponent,
        NumberPadNumber,
    },
    data() {
        return {
            numbers: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            rowOne: [0, 1, 2, 3, 4],
            rowTwo: [5, 6, 7, 8, 9],
        }
    },
    mounted() {
        window.addEventListener('keyup', event => {
            if (this.isAttemptEnded) return;

            const {key} = event;
            if (_.includes(this.numbers, Number(key))) {
                this.handleNumberClick(Number(key));
            }

            if (key === 'Backspace') {
                this.handleNumberDeleted();
            }

            if (key === 'Enter') {
                this.handleSubmit();
            }
        });
    },
    computed: {
        ...mapState(useAttemptStore, ['isAttemptEnded']),
    },
    methods: {
        ...mapActions(useGuessStore, ['addNumberToGuess', 'removeNumberFromGuess', 'submitGuess']),
        handleNumberClick(number) {
            // this.$emit('number-selected', number);
            this.addNumberToGuess(number);
        },
        handleNumberDeleted() {
            // this.$emit('number-deleted');
            this.removeNumberFromGuess();
        },
        async handleSubmit() {
            // this.$emit('submit');
            await this.submitGuess();
        },
        inputNumberStyle(number) {
            if (!this.isNumberOnBoard(number)) {
                return '';
            }
            if (!this.hasNumberBeenSubmitted(number)) {
                return 'border border-gray-500 text-black delay-transition-color-1400';
            }
            if (this.isNumberCorrect(number) && this.isNumberInCorrectSpot(number)) {
                return 'bg-green-600 text-white delay-transition-color-1400';
            }
            // if (this.isNumberUsedMultipleTimes(this.guessedNumber)) {
            //     return 'bg-purple-600 text-white delay-transition-color-1400';
            // }
            if (this.isNumberCorrect(number) && !this.isNumberInCorrectSpot(number)) {
                return 'bg-yellow-500 text-white delay-transition-color-1400';
            }
            return 'bg-gray-500 text-white delay-transition-color-1400';
        },
    }
}
</script>
