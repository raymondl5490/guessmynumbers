<template>
    <TransitionRoot as="template" :show="show">
        <Dialog as="div" class="relative z-10" @close="onClose">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                             leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="onClose"/>
            </TransitionChild>

            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!-- This element is to trick the browser into centering the modal contents. -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <TransitionChild as="template" enter="ease-out duration-300"
                                     enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                                     leave-from="opacity-100 translate-y-0 sm:scale-100"
                                     leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="bg-white px-5 pt-0 pb-4 sm:p-6 sm:pb-4">
                                <div class="mt-0 sm:mt-0 sm:ml-4">
                                    <div class="p-5 text-right">
                                        <IconComponent
                                            class="text-gray-600 hover:text-gray-900"
                                            icon="times"
                                            @click="onClose"
                                        />
                                    </div>
                                    <DialogTitle as="h1" class="text-2xl leading-6 font-bold text-gray-900">
                                        <slot name="title"></slot>
                                    </DialogTitle>
                                    <div class="mt-2">
                                        <slot name="content"></slot>
                                    </div>
                                </div>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from '@headlessui/vue'
import {ExclamationIcon} from '@heroicons/vue/outline'
import IconComponent from "./IconComponent";

export default {
    components: {
        IconComponent,
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        ExclamationIcon,
    },
    props: {
        show: {
            type: Boolean,
            default: false,
        },
        showIcon: {
            type: Boolean,
            default: false
        },
        iconBackground: {
            type: String,
            default: 'bg-gray-300',
        }
    },
    methods: {
        onClose() {
            this.$emit('close');
        }
    }
}
</script>
