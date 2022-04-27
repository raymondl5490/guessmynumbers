<template>
    <div>
        <GameComponent />
    </div>
</template>
<script>

import GameComponent from "../components/GameComponent";
import {isEmpty} from 'lodash';
import {useGameStore, useAttemptStore, usePlayerStore} from '../store';
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

        // Refresh the player
        await this.getPlayer(this.currentPlayer.id);
    },
    computed: {
        ...mapState(usePlayerStore, ['currentPlayer', 'currentAttempt']),
        ...mapState(useGameStore, ['currentGame']),
    },
    methods: {
        ...mapActions(usePlayerStore, ['createPlayer', 'getPlayer']),
        ...mapActions(useGameStore, ['getCurrentGame']),
        ...mapActions(useAttemptStore, ['createAttempt']),
    }
}
</script>
