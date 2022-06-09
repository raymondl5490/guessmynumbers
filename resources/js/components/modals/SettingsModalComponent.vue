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
                <div class="flex flex-row justify-between content-center w-full my-5">
                    <h1 class="text-2xl font-bold">Practice Mode</h1>
                    <p class="self-center">Coming Soon</p>
                </div>
                <div class="flex flex-row justify-between content-center w-full my-5">
                    <h1 class="text-2xl font-bold">
                        Feedback
                    </h1>
                    <a
                        href="mailto:josh@guessmynumbers.com"
                        class="focus:outline-none text-2xl underline text-gray-600 hover:text-gray-900 text-right"
                    >
                        Email
                    </a>
                </div>
                <div class="flex flex-row justify-between content-center w-full my-5">
                    <h1 class="text-2xl font-bold">
                        Community
                    </h1>
                    <a
                        href="https://twitter.com/guessmynumbers"
                        target="_blank"
                        class="focus:outline-none text-2xl underline text-gray-600 hover:text-gray-900 text-right"
                    >
                        Twitter
                    </a>
                </div>
                <div class="flex flex-row justify-between content-center w-full my-5">
                    <h1 class="text-xl font-medium">
                        Looking for a great book?
                    </h1>
                    <a
                        href="https://amzn.to/3GP2yt4"
                        target="_blank"
                        class="focus:outline-none underline text-blue-600 hover:text-blue-900 text-right"
                    >
                        The Adventures of Rockford T. Honeypot
                    </a>
                </div>

                <hr class="my-3"/>

                <div class="text-center mt-5">
                    <p>
                        Created by
                        <a
                            class="focus:outline-none underline text-blue-600 hover:text-blue-900"
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

export default {
    components: {IconComponent, ModalComponent},
    props: {
        show: {
            type: Boolean,
            default: false,
        }
    },
    methods: {
        onClose() {
            this.$emit('close')
        }
    }
}
</script>
