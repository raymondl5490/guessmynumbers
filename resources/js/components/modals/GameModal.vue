<template>
    <modal-component v-model="value">
        <template #title>
            {{ dialogType === 'create' ? 'Create Game' : 'Edit Game'}}
        </template>
        <template #content>
            <div class="flex flex-col">
                <div v-if="!isEditingCurrentGame" class="flex flex-row">
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
                            @input="v$.form.author_name.$touch"/>
                        <form-errors-component name="author_name" :validation="v$.form"/>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700">Email (*optional)</label>
                    <div class="mt-1">
                        <input type="email" v-model="form.author_email" class="input"
                            @input="v$.form.author_email.$touch"/>
                        <form-errors-component name="author_email" :validation="v$.form"/>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700">Location</label>
                    <div class="mt-1">
                        <input type="email" v-model="form.author_location" class="input"
                            @input="v$.form.author_location.$touch"/>
                        <form-errors-component name="author_location" :validation="v$.form"/>
                    </div>
                </div>
                <div class="mt-3">
                    <label class="block text-sm font-medium text-gray-700">Link (*optional)</label>
                    <div class="mt-1">
                        <input type="url" v-model="form.link" class="input"
                            @input="v$.form.link.$touch"/>
                        <form-errors-component name="link" :validation="v$.form"/>
                    </div>
                </div>

                <div class="my-5 text-center button button-primary" @click="onSubmitClicked">{{dialogType === 'create' ? 'Create' : 'Edit'}}</div>
            </div>
        </template>
    </modal-component>
</template>
<script>
import ModalComponent from "../ui/ModalComponent";
import useVuelidate from "@vuelidate/core";
import {required, numeric, maxValue, minValue, email, url, maxLength, minLength} from "@vuelidate/validators";
import FormErrorsComponent from "../forms/FormErrorsComponent";

import {mapActions} from "pinia";
import {useGameStore} from "../../store";
import { gameApi } from '../../api';

export default {
    setup() {
        return {v$: useVuelidate()}
    },
    name: 'GameModal',
    components: {
        ModalComponent,
        FormErrorsComponent,
    },
    props: {
        modelValue: Boolean,
        dialogType: {
            type: String,
            required: true,
            validator: function (value) {
                return _.includes(['create', 'edit'], value);
            },
        },
        gameId: {
            type: Number,
        },
        isAdmin: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            form: {
                number_one: undefined,
                number_two: undefined,
                number_three: undefined,
                author_name: '',
                author_email: '',
                author_location: '',
                link: '',
            },
        };
    },
    computed: {
        value: {
            get() {
                return this.modelValue;
            },
            set(value) {
                this.$emit('update:modelValue', value);
            },
        },
        isEditingCurrentGame() {
            return this.gameId === useGameStore().currentGame.id;
        },
    },
    watch: {
        async gameId() {
            if (this.dialogType === 'edit') {
                this.form = await gameApi.getGameById(this.gameId);
            }
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
        ...mapActions(useGameStore, ['createGame', 'updateGame']),
        async onSubmitClicked() {
            const isFormCorrect = await this.v$.$validate()
            // you can show some extra alert to the user or just leave each field to show its `$errors`.
            if (!isFormCorrect) return

            if (this.dialogType === 'create') {
                if (this.isAdmin) {
                    await this.createGame(this.form);
                } else {
                    await gameApi.store(this.form);
                }
            } else if (this.dialogType === 'edit') {
                await this.updateGame(this.gameId, this.form);
            }
            this.value = false;
        },
    },
}
</script>
