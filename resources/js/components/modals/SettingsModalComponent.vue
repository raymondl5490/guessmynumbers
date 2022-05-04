<template>
    <ModalComponent
        :show="show"
        @close="onClose"
    >
        <template #icon><IconComponent icon="circle-question" /></template>
        <template #title>This is my modal</template>
        <template #content>This is the body content</template>
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
