<template>
    <ModalComponent
        :show="show"
        @close="onClose"
    >
        <template #title>
            <div class="text-center">
                Settings
            </div>
        </template>
        <template #content>
            <div class="flex flex-col my-8">
                <div class="flex flex-row content-center justify-between w-full my-5">
                    <h1 class="text-2xl font-bold">Practice Mode</h1>
                    <el-switch :value="isPracticeMode" @input="isPracticeModeChanged"/>
                </div>
                <div class="flex flex-row content-center justify-between w-full my-5">
                    <h1 class="text-2xl font-bold">
                        Feedback
                    </h1>
                    <a
                        href="mailto:josh@guessmynumbers.com"
                        class="text-2xl text-right text-gray-600 underline focus:outline-none hover:text-gray-900"
                    >
                        Email
                    </a>
                </div>
                <div class="flex flex-row content-center justify-between w-full my-5">
                    <h1 class="text-2xl font-bold">
                        Community
                    </h1>
                    <a
                        href="https://twitter.com/guessmynumbers"
                        target="_blank"
                        class="text-2xl text-right text-gray-600 underline focus:outline-none hover:text-gray-900"
                    >
                        Twitter
                    </a>
                </div>
                <div class="flex flex-row content-center justify-between w-full my-5">
                    <h1 class="text-xl font-medium">
                        Looking for a great book?
                    </h1>
                    <a
                        href="https://amzn.to/3GP2yt4"
                        target="_blank"
                        class="text-right text-blue-600 underline focus:outline-none hover:text-blue-900"
                    >
                        The Adventures of Rockford T. Honeypot
                    </a>
                </div>

                <hr class="my-3"/>

                <div class="mt-5 text-center">
                    <p>
                        Created by
                        <a
                            class="text-blue-600 underline focus:outline-none hover:text-blue-900"
                            target="_blank"
                            href="https://twitter.com/joshgottsegen"
                        >@JoshGottsegen</a>
                    </p>
                    <p>www.guessmynumbers.com</p>
                </div>
            </div>
        </template>
    </ModalComponent>
</template>
<script>
import ModalComponent from "../ui/ModalComponent";
import IconComponent from "../ui/IconComponent";
import { mapState, mapActions } from "pinia";
import { useAttemptStore } from "../../store";

export default {
    components: {IconComponent, ModalComponent},
    props: {
        show: {
            type: Boolean,
            default: false,
        },
    },
    computed: {
        ...mapState(useAttemptStore, ['isPracticeMode']),
    },
    methods: {
        ...mapActions(useAttemptStore, ['goToPracticeMode', 'goToRegularMode']),
        onClose() {
            this.$emit('close')
        },
        isPracticeModeChanged(value) {
            if (value) {
                this.goToPracticeMode();
            } else {
                this.goToRegularMode();
            }
        },
    },
}
</script>
