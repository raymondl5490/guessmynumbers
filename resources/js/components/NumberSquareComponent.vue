<template>
    <div
        class="w-20 h-20 md:w-28 md:h-28 m-1 bg-gray-200 text-3xl md:text-5xl font-bold text-white flex justify-center items-center"
        :class="getNumberStyle(guessedNumber, !submitted, correctNumber)"
    >
        {{ hideNumbers ? '' : guessedNumber }}
    </div>
</template>
<script>
import NumberUsageMixin from "../mixins/NumberUsageMixin";

export default {
    mixins: [NumberUsageMixin],
    props: {
        correctNumber: {
            type: Number,
            required: true,
        },
        guessedNumber: {
            type: Number,
            default: null,
        },
        submitted: {
            type: Boolean,
            default: false,
        },
        hideNumbers: {
            type: Boolean,
            default: false,
        }
    }
}
</script>
