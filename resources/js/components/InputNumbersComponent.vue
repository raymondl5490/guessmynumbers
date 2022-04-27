<template>
    <div class="flex flex-col font-bold">
        <div class="flex flex-row my-2">
            <div
                v-for="number in rowOne"
                :key="number"
                class="flex justify-center items-center mx-1 cursor-pointer rounded-full w-8 h-8 bg-gray-200 hover:bg-gray-500 hover:text-white"
                :class="getNumberStyle(number)"
                @click="handleNumberClick(number)"
            >
                {{ number }}
            </div>
            <div
                class="flex justify-center items-center mx-1 px-3 cursor-pointer rounded-full w-auto h-8 bg-gray-200 text-red-600 hover:bg-gray-500 hover:text-red-400"
                @click="handleNumberDeleted"
            >Delete
            </div>
        </div>
        <div class="flex flex-row">
            <div
                v-for="number in rowTwo"
                :key="number"
                class="flex justify-center items-center mx-1 cursor-pointer rounded-full w-8 h-8 bg-gray-200 hover:bg-gray-500 hover:text-white"
                :class="getNumberStyle(number)"
                @click="handleNumberClick(number)"
            >
                {{ number }}
            </div>
            <div
                class="flex justify-center items-center mx-1 px-3 cursor-pointer rounded-full w-auto h-8 bg-gray-200 text-green-600 hover:bg-gray-400 hover:text-green-400"
                @click="handleSubmit"
            >Submit
            </div>
        </div>
    </div>
</template>
<script>
import {filter, includes, flatten, indexOf, forEach} from "lodash";
import {useGameStore, useGuessStore} from "../store";
import {mapState} from "pinia";

export default {
    data() {
        return {
            numbers: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
            rowOne: [0, 1, 2, 3, 4],
            rowTwo: [5, 6, 7, 8, 9],
        }
    },
    created() {
        window.addEventListener('keyup', event => {
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
        ...mapState(useGameStore, ['board', 'correctNumbers']),
        ...mapState(useGuessStore, ['existingGuessNumbers', 'guess']),
    },
    methods: {
        isNumberOnBoard(number) {
            const flatBoard = flatten(this.board);
            return includes(flatBoard, number);
        },
        isNumberCorrect(number) {
            return includes(this.correctNumbers, number);
        },
        isNumberInCorrectSpot(number) {
            const correctIndex = indexOf(this.correctNumbers, number);
            let inCorrectSpot = false;
            forEach(this.existingGuessNumbers, existingNumbers => {
                if (existingNumbers[correctIndex] === number) {
                    inCorrectSpot = true;
                }
            });

            return inCorrectSpot;
        },
        isNumberUsedMultipleTimes(number) {
            return filter(this.correctNumbers, number).length > 1;
        },
        hasNumberBeenSubmitted(number) {
            let submitted = false;
            forEach(this.existingGuessNumbers, existingNumbers => {
                if (includes(existingNumbers, number)) {
                    submitted = true;
                }
            });

            return submitted;
        },
        getNumberStyle(number) {
            if (!this.isNumberOnBoard(number)) {
                return;
            }

            if (!this.hasNumberBeenSubmitted(number)) {
                return 'bg-gray-500 text-white';
            }

            if (this.isNumberCorrect(number) && this.isNumberInCorrectSpot(number)) {
                return 'bg-green-500 text-white';
            }

            if (this.isNumberCorrect(number) && !this.isNumberInCorrectSpot(number)) {
                return 'bg-yellow-500 text-white';
            }

            return 'bg-gray-500 text-white';
        },
        handleNumberClick(number) {
            this.$emit('number-selected', number);
        },
        handleNumberDeleted() {
            this.$emit('number-deleted');
        },
        handleSubmit() {
            this.$emit('submit');
        },
        handleKey(event) {
            console.log({event})
        }
    }
}
</script>
