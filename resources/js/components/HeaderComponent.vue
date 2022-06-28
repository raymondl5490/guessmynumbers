<template>
    <div class="container flex justify-between pt-2 mx-auto">
        <div class="w-40">
            <IconComponent
                class="text-gray-500 hover:text-gray-700"
                icon="circle-question"
                icon-style="regular"
                @click="onHelpOpen"
            />
        </div>
        <div class="w-screen text-center sm:w-full">
            <h1 class="mb-4 text-3xl font-bold text-gray-900 sm:text-xl md:text-2xl">GUESS <span class="text-green-600">MY</span> NUMBERS</h1>
            <p class="text-sm text-center text-gray-500">
                SUBMMITED BY 
                <span class="font-bold text-blue-900">
                    <a :href="currentGame.link" class="underline">
                        {{currentGame.author_name}}
                    </a>
                    , {{currentGame.author_location}}
                </span>
                AT
                <span class="font-bold text-blue-900">
                    {{(new Date(currentGame.created_at).toDateString())}}
                </span>
            </p>
        </div>
        <div class="w-40 text-right">
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
