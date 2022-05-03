<template>
    <div class="container mx-auto flex justify-between pt-2">
        <div class="w-40">
            <IconComponent
                icon="circle-question"
                icon-style="regular"
            />
        </div>
        <div class="w-screen sm:w-full text-center">
            <h1 class="text-gray-900 text-2xl sm:text-xl  md:text-2xl font-bold">GUESS <span class="text-green-600">MY</span> NUMBERS</h1>
        </div>
        <div class="text-right w-40">
            <IconComponent icon="chart-column" />
            <IconComponent icon="gear" />
        </div>
    </div>
</template>
<script>
import {IconComponent} from "./ui";
export default {
    components: {IconComponent}
}
</script>
