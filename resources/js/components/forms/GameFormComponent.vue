<template>
    <div class="flex flex-col">
        <div class="flex flex-row">
            <div>
                <label class="block text-sm font-medium text-gray-700">Number One</label>
                <div class="mt-1">
                    <input type="number" v-model="editGame.number_one" class="input"
                           @input="v$.editGame.number_one.$touch"/>
                    <form-errors-component name="number_one" :validation="v$.editGame"/>
                </div>
            </div>
            <div class="px-5">
                <label class="block text-sm font-medium text-gray-700">Number Two</label>
                <div class="mt-1">
                    <input type="number" v-model="editGame.number_two" class="input"
                           @input="v$.editGame.number_two.$touch"/>
                    <form-errors-component name="number_two" :validation="v$.editGame"/>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Number Three</label>
                <div class="mt-1">
                    <input type="number" v-model="editGame.number_three" class="input"
                           @input="v$.editGame.number_three.$touch"/>
                    <form-errors-component name="number_three" :validation="v$.editGame"/>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <div class="mt-1">
                <input v-model="editGame.author_name" class="input"
                       @input="v$.editGame.author_name.$touch"/>
                <form-errors-component name="author_name" :validation="v$.editGame"/>
            </div>
        </div>
        <div class="mt-3">
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <div class="mt-1">
                <input type="email" v-model="editGame.author_email" class="input"
                       @input="v$.editGame.author_email.$touch"/>
                <form-errors-component name="author_email" :validation="v$.editGame"/>
            </div>
        </div>
        <div class="mt-3">
            <label class="block text-sm font-medium text-gray-700">Location</label>
            <div class="mt-1">
                <input type="email" v-model="editGame.author_location" class="input"
                       @input="v$.editGame.author_location.$touch"/>
                <form-errors-component name="author_location" :validation="v$.editGame"/>
            </div>
        </div>
        <div class="mt-3">
            <label class="block text-sm font-medium text-gray-700">Link</label>
            <div class="mt-1">
                <input type="url" v-model="editGame.link" class="input"
                       @input="v$.editGame.link.$touch"/>
                <form-errors-component name="link" :validation="v$.editGame"/>
            </div>
        </div>
        <div class="mt-3">
            <label class="block text-sm font-medium text-gray-700">Link Title</label>
            <div class="mt-1">
                <input type="url" v-model="editGame.link_title" class="input"
                       @input="v$.editGame.link_title.$touch"/>
                <form-errors-component name="link_title" :validation="v$.editGame"/>
            </div>
        </div>

        <div class="my-5 text-center button button-primary" @click="onSave">{{ game ? 'Update Game' : 'Create Game'}}</div>
    </div>
</template>
<script>
import {mapActions} from "pinia";
import {useGameStore} from "../../store";
import {cloneDeep} from "lodash";
import useVuelidate from "@vuelidate/core";
import {required, numeric, maxValue, minValue, email, alpha, url, alphaNum} from "@vuelidate/validators";
import FormErrorsComponent from "./FormErrorsComponent";

export default {
    setup() {
        return {v$: useVuelidate()}
    },
    components: {
        FormErrorsComponent
    },
    props: {
        game: {
            type: Object,
            default: () => {
            },
            required: false,
        },
    },
    data() {
        return {
            editGame: {}
        }
    },
    created() {
        if (this.game) {
            this.editGame = cloneDeep(this.game)
        }
    },
    validations() {
        return {
            editGame: {
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
                },
                author_email: {
                    email,
                },
                author_location: {
                    alpha,
                },
                link: {
                    url,
                },
                link_title: {
                    alphaNum,
                },
            }
        }
    },
    methods: {
        ...mapActions(useGameStore, ['createGame', 'updateGame']),
        async onSave() {
            console.log({game: this.editGame})
            const isFormCorrect = await this.v$.$validate()
            // you can show some extra alert to the user or just leave each field to show its `$errors`.
            if (!isFormCorrect) return
            // actually submit form
            if (this.game) {
                await this.updateGame(this.game.id, this.editGame);
            } else {
                await this.createGame(this.editGame);
            }

            // await this.getAllGames();
            this.$emit('saved');
        }
    }
}
</script>
