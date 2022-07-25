<template>
    <div
        class="relative flex items-center justify-center w-20 h-20 m-1 text-3xl font-bold text-white bg-gray-200 md:w-36 md:h-36 md:text-5xl"
        :class="customClasses"
        ref="square"
    >
        <div>
            {{ hideNumbers ? '' : guessedNumber }}
        </div>
        <svg v-if="svgPathData && isPurple" class="absolute w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <path :d="svgPathData" stroke="none" fill="purple" />
        </svg>
    </div>
</template>
<script>
import NumberUsageMixin from "../mixins/NumberUsageMixin";

export default {
    name: 'NumberSquareComponent',
    mixins: [NumberUsageMixin],
    props: {
        colIndex: {
            type: Number,
        },
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
            width: 0,
            animationClasses: ''
        };
    },
    computed: {
        getBackgroundClasses() {
            if (_.isNil(this.guessedNumber)) {
                return '';
            }
            if (!this.submitted) {
                return 'text-black';
            }
            if (this.guessedNumber === this.correctNumber) {
                return 'bg-green-600 text-white';
            }
            // if (this.isNumberUsedMultipleTimes(this.guessedNumber)) {
            //     return 'bg-purple-600 text-white';
            // }
            if (this.isNumberCorrect(this.guessedNumber)) {
                return 'bg-yellow-500 text-white';
            }
            return 'bg-gray-500 text-white';
        },
        isPurple() {
            /**
             * correct numbers are 399 and guessed 900, the purple should be ✅
             * correct numbers are 399 and guessed 398, the purple should be ✅
             * correct numbers are 399 and guessed 399, the purple should gone ✅
             * correct numbers are 399 and guessed 199, the purple should gone ✅
             * correct numbers are 399 and guessed 991, the purple should gone ✅ 
             * 
             * correct numbers are 999 and guessed 911, the purple should be ✅
             * correct numbers are 999 and guessed 991, the purple should be ✅
             * correct numbers are 999 and guessed 999, the purple should gone ✅
             */
            return this.submitted
                && _.countBy(this.correctNumbers, (n) => n == this.guessedNumber ? 'count' : 'miss')['count']
                    > _.countBy(this.lastSubmittedGuessNumbers, (n) => n == this.guessedNumber ? 'count' : 'miss')['count'];
        },
        customClasses() {
            return _.join([this.getBackgroundClasses, this.animationClasses], ' ');
        },
        svgPathData() {
            // * Draw a bezier curve for purple arc
            // * Sample 'M 40 0 L 40 40 M 40 0 q -10 20 0 40'
            const w = this.width;
            if (w) {
                return `M ${w} 0 L ${w} ${w} M ${w} 0 q -${w / 4} ${w / 2} 0 ${w}`;
            }
            return '';
        },
    },
    created() {
        window.addEventListener("resize", this.onResize);
    },
    destroyed() {
        window.removeEventListener("resize", this.onResize);
    },
    methods: {
        onResize(e) {
            this.width = this.$refs['square'].clientWidth;
        },
        getAnimationClasses() {
            if (this.guessedNumber == null || this.hideNumbers) {
                this.animationClasses = '';
                return;
            }
            if (!this.submitted) {
                this.animationClasses = 'animate-scale-up';
                return;
            }
            if (this.submitted) {
                this.animationClasses = `animation-rotate-delay-${this.colIndex * 7}00 delay-transition-color-${this.colIndex * 7}00`;
                return;
            }
        },
    },
    mounted() {
        this.width = this.$refs['square'].clientWidth;
    },
    watch: {
        guessedNumber() {
            this.getAnimationClasses();
        },
        submitted() {
            this.getAnimationClasses();
        },
        hideNumbers() {
            this.getAnimationClasses();
        },
    },
}
</script>
<style>

.delay-transition-color-000 {
    transition-property: all;
    transition-duration: 0.3s;
    transition-delay: 0.4s;
}

.delay-transition-color-700 {
    transition-property: all;
    transition-duration: 0.3s;
    transition-delay: 1.1s;
}

.delay-transition-color-1400 {
    transition-property: all;
    transition-duration: 0.3s;
    transition-delay: 1.8s;
}

.animation-rotate-delay-000 {
    animation-name: rotateX180;
    animation-duration: 0.7s;
    animation-iteration-count: 1;
    animation-delay: 0s;
}
.animation-rotate-delay-700 {
    animation-name: rotateX180;
    animation-duration: 0.7s;
    animation-iteration-count: 1;
    animation-delay: 0.7s;
}
.animation-rotate-delay-1400 {
    animation-name: rotateX180;
    animation-duration: 0.7s;
    animation-iteration-count: 1;
    animation-delay: 1.4s;
}
@keyframes rotateX180 {
	0% {transform: rotateX(180deg);}
	100% {transform: none;}
}

</style>