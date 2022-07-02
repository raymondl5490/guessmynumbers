<template>
    <div class="grid grid-cols-3 gap-x-2 gap-y-1">
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
            class="flex items-center justify-center w-24 h-10 text-red-600 bg-gray-200 rounded-full cursor-pointer md:text-3xl md:w-36 md:h-20 hover:bg-gray-500 hover:text-white"
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
            class="flex items-center justify-center w-24 h-10 text-green-600 bg-gray-200 rounded-full cursor-pointer md:text-3xl md:w-36 md:h-20 hover:bg-gray-500 hover:text-white"
            @click="handleSubmit"
        >
            <IconComponent icon="check" />
        </button>
    </div>
</template>
<script>
import {includes} from "lodash";
import { useAttemptStore } from "../store";
import NumberUsageMixin from "../mixins/NumberUsageMixin";
import { mapState } from "pinia";
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
            if (includes(this.numbers, Number(key))) {
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
        handleNumberClick(number) {
            this.$emit('number-selected', number);
        },
        handleNumberDeleted() {
            this.$emit('number-deleted');
        },
        handleSubmit() {
            this.$emit('submit');
        },
        inputNumberStyle(number) {
            if (!this.isNumberOnBoard(number)) {
                return '';
            }
            if (!this.hasNumberBeenSubmitted(number)) {
                return 'bg-gray-500 text-white';
            }
            if (this.isNumberCorrect(number) && this.isNumberInCorrectSpot(number)) {
                return 'bg-green-600 text-white';
            }
            // if (this.isNumberUsedMultipleTimes(this.guessedNumber)) {
            //     return 'bg-purple-600 text-white';
            // }
            if (this.isNumberCorrect(number) && !this.isNumberInCorrectSpot(number)) {
                return 'bg-yellow-500 text-white';
            }
            return 'bg-gray-500 text-white';
        },
    }
}
</script>
