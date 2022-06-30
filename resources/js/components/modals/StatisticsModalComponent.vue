<template>
    <ModalComponent
        :show="show"
        @close="onClose"
    >
        <template #title>
            <div class="p-4 text-center bg-stone-200">
                Statistics
            </div>
        </template>
        <template #content>
            <div v-if="!isPracticeMode" class="grid w-full grid-cols-3 gap-8 my-5">
                <div class="p-2 text-center bg-gray-100 md:p-4 col">
                    <div class="text-3xl font-bold">
                        {{ currentGame.number_of_wons }}
                    </div>
                    <div class="text-xs text-gray-600">ROUNDS WINS</div>
                </div>
                <div class="p-2 text-center bg-gray-100 md:p-4 col">
                    <div class="text-3xl font-bold">
                        {{ currentGame.number_of_attempts }}
                    </div>
                    <div class="text-xs text-gray-600">ROUNDS PLAYED</div>
                </div>
                <div class="p-2 text-center bg-gray-100 md:p-4 col">
                    <div class="text-3xl font-bold">
                        {{ currentRoundWinPercentage }}
                    </div>
                    <div class="text-xs text-gray-600">% OF WINS</div>
                </div>
            </div>

            <hr class="my-3" />

            <div>
                <h3 class="mb-8 text-xl font-medium text-center">
                    YOUR GUESSES
                </h3>
                <GameComponent :hide-numbers="true" />
            </div>

            <div v-if="!isPracticeMode" class="grid w-full grid-cols-1 gap-8 my-5 md:grid-cols-2">
                <div class="p-2 text-center bg-gray-100 md:p-4 col">
                    <div class="text-xl font-bold sm:text-2xl">
                        <CutdownTimer />
                    </div>
                    <div class="text-xs text-gray-600">NEW NUMBER IN</div>
                </div>
                <div class="flex flex-col justify-center">
                    <div>
                        <el-button class="w-full" type="success">SHARE</el-button>
                    </div>
                    <div>
                        <el-button
                            class="w-full m-0 mt-1"
                            type="primary"
                            @click="$emit('featureOwnNumbers')"
                        >
                            FEATURE YOUR NUMBERS
                        </el-button>
                    </div>
                </div>
            </div>

            <hr class="my-5"/>

            <div v-if="isPracticeMode" class="grid grid-cols-1 gap-1 sm:grid-cols-2">
                <div>
                    <el-button type="primary" class="w-full" @click="goToPracticeMode">TRY AGAIN</el-button>
                </div>
                <div>
                    <el-button type="success" class="w-full" @click="goToRegularMode">GO TO REAL MODE</el-button>
                </div>
            </div>

            <hr class="my-5"/>

            <div class="flex items-center justify-center">
                <el-link href="https://www.guessmynumbers.com" target="_blank" type="primary">
                    www.guessmynumbers.com
                </el-link>
            </div>
        </template>
    </ModalComponent>
</template>
<script>
import ModalComponent from "../ui/ModalComponent";
import IconComponent from "../ui/IconComponent";
import GameComponent from "../GameComponent";
import CutdownTimer from "../CutdownTimer";
import { mapState, mapActions } from "pinia";
import { useGameStore, useAttemptStore } from "../../store";
export default {
    components: {
        GameComponent,
        IconComponent,
        ModalComponent,
        CutdownTimer,
    },
    props: {
        show: {
            type: Boolean,
            default: false,
        }
    },
    data() {
        return {
        }
    },
    computed: {
        ...mapState(useGameStore, ['currentGame']),
        ...mapState(useAttemptStore, ['isPracticeMode']),
        currentRoundWinPercentage() {
            const number_of_attempts = this.currentGame.number_of_attempts;
            const number_of_wons = this.currentGame.number_of_wons;
            if (!number_of_attempts) return 0;
            return _.min([_.round(number_of_wons / number_of_attempts * 100, 0), 100]);
        },
    },
    methods: {
        ...mapActions(useAttemptStore, ['goToPracticeMode', 'goToRegularMode']),
        onClose() {
            this.$emit('close')
        },
    }
}
</script>
