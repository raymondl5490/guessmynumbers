<template>
    <ModalComponent v-model="value">
        <template #title>
            <h1 class="p-4 text-2xl font-extrabold text-center bg-stone-200">
                Settings
            </h1>
        </template>
        <template #content>
            <div class="flex flex-col m-4">
                <div class="flex items-center justify-between my-3">
                    <p class="text-lg font-semibold">Practice Mode</p>
                    <el-switch :value="isPracticeMode" @input="isPracticeModeChanged"/>
                </div>
                <div class="flex items-center justify-between my-3">
                    <p class="text-lg font-semibold">Feedback</p>
                    <a href="mailto:josh@guessmynumbers.com">
                        <IconComponent
                            class="text-gray-600 hover:text-gray-900"
                            icon="envelope"
                        />
                    </a>
                </div>
                <div class="flex items-center justify-between my-3">
                    <p class="text-lg font-semibold">Community</p>
                    <a
                        href="https://twitter.com/guessmynumbers"
                        target="_blank"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="-2 -4 24 24" width="32" fill="currentColor"><path d="M20 1.907a8.292 8.292 0 0 1-2.356.637A4.07 4.07 0 0 0 19.448.31a8.349 8.349 0 0 1-2.607.98A4.12 4.12 0 0 0 13.846.015c-2.266 0-4.103 1.81-4.103 4.04 0 .316.036.625.106.92A11.708 11.708 0 0 1 1.393.754a3.964 3.964 0 0 0-.554 2.03c0 1.403.724 2.64 1.824 3.363A4.151 4.151 0 0 1 .805 5.64v.05c0 1.958 1.415 3.591 3.29 3.963a4.216 4.216 0 0 1-1.08.141c-.265 0-.522-.025-.773-.075a4.098 4.098 0 0 0 3.832 2.807 8.312 8.312 0 0 1-5.095 1.727c-.332 0-.658-.02-.979-.056a11.727 11.727 0 0 0 6.289 1.818c7.547 0 11.673-6.157 11.673-11.496l-.014-.523A8.126 8.126 0 0 0 20 1.907z"></path></svg>
                    </a>
                </div>
                <div class="p-2 text-4xl font-bold text-center bg-gray-100 md:p-4">
                    <el-link href="https://amzn.to/3GP2yt4" target="_blank" type="success">
                        The Adventures of Rockford T. Honeypot
                    </el-link>
                    <div class="text-xs text-gray-600">Looking for a great book?</div>
                </div>

                <hr />

                <div class="mt-5 text-sm font-bold text-center">
                    Created by
                    <el-link href="https://twitter.com/joshgottsegen" target="_blank" type="primary">
                        @JoshGottsegen
                    </el-link>
                </div>
                <div class="flex items-center justify-center">
                    <el-link href="https://www.guessmynumbers.com" target="_blank" type="primary">
                        www.guessmynumbers.com
                    </el-link>
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
    props: ['modelValue'],
    emits: ['update:modelValue'],
    computed: {
        ...mapState(useAttemptStore, ['isPracticeMode']),
        value: {
            get() {
                return this.modelValue;
            },
            set(value) {
                this.$emit('update:modelValue', value);
            },
        },
    },
    methods: {
        ...mapActions(useAttemptStore, ['goToPracticeMode', 'goToRegularMode']),
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
