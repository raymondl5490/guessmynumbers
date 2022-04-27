<template>
    <div>
        <GameComponent />
    </div>
</template>
<script>

import GameComponent from "../components/GameComponent";
import {isEmpty} from 'lodash';
import {useGameStore, useAttemptStore, usePlayerStore, useGuessStore} from '../store';
import {mapActions, mapState, mapGetters} from 'pinia';

export default {
    components: {
        GameComponent,
    },
    data() {
    },
    async created() {
        if (isEmpty(this.currentPlayer)) {
            await this.createPlayer();
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
    },
    computed: {
        ...mapState(usePlayerStore, ['currentPlayer']),
        ...mapState(useAttemptStore, ['currentAttempt']),
        ...mapState(useGameStore, ['currentGame']),
    },
    methods: {
        ...mapActions(usePlayerStore, ['createPlayer', 'getPlayer']),
        ...mapActions(useGameStore, ['getCurrentGame', 'initializeBoard']),
        ...mapActions(useGuessStore, ['getGuesses']),
        ...mapActions(useAttemptStore, ['createAttempt', 'getCurrentAttempt']),
    }
}
</script>
