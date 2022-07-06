<template>
    <ModalComponent v-model="value">
        <template #title>
            <h1 class="p-4 text-2xl font-extrabold text-center bg-stone-200">
                {{ resultText || 'Statistics' }}
            </h1>
        </template>
        <template #content>
            <div v-if="!isPracticeMode" class="flex w-full my-5 space-x-2 sm:space-x-4 md:space-x-8">
                <div v-if="currentPlayer.number_of_wons" class="w-full p-2 text-center bg-gray-100 md:p-4 col">
                    <div class="text-3xl font-bold">
                        {{ currentPlayer.number_of_wons }}
                    </div>
                    <div class="text-xs text-gray-600">YOU WON</div>
                </div>
                <div class="w-full p-2 text-center bg-gray-100 md:p-4 col">
                    <div class="text-3xl font-bold">
                        {{ currentPlayer.number_of_attempts }}
                    </div>
                    <div class="text-xs text-gray-600">YOU PLAYED</div>
                </div>
                <div class="w-full p-2 text-center bg-gray-100 md:p-4 col">
                    <div class="text-3xl font-bold">
                        {{ currentRoundWinPercentage }}
                    </div>
                    <div class="text-xs text-gray-600">% OF WINS THIS ROUND</div>
                </div>
            </div>

            <hr class="my-3" />

            <GameComponent :hide-numbers="true" />

            <div
                v-if="!isPracticeMode"
                class="grid w-full grid-cols-1 gap-8 my-5"
                :class="isGameFinishedOnRegularMode ? 'md:grid-cols-2' : ''"
            >
                <div class="p-2 text-center bg-gray-100 md:p-4 col">
                    <div class="text-xl font-bold sm:text-2xl">
                        <CutdownTimer />
                    </div>
                    <div class="text-xs text-gray-600">NEW NUMBER IN</div>
                </div>
                <div 
                    class="flex flex-col justify-center"
                >
                    <div v-if="isGameFinishedOnRegularMode">
                        <el-button
                            class="w-full"
                            :tabindex="-1"
                            type="success"
                            @click="onShare"
                        >
                            SHARE
                        </el-button>
                    </div>
                    <div v-if="wonOnRegularMode">
                        <el-button
                            class="w-full m-0 mt-1"
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
import { usePlayerStore, useGameStore, useAttemptStore, useSettingStore, useGuessStore } from "../../store";
import { ATTEMPT_STATUS_CODES } from "../../utils/constants";
import useClipboard from 'vue-clipboard3';
import { ElMessage } from "element-plus";

export default {
    setup() {
        const { toClipboard } = useClipboard({appendToBody: true})

        const shareText = () => {
            // * Sample share text
            // I guessed this 3-digit number in 2 tries. 

            // ⬛⬛🟨
            // 🟩🟨⬛
            // 🟩🟩🟩

            const guessStore = useGuessStore();
            const attempStore = useAttemptStore();

            let shareText = `I guessed this 3-digit number in ${guessStore.guesses.length} tries. \n\n`;

            const correctNumbers = attempStore.correctNumbers;

            for (let rowIndex = 0; rowIndex < guessStore.guesses.length; rowIndex++) {
                const row = guessStore.board[rowIndex];
                for (let colIndex = 0; colIndex < row.length; colIndex++) {
                    const guessedNumber = row[colIndex] ?? null;
                    const correctNumber = correctNumbers[colIndex];

                    if (guessedNumber === correctNumber) {
                        // return SQUARE_STATUS_CODES.SUBMITTED_CORRECT_RIGHT_SPOT;
                        shareText += '🟩';
                        continue;
                    }
                    if (_.includes(correctNumbers, guessedNumber)) {
                        // return SQUARE_STATUS_CODES.SUBMITTED_CORRECT_WRONG_SPOT;
                        shareText += '🟨';
                        continue;
                    }
                    // return SQUARE_STATUS_CODES.SUBMITTED_INCORRECT;
                    shareText += '⬛';
                    continue;
                }
                shareText += '\n';
            }
            shareText += '\n';

            return shareText;
        };


        const onShare = async () => {
            try {
                await toClipboard(shareText())
                console.log('Copied to clipboard')
                ElMessage({message: 'Copied to clipboard!', type: 'success'});
            } catch (e) {
                console.error(e)
            }
        }

        return { onShare }
    },
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
        ...mapState(usePlayerStore, ['currentPlayer']),
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
        wonOnRegularMode() {
            return _.includes(this.attemptStatus, ATTEMPT_STATUS_CODES.MODE_REGULAR)
                && _.includes(this.attemptStatus, ATTEMPT_STATUS_CODES.STATUS_ENDED_WIN);
        },
        isGameFinishedOnRegularMode() {
            return _.includes(this.attemptStatus, ATTEMPT_STATUS_CODES.MODE_REGULAR)
                && _.includes(this.attemptStatus, ATTEMPT_STATUS_CODES.STATUS_ENDED);
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
