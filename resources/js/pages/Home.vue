<template>
    <div class="container flex flex-col mx-auto" style="height: 85vh;">
        <HeaderComponent
            @open-help="onOpenHelp"
            @open-statistics="onOpenStatistics"
            @open-settings="onOpenSettings"
        />
        <BoardComponent
            v-if="!loading"
            class="flex-grow m-4 md:m-8"
        />

        <InputNumbersComponent
            v-if="!loading"
            class="mx-auto my-2 w-fit"
        />

        <HelpModalComponent v-model="showHelpModal" />
        <StatisticsModalComponent
            v-model="showStatisticsModal"
            @featureOwnNumbers="onFeatureOwnNumbers"
        />
        <SettingsModalComponent v-model="showSettingsModal" />
        <VipModal v-model="showGameModalCreate" />
    </div>
</template>
<script>

import HeaderComponent from "../components/HeaderComponent";
import {useGameStore, useAttemptStore, usePlayerStore, useGuessStore, useSettingStore} from '../store';
import {mapActions, mapState} from 'pinia';
import HelpModalComponent from "../components/modals/HelpModalComponent";
import StatisticsModalComponent from "../components/modals/StatisticsModalComponent";
import SettingsModalComponent from "../components/modals/SettingsModalComponent";
import VipModal from "../components/modals/VipModal";
import { wait } from "../utils";
import { ATTEMPT_STATUS_CODES } from "../utils/constants";
import BoardComponent from "../components/BoardComponent.vue";
import InputNumbersComponent from "../components/InputNumbersComponent.vue";

export default {
    components: {
        SettingsModalComponent,
        StatisticsModalComponent,
        HelpModalComponent,
        HeaderComponent,
        VipModal,
        BoardComponent,
        InputNumbersComponent
    },
    data() {
        return {
            loading: true,

            showHelpModal: false,
            showStatisticsModal: false,
            showSettingsModal: false,
            showGameModalCreate: false,
        };
    },
    async mounted() {

        this.loading = true;

        if (_.isEmpty(this.currentPlayer)) {
            await this.createPlayer();
            this.showHelpModal = true;
        }

        // Refresh the player
        await this.getPlayer(this.currentPlayer.id);
        await this.getCurrentGame();
        await this.getCurrentAttempt(this.currentPlayer.id)
        if (_.isEmpty(this.currentAttempt)) {
            await this.createAttempt(this.currentPlayer.id, {
                game_id: this.currentGame.id
            });
        }
        await this.getGuesses(this.currentPlayer.id, this.currentAttempt.id);
        await this.getResultTexts();

        this.loading = false;
    },
    computed: {
        ...mapState(usePlayerStore, ['currentPlayer']),
        ...mapState(useAttemptStore, ['currentAttempt', 'attemptStatus', 'isAttemptEnded']),
        ...mapState(useGameStore, ['currentGame']),
        hasWon() {
            return _.includes(this.attemptStatus, ATTEMPT_STATUS_CODES.STATUS_ENDED_WIN);
        },
    },
    watch: {
        async isAttemptEnded() {
            if (this.isAttemptEnded) {
                await this.getPlayer(this.currentPlayer.id);
                await this.getCurrentGame();

                await wait(2800);
                if (this.hasWon) {
                    this.$confetti.start({
                        particles: [
                            {
                                type: 'rect',
                                dropRate: 20,
                                size: 7,
                            },
                            {
                                type: 'heart',
                                dropRate: 10,
                                size: 10,
                            },
                            {
                                type: 'circle',
                                dropRate: 15,
                                size: 5,
                            },
                        ],
                        windSpeedMax: 1,
                        particlesPerFrame: 10,
                        defaultSize: 5,
                        defaultType: 'rect',
                    });
                    await wait(200);
                    this.$confetti.update({
                        particles: [
                            {
                                type: 'rect',
                                dropRate: 5,
                            },
                            {
                                type: 'heart',
                                dropRate: 10,
                            },
                            {
                                type: 'circle',
                                dropRate: 15,
                            },
                        ],
                        windSpeedMax: 1,
                        particlesPerFrame: 1,
                    });
                    await wait(2500);
                    this.$confetti.stop();
                }
                this.showStatisticsModal = true;
            }
        },
    },
    methods: {
        ...mapActions(usePlayerStore, ['createPlayer', 'getPlayer']),
        ...mapActions(useGameStore, ['getCurrentGame']),
        ...mapActions(useGuessStore, ['getGuesses']),
        ...mapActions(useAttemptStore, ['createAttempt', 'getCurrentAttempt']),
        ...mapActions(useSettingStore, ['getResultTexts']),
        onOpenHelp() {
            this.showHelpModal = true;
        },
        onOpenStatistics() {
            this.showStatisticsModal = true;
        },
        onOpenSettings() {
            this.showSettingsModal = true;
        },
        onFeatureOwnNumbers() {
            this.showStatisticsModal = false;
            this.showGameModalCreate = true;
        },
    }
}
</script>
