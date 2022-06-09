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
            <h1 class="text-gray-900 text-2xl sm:text-xl  md:text-2xl font-bold">GUESS <span class="text-green-600">MY</span> NUMBERS</h1>
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
export default {
    components: {IconComponent},
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
