<template>
    <modal-component v-model="value">
        <template #title>
            <h1 class="p-4 text-2xl font-extrabold text-center text-green-500 bg-stone-200">
                VIP SECTION
            </h1>
        </template>
        <template #content>
            <div class="flex flex-col">
                <div class="flex flex-row">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Number One</label>
                        <div class="mt-1">
                            <input type="number" v-model="form.number_one" class="input"
                                @input="v$.form.number_one.$touch"/>
                            <form-errors-component name="number_one" :validation="v$.form"/>
                        </div>
                    </div>
                    <div class="px-5">
                        <label class="block text-sm font-medium text-gray-700">Number Two</label>
                        <div class="mt-1">
                            <input type="number" v-model="form.number_two" class="input"
                                @input="v$.form.number_two.$touch"/>
                            <form-errors-component name="number_two" :validation="v$.form"/>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Number Three</label>
                        <div class="mt-1">
                            <input type="number" v-model="form.number_three" class="input"
                                @input="v$.form.number_three.$touch"/>
                            <form-errors-component name="number_three" :validation="v$.form"/>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <div class="mt-1">
                        <input v-model="form.author_name" class="input"
                            placeholder="Jone"
                            @input="v$.form.author_name.$touch"/>
                        <form-errors-component name="author_name" :validation="v$.form"/>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <div class="mt-1">
                        <input type="email" v-model="form.author_email" class="input"
                            placeholder="jone0322@gmail.com"
                            @input="v$.form.author_email.$touch"/>
                        <form-errors-component name="author_email" :validation="v$.form"/>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700">Location</label>
                    <div class="mt-1">
                        <input type="email" v-model="form.author_location" class="input"
                            placeholder="Los Angeles"
                            @input="v$.form.author_location.$touch"/>
                        <form-errors-component name="author_location" :validation="v$.form"/>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700">Link</label>
                    <div class="mt-1">
                        <input type="url" v-model="form.link" class="input"
                            placeholder="https://guessmynumbers.com"
                            @input="v$.form.link.$touch"/>
                        <form-errors-component name="link" :validation="v$.form"/>
                    </div>
                </div>

                <el-button type="success" :disabled="hasSubmittedVipGame" class="w-full mt-4" :tabindex="-1" @click="onSubmitClicked">
                    {{ hasSubmittedVipGame ? 'You Already Submitted' : 'Submit Your Own Numbers!' }}
                </el-button>

                <el-collapse>
                    <el-collapse-item>
                        <template #title>
                            <div class="w-full text-base font-bold text-center text-blue-500 sm:text-lg md:text-xl">
                                How it works
                            </div>
                        </template>
                        <div class="text-base break-normal whitespace-pre-wrap sm:text-lg md:text-xl">
                            Congratulations!

                            You guessed today's number! Hizzah!

                            Please fill out the form in the super-secret VIP SECTION with YOUR numbers for the world to guess.

                            You can be specific or vague with your location, so don't worry.

                            If you include your email, you'll be the first to know some of our fun updates in the future as part of our VIP WINNERS CLUB.

                            Due to the high volume of submissions, we cannot guarantee your number will be picked.

                            However, the more you play every day, the higher the chance of being featured.

                            If you have any questions, please email us or tweet us.

                            Thanks again! And, as Rockford T. Honeypot would say, "CHEERS TO BOTH EARS!”
                        </div>
                    </el-collapse-item>
                </el-collapse>

                <div class="flex items-center justify-center">
                    <el-link href="https://www.guessmynumbers.com" target="_blank" type="primary">
                        www.guessmynumbers.com
                    </el-link>
                </div>

            </div>
        </template>
    </modal-component>
</template>
<script>
import ModalComponent from "../ui/ModalComponent";
import useVuelidate from "@vuelidate/core";
import {required, numeric, maxValue, minValue, email, url, maxLength, minLength} from "@vuelidate/validators";
import FormErrorsComponent from "../forms/FormErrorsComponent";

import { useAttemptStore } from "../../store";
import { mapActions, mapState } from "pinia";
import { gameApi } from '../../api';

export default {
    setup() {
        return {v$: useVuelidate()}
    },
    name: 'VipModal',
    components: {
        ModalComponent,
        FormErrorsComponent,
    },
    props: {
        modelValue: Boolean,
    },
    data() {
        return {
            form: {
                number_one: 0,
                number_two: 0,
                number_three: 0,
                author_name: '',
                author_email: '',
                author_location: '',
                link: '',
            },
        };
    },
    computed: {
        ...mapState(useAttemptStore, ['hasSubmittedVipGame']),
        value: {
            get() {
                return this.modelValue;
            },
            set(value) {
                this.$emit('update:modelValue', value);
            },
        },
    },
    validations() {
        return {
            form: {
                number_one: {
                    required,
                    numeric,
                    minValue: minValue(0),
                    maxValue: maxValue(9),
                },
                number_two: {
                    required,
                    numeric,
                    minValue: minValue(0),
                    maxValue: maxValue(9),
                },
                number_three: {
                    required,
                    numeric,
                    minValue: minValue(0),
                    maxValue: maxValue(9),
                },
                author_name: {
                    required,
                    minLength: minLength(2),
                    maxLength: maxLength(60),
                },
                author_email: {
                    email,
                },
                author_location: {
                    minLength: minLength(2),
                    maxLength: maxLength(255),
                },
                link: {
                    // url,
                },
            },
        };
    },
    methods: {
        ...mapActions(useAttemptStore, ['getHasSubmittedVipGame']),
        async onSubmitClicked() {
            const isFormCorrect = await this.v$.$validate()
            // you can show some extra alert to the user or just leave each field to show its `$errors`.
            if (!isFormCorrect) return

            await gameApi.store(this.form);
            await this.getHasSubmittedVipGame();
            this.value = false;
        },
    },
}
</script>
