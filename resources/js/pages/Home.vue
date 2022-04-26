<template>
    <div>
        This is my game.

        <h3>Here is data served from vue3</h3>
        <p>{{ currentGame }}</p>
        <p>Current Attempt</p>
        <p>{{ currentAttempt }}</p>
    </div>
</template>
<script>

import { isEmpty } from 'lodash';
import { mapState, mapActions } from 'vuex';

export default {
    data() {},
    async created() {
        if (isEmpty(this.currentGame)) {
            await this.getCurrentGame();
        }

        if (isEmpty(this.currentAttempt)) {
            await this.createAttempt(this.currentGame.id)
        }
    },
    computed: {
        ...mapState('games', ['currentGame']),
        ...mapState('attempts', ['currentAttempt'])
    },
    methods: {
        ...mapActions('games', ['getCurrentGame']),
        ...mapActions('attempts', ['createAttempt'])
    }
}
</script>
