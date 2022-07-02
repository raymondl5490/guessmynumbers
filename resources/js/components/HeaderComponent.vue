<template>
    <div class="flex flex-col items-center justify-center">
        <div class="flex items-center justify-between w-full pt-2">
            <div>
                <IconComponent
                    class="text-gray-500 hover:text-gray-700"
                    icon="circle-question"
                    icon-style="regular"
                    @click="onHelpOpen"
                />
            </div>
            <div>
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
        <div class="w-screen text-center sm:w-full">
            <h1 class="mb-4 text-3xl font-bold text-gray-900 sm:text-5xl md:text-6xl">GUESS <span class="text-green-600">MY</span> NUMBERS</h1>
            <p v-if="isPracticeMode" class="text-lg text-center text-red-500 sm:text-xl md:text-2xl">
                YOU ARE IN PRACTICE MODE
                <div class="grid grid-cols-1 gap-1 sm:grid-cols-2">
                    <div class="flex justify-center sm:justify-end">
                        <el-button type="primary" size="small" class="w-36" @click="goToPracticeMode">TRY AGAIN</el-button>
                    </div>
                    <div class="flex justify-center sm:justify-start">
                        <el-button type="success" size="small" class="w-36" @click="goToRegularMode">GO TO REAL MODE</el-button>
                    </div>
                </div>
            </p>
            <p v-else class="text-lg text-center text-gray-400 sm:text-xl md:text-2xl">
                SUBMMITED BY 
                <span class="text-2xl font-bold text-green-700 sm:text-3xl md:text-4xl">
                    <a :href="currentGame.link" class="underline">
                        {{currentGame.author_name}}
                    </a>
                    , {{currentGame.author_location}}
                    <img class="inline w-6" src="https://img.icons8.com/color/48/FAB005/approval--v3.png"/>
                </span>
                <p>
                    AT
                    <span class="font-bold text-blue-900">
                        {{(new Date(currentGame.created_at).toDateString())}}
                    </span>
                </p>
            </p>
        </div>
    </div>
</template>
<script>
import {IconComponent} from "./ui";
import {mapState, mapActions} from 'pinia';
import {useGameStore, useAttemptStore}from '../store'

export default {
    components: {IconComponent},
    computed: {
        ...mapState(useGameStore, ['currentGame']),
        ...mapState(useAttemptStore, ['isPracticeMode']),
    },
    methods: {
        ...mapActions(useAttemptStore, ['goToPracticeMode', 'goToRegularMode']),
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
