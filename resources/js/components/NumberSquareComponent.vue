<template>
    <div
        class="flex items-center justify-center w-20 h-20 m-1 text-3xl font-bold text-white bg-gray-200 md:w-28 md:h-28 md:text-5xl"
        :class="customClasses"
    >
        {{ hideNumbers ? '' : guessedNumber }}
    </div>
</template>
<script>
import NumberUsageMixin from "../mixins/NumberUsageMixin";

export default {
    name: 'NumberSquareComponent',
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
    },
    data() {
        return {
            animationClasses: ''
        }
    },
    computed: {
        getBackgroundClasses() {
            if (_.isNil(this.guessedNumber)) {
                return '';
            }

            if (!this.submitted) {
                return 'bg-gray-500 text-white';
            }

            if (this.guessedNumber === this.correctNumber) {
                return 'bg-green-600 text-white';
            }

            if (this.isNumberCorrect(this.guessedNumber)) {
                return 'bg-yellow-500 text-white';
            }

            console.log('when you will get here');
            return 'bg-gray-500 text-white';
        },
        getAnimationClasses() {
            if (this.guessedNumber == null) {
                return '';
            }

            return this.animationClasses;
        },
        customClasses() {
            return _.join([this.getBackgroundClasses, this.getAnimationClasses], ' ');
        },
    },
    watch: {
        guessedNumber: {
            handler(newValue, oldValue) {
                if (newValue === null) {
                    this.animationClasses = '';
                }

                this.animationClasses = 'animate-scale-up';
            },
        }
    },
}
</script>
