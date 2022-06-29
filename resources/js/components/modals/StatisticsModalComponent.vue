<template>
    <ModalComponent
        :show="show"
        @close="onClose"
    >
        <template #title>
            <div class="text-center">
                Statistics
            </div>
        </template>
        <template #content>
            <div v-if="!isPracticeMode" class="grid w-full grid-cols-2 gap-8 my-5">
                <div class="col-span-1 text-center">
                    <div class="text-3xl font-bold text-center">
                        {{ currentGame.number_of_attempts }}
                    </div>
                    Rounds Played
                </div>
                <div class="col-span-1 text-center">
                    <div class="text-3xl font-bold text-center">
                        {{ currentRoundWinPercentage }}
                    </div>
                    Current Round Global Win %
                </div>
            </div>

            <hr class="my-3" />

            <div>
                <h3 class="mb-8 text-xl font-medium text-center">
                    YOUR GUESSES
                </h3>
                <GameComponent :hide-numbers="true" />
            </div>

            <div v-if="!isPracticeMode" class="grid w-full grid-cols-2 gap-8 my-5">
                <div class="text-center">
                    <h3 class="text-lg font-light">
                        NEW NUMBER IN
                    </h3>
                    <h1 class="text-2xl font-bold">
                        20 MINUTES
                    </h1>
                </div>
                <div class="flex flex-col justify-center">
                    <el-button type="success">SHARE</el-button>
                </div>
            </div>

            <hr class="my-5"/>

            <div v-if="isPracticeMode" class="flex items-center justify-center">
                <el-button type="primary" @click="goToPracticeMode">TRY AGAIN</el-button>
                <el-button type="success" @click="goToRegularMode">GO TO REAL MODE</el-button>
            </div>

            <hr class="my-5"/>

            <div class="text-center">
                <p>www.guessmynumbers.com</p>
            </div>
        </template>
    </ModalComponent>
</template>
<script>
import ModalComponent from "../ui/ModalComponent";
import IconComponent from "../ui/IconComponent";
import GameComponent from "../GameComponent";
import { mapState, mapActions } from "pinia";
import { useGameStore, useAttemptStore } from "../../store";
export default {
    components: {GameComponent, IconComponent, ModalComponent},
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
