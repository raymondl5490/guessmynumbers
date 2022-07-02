<template>
    <ModalComponent v-model="value">
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
                    {{ resultText }}
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
                        <el-button class="w-full" :tabindex="-1" type="success">SHARE</el-button>
                    </div>
                    <div>
                        <el-button
                            class="w-full m-0 mt-1"
                            :disabled="isPracticeMode || !won"
                            :tabindex="-1"
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
                    <el-button type="primary" class="w-full" :tabindex="-1" @click="value = false; goToPracticeMode()">TRY AGAIN</el-button>
                </div>
                <div>
                    <el-button type="success" class="w-full" :tabindex="-1" @click="value = false; goToRegularMode()">GO TO REAL MODE</el-button>
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
import { useGameStore, useAttemptStore, useSettingStore } from "../../store";
import { ATTEMPT_STATUS_CODES } from "../../utils/constants";

export default {
    components: {
        GameComponent,
        IconComponent,
        ModalComponent,
        CutdownTimer,
    },
    props: ['modelValue'],
    emits: ['update:modelValue', 'featureOwnNumbers'],
    data() {
        return {
        }
    },
    computed: {
        ...mapState(useGameStore, ['currentGame']),
        ...mapState(useAttemptStore, ['isPracticeMode', 'won', 'attemptStatus']),
        ...mapState(useSettingStore, ['settingValueByKey']),
        value: {
            get() {
                return this.modelValue;
            },
            set(value) {
                this.$emit('update:modelValue', value);
            },
        },
        currentRoundWinPercentage() {
            const number_of_attempts = this.currentGame.number_of_attempts;
            const number_of_wons = this.currentGame.number_of_wons;
            if (!number_of_attempts) return 0;
            return _.min([_.round(number_of_wons / number_of_attempts * 100, 0), 100]);
        },
        resultText() {
            let texts = [];
            if (_.includes(this.attemptStatus, ATTEMPT_STATUS_CODES.STATUS_ENDED_WIN_1)) {
                texts = this.settingValueByKey('result_text_win_try_1');
            } else if (_.includes(this.attemptStatus, ATTEMPT_STATUS_CODES.STATUS_ENDED_WIN_2)) {
                texts = this.settingValueByKey('result_text_win_try_2')
            } else if (_.includes(this.attemptStatus, ATTEMPT_STATUS_CODES.STATUS_ENDED_WIN_3)) {
                texts = this.settingValueByKey('result_text_win_try_3')
            } else if (_.includes(this.attemptStatus, ATTEMPT_STATUS_CODES.STATUS_ENDED_LOSE_0)) {
                texts = this.settingValueByKey('result_text_lose_correct_0')
            } else if (_.includes(this.attemptStatus, ATTEMPT_STATUS_CODES.STATUS_ENDED_LOSE_1)) {
                texts = this.settingValueByKey('result_text_lose_correct_1')
            } else if (_.includes(this.attemptStatus, ATTEMPT_STATUS_CODES.STATUS_ENDED_LOSE_2)) {
                texts = this.settingValueByKey('result_text_lose_correct_2')
            }
            return _.isArray(texts) ? texts[_.random(texts.length - 1)] : "";
        },
    },
    methods: {
        ...mapActions(useAttemptStore, ['goToPracticeMode', 'goToRegularMode']),
    },
}
</script>
