<template>
    <div class="flex flex-col font-bold">
        <div class="flex flex-row my-2">
            <div
                v-for="number in rowOne"
                :key="number"
                class="flex justify-center items-center mx-1 cursor-pointer rounded-full w-8 h-8 md:w-12 md:h-12 md:text-lg bg-gray-200 hover:bg-gray-500 hover:text-white"
                :class="getNumberStyle(number)"
                @click="handleNumberClick(number)"
            >
                {{ number }}
            </div>
            <div
                class="flex justify-center items-center mx-1 px-3 cursor-pointer rounded-full w-auto h-8 md:h-12 md:text-lg bg-gray-200 text-red-600 hover:bg-gray-500 hover:text-red-400"
                @click="handleNumberDeleted"
            >Delete
            </div>
        </div>
        <div class="flex flex-row">
            <div
                v-for="number in rowTwo"
                :key="number"
                class="flex justify-center items-center mx-1 cursor-pointer rounded-full w-8 h-8 md:w-12 md:h-12 md:text-lg bg-gray-200 hover:bg-gray-500 hover:text-white"
                :class="getNumberStyle(number)"
                @click="handleNumberClick(number)"
            >
                {{ number }}
            </div>
            <div
                class="flex justify-center items-center mx-1 px-3 cursor-pointer rounded-full w-auto h-8 md:h-12 md:text-lg bg-gray-200 text-green-600 hover:bg-gray-400 hover:text-green-400"
                @click="handleSubmit"
            >Submit
            </div>
        </div>
    </div>
</template>
<script>
import {includes} from "lodash";
import NumberUsageMixin from "../mixins/NumberUsageMixin";

export default {
    mixins: [NumberUsageMixin],
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
    methods: {
        handleNumberClick(number) {
            this.$emit('number-selected', number);
        },
        handleNumberDeleted() {
            this.$emit('number-deleted');
        },
        handleSubmit() {
            this.$emit('submit');
        }
    }
}
</script>
