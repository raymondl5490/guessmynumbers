<template>
    <div class="flex flex-col font-bold">
        <div class="flex flex-row my-2">
            <button
                v-for="number in rowOne"
                :key="number"
                :disabled="isAttemptEnded"
                class="flex items-center justify-center w-8 h-8 mx-1 bg-gray-200 rounded-full cursor-pointer md:w-12 md:h-12 md:text-lg hover:bg-gray-500 hover:text-white"
                :class="inputNumberStyle(number)"
                @click="handleNumberClick(number)"
            >
                {{ number }}
            </button>
            <button
                class="flex items-center justify-center w-auto h-8 px-3 mx-1 text-red-600 bg-gray-200 rounded-full cursor-pointer md:h-12 md:text-lg hover:bg-gray-500 hover:text-red-400"
                :disabled="isAttemptEnded"
                @click="handleNumberDeleted"
            >
                <IconComponent
                    class="text-gray-600 hover:text-gray-900"
                    icon="arrow-left"
                />
            </button>
        </div>
        <div class="flex flex-row">
            <button
                v-for="number in rowTwo"
                :key="number"
                :disabled="isAttemptEnded"
                class="flex items-center justify-center w-8 h-8 mx-1 bg-gray-200 rounded-full cursor-pointer md:w-12 md:h-12 md:text-lg hover:bg-gray-500 hover:text-white"
                :class="inputNumberStyle(number)"
                @click="handleNumberClick(number)"
            >
                {{ number }}
            </button>
            <button
                :disabled="isAttemptEnded"
                class="flex items-center justify-center w-auto h-8 px-3 mx-1 text-green-600 bg-gray-200 rounded-full cursor-pointer md:h-12 md:text-lg hover:bg-gray-400 hover:text-green-400"
                @click="handleSubmit"
            >
                <IconComponent
                    class="text-gray-600 hover:text-gray-900"
                    icon="check"
                />
            </button>
        </div>
    </div>
</template>
<script>
import {includes} from "lodash";
import { useAttemptStore } from "../store";
import NumberUsageMixin from "../mixins/NumberUsageMixin";
import { mapState } from "pinia";
import { IconComponent } from "./ui";

export default {
    mixins: [NumberUsageMixin],
    components: {
        IconComponent,
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
