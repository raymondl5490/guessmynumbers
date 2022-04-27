<template>
    <div class="flex flex-row">
        <div
            v-for="number in numbers"
            :key="number"
            class="flex justify-center items-center mx-1 cursor-pointer rounded-full w-8 h-8 bg-gray-200 hover:bg-gray-400"
            @click="handleNumberClick(number)"
        >
            {{ number }}
        </div>
        <div
            class="flex justify-center items-center mx-1 px-3 cursor-pointer rounded-full w-auto h-8 bg-gray-200 text-red-600 hover:bg-gray-400 hover:text-red-400"
            @click="handleNumberDeleted"
        >Delete</div>
    </div>
</template>
<script>
import {includes, isEmpty} from "lodash";

export default {
    data() {
        return {
            numbers: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
        }
    },
    created() {
        window.addEventListener('keyup', event => {
            const { key } = event;
            if (includes(this.numbers, Number(key))) {
                this.handleNumberClick(Number(key));
            }

            if (key === 'Backspace') {
                this.handleNumberDeleted();
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
        handleKey(event) {
            console.log({ event })
        }
    }
}
</script>
