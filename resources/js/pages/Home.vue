<template>
    <div>
        <HeaderComponent
            class="mb-6 sm:mb-10 md:mb-20 lg:mb-40"
            @open-help="onOpenHelp"
            @open-statistics="onOpenStatistics"
            @open-settings="onOpenSettings"
        />
        <GameComponent v-if="!loading" />

        <HelpModalComponent
            :show="showHelpModal"
            @close="onCloseHelp"
        />
        <StatisticsModalComponent
            :show="showStatisticsModal"
            @close="onCloseStatistics"
        />
        <SettingsModalComponent
            :show="showSettingsModal"
            @close="onCloseSettings"
        />
    </div>
</template>
<script>

import GameComponent from "../components/GameComponent";
import HeaderComponent from "../components/HeaderComponent";
import {isEmpty} from 'lodash';
import {useGameStore, useAttemptStore, usePlayerStore, useGuessStore} from '../store';
import {mapActions, mapState, mapGetters} from 'pinia';
import ModalComponent from "../components/ui/ModalComponent";
import HelpModalComponent from "../components/modals/HelpModalComponent";
import StatisticsModalComponent from "../components/modals/StatisticsModalComponent";
import SettingsModalComponent from "../components/modals/SettingsModalComponent";

export default {
    components: {
        SettingsModalComponent,
        StatisticsModalComponent,
        HelpModalComponent,
        HeaderComponent,
        GameComponent,
    },
    data() {
        return {
            loading: false,

            showHelpModal: false,
            showStatisticsModal: false,
            showSettingsModal: false,
        }
    },
    async created() {

        this.loading = true;

        if (isEmpty(this.currentPlayer)) {
            await this.createPlayer();
            this.showHelpModal = true;
        }
        if (isEmpty(this.currentGame)) {
            await this.getCurrentGame();
        }

        if (isEmpty(this.currentAttempt)) {
            await this.createAttempt(this.currentPlayer.id, {
                game_id: this.currentGame.id
            });
        }

        if (isEmpty(this.guesses)) {
            await this.getGuesses(this.currentPlayer.id, this.currentAttempt.id);
        }

        // Refresh the player
        await this.getPlayer(this.currentPlayer.id);

        await this.initializeBoard();

        this.loading = false;
    },
    computed: {
        ...mapState(usePlayerStore, ['currentPlayer']),
        ...mapState(useAttemptStore, ['currentAttempt']),
        ...mapState(useGameStore, ['currentGame']),
        ...mapState(useGuessStore, ['guesses']),
    },
    watch: {
        guesses() {
            if (this.guesses.length >= 3) {
                this.showStatisticsModal = true;
            }
        },
    },
    methods: {
        ...mapActions(usePlayerStore, ['createPlayer', 'getPlayer']),
        ...mapActions(useGameStore, ['getCurrentGame', 'initializeBoard']),
        ...mapActions(useGuessStore, ['getGuesses']),
        ...mapActions(useAttemptStore, ['createAttempt', 'getCurrentAttempt']),
        onOpenHelp() {
            this.showHelpModal = true;
        },
        onCloseHelp() {
            this.showHelpModal = false;
        },
        onOpenStatistics() {
            this.showStatisticsModal = true;
        },
        onCloseStatistics() {
            this.showStatisticsModal = false;
        },
        onOpenSettings() {
            this.showSettingsModal = true;
        },
        onCloseSettings() {
            this.showSettingsModal = false;
        }
    }
}
</script>
