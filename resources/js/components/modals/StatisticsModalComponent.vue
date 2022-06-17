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
            <div class="w-full grid grid-cols-2 gap-8 my-5">
                <div class="col-span-1 text-center">
                    <div class="text-center text-3xl font-bold">
                        {{ gamesPlayed }}
                    </div>
                    Rounds Played
                </div>
                <div class="col-span-1 text-center">
                    <div class="text-center text-3xl font-bold">
                        {{ currentRoundWinPercentage }}
                    </div>
                    Current Round Global Win %
                </div>
            </div>

            <hr class="my-3" />

            <div>
                <h3 class="text-xl font-medium text-center mb-8">
                    YOUR GUESSES
                </h3>
                <GameComponent :hide-numbers="true" />
            </div>

            <div class="w-full grid grid-cols-2 gap-8 my-5">
                <div class="text-center">
                    <h3 class="text-lg font-light">
                        NEW NUMBER IN
                    </h3>
                    <h1 class="text-2xl font-bold">
                        20 MINUTES
                    </h1>
                </div>
                <div class="flex flex-col justify-center">
                    <button
                        class="bg-green-600 hover:bg-green-900 rounded-md px-5 py-3 w-full border-0 text-md text-white"
                    >
                       SHARE
                    </button>
                </div>
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
            gamesPlayed: 3,
            currentRoundWinPercentage: '42%',
        }
    },
    methods: {
        onClose() {
            this.$emit('close')
        }
    }
}
</script>
