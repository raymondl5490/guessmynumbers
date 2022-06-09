<template>
    <modal-component
        :show="show"
        @close="onClose"
    >
        <template #title>
            {{ game ? 'Update Game' : 'Create Game'}}
        </template>
        <template #content>
            <game-form-component :game="game" @saved="onClose"/>
        </template>
    </modal-component>
</template>
<script>
import ModalComponent from "../ui/ModalComponent";
import GameFormComponent from "../forms/GameFormComponent";

export default {
    components: {
        ModalComponent,
        GameFormComponent
    },
    props: {
        game: {
            type: Object,
            default: () => {},
            required: false,
        },
        show: {
            type: Boolean,
            required: true,
        }
    },
    methods: {
        onClose() {
            this.$emit('close')
        }
    }
}
</script>
