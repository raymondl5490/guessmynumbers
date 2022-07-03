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
        getAnimationClasses() {
            if (this.guessedNumber == null) {
                return '';
            }

            return this.animationClasses;
        },
        customClasses() {
            return _.join([this.getBackgroundClasses, this.getAnimationClasses], ' ');
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
    },
    mounted() {
        this.width = this.$refs['square'].clientWidth;
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
