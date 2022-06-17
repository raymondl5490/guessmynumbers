<template>
    <div class="container mx-auto flex justify-between pt-2">
        <div class="w-40">
            <IconComponent
                class="text-gray-500 hover:text-gray-700"
                icon="circle-question"
                icon-style="regular"
                @click="onHelpOpen"
            />
        </div>
        <div class="w-screen sm:w-full text-center">
            <h1 class="mb-4 text-gray-900 text-3xl sm:text-xl  md:text-2xl font-bold">GUESS <span class="text-green-600">MY</span> NUMBERS</h1>
            <p class="text-gray-500 text-sm">
                SUBMMITED BY 
                <span class="text-blue-900 font-bold">
                    {{currentGame.author_name}}, {{currentGame.author_location}}
                </span>
                AT
                <span class="text-blue-900 font-bold">
                    {{(new Date(currentGame.created_at).toDateString())}}
                </span>
            </p>
        </div>
        <div class="text-right w-40">
            <IconComponent
                class="text-gray-500 hover:text-gray-700"
                icon="chart-column"
                @click="onStatisticsOpen"
            />
            <IconComponent
                class="text-gray-500 hover:text-gray-700"
                icon="gear"
                @click="onSettingsOpen"
            />
        </div>
    </div>
</template>
<script>
import {IconComponent} from "./ui";
import {mapState} from 'pinia';
import {useGameStore}from '../store'

export default {
    components: {IconComponent},
    computed: {
        ...mapState(useGameStore, ['currentGame']),
    },
    methods: {
        onHelpOpen() {
            this.$emit('open-help');
        },
        onStatisticsOpen() {
            this.$emit('open-statistics');
        },
        onSettingsOpen() {
            this.$emit('open-settings');
        }
    }
}
</script>
