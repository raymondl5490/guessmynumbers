<template>
    <el-dialog v-model="value">
        <template #header="{ close, titleId, titleClass }">
            <slot name="title"></slot>
        </template>
        <slot name="content"></slot>
    </el-dialog>
</template>

<script>
export default {
    props: ['modelValue'],
    emits: ['update:modelValue'],
    computed: {
        value: {
            get() {
                return this.modelValue;
            },
            set(value) {
                this.$emit('update:modelValue', value);
            },
        },
    },
}
</script>
<style>
.el-dialog {
    width: 90% !important;
}
/* Extra small devices (phones, 600px and down) */
@media only screen and (max-width: 600px) {
    .el-dialog {
        width: 370px !important;
    }
}

/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (min-width: 600px) {
    .el-dialog {
        width: 500px !important;
    }
}

/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {
    .el-dialog {
        width: 600px !important;
    }
}

</style>