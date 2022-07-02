<template>
    <div>
        <HeaderComponent
            class="mb-6 sm:mb-10 md:mb-20 lg:mb-40"
            @open-help="onOpenHelp"
            @open-statistics="onOpenStatistics"
            @open-settings="onOpenSettings"
        />
        <GameComponent v-if="!loading" />

        <HelpModalComponent v-model="showHelpModal" />
        <StatisticsModalComponent
            v-model="showStatisticsModal"
            @featureOwnNumbers="onFeatureOwnNumbers"
        />
        <SettingsModalComponent v-model="showSettingsModal" />
        <GameModalCreate v-model="showGameModalCreate" />
    </div>
</template>
<script>

import GameComponent from "../components/GameComponent";
import HeaderComponent from "../components/HeaderComponent";
import {isEmpty} from 'lodash';
import {useGameStore, useAttemptStore, usePlayerStore, useGuessStore, useSettingStore} from '../store';
import {mapActions, mapState} from 'pinia';
import HelpModalComponent from "../components/modals/HelpModalComponent";
import StatisticsModalComponent from "../components/modals/StatisticsModalComponent";
import SettingsModalComponent from "../components/modals/SettingsModalComponent";
import GameModalCreate from "../components/modals/GameModalCreate";

export default {
    components: {
        SettingsModalComponent,
        StatisticsModalComponent,
        HelpModalComponent,
        HeaderComponent,
        GameComponent,
        GameModalCreate,
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

        if (isEmpty(this.currentPlayer)) {
            await this.createPlayer();
            this.showHelpModal = true;
        }

        // Refresh the player
        await this.getPlayer(this.currentPlayer.id);
        await this.getCurrentGame();
        await this.getCurrentAttempt(this.currentPlayer.id)
        if (isEmpty(this.currentAttempt)) {
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
        ...mapState(useAttemptStore, ['currentAttempt', 'isAttemptEnded']),
        ...mapState(useGameStore, ['currentGame']),
    },
    watch: {
        isAttemptEnded() {
            if (this.isAttemptEnded) {
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
