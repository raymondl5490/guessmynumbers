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
                return 'bg-gray-500 text-white';
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
            return this.submitted && this.isNumberUsedMultipleTimes(this.guessedNumber);
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
                this.animationClasses = `animation-rotate-delay-${this.colIndex * 3}00 delay-transition-color-${this.colIndex * 3}00`;
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
    transition-delay: 0s;
}

.delay-transition-color-300 {
    transition-property: all;
    transition-delay: 0.3s;
}

.delay-transition-color-600 {
    transition-property: all;
    transition-delay: 0.6s;
}

.animation-rotate-delay-000 {
    animation-name: rotateX180;
    animation-duration: 0.3s;
    animation-iteration-count: 1;
    animation-delay: 0s;
}
.animation-rotate-delay-300 {
    animation-name: rotateX180;
    animation-duration: 0.3s;
    animation-iteration-count: 1;
    animation-delay: 0.3s;
}
.animation-rotate-delay-600 {
    animation-name: rotateX180;
    animation-duration: 0.3s;
    animation-iteration-count: 1;
    animation-delay: 0.6s;
}
@keyframes rotateX180 {
	0% {transform: none;}
	50% {transform: rotateX(180deg);}
	100% {transform: none;}
}

</style>