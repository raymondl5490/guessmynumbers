<template>
    <el-dialog v-model="value" :show-close="false">
        <template #header="{ close, titleId, titleClass }">
            <slot name="title"></slot>
            <button @click="close" class="absolute right-0 w-12 h-12 text-2xl border-0 top-2">
                <el-icon><CloseBold /></el-icon>
            </button>
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
    width: 100% !important;
    margin-top: 0 !important;
}

.el-dialog .el-dialog__header {
    padding-left: 5px;
    padding-right: 5px;
    padding-top: 7px;
    padding-bottom: 0px;
    margin-right: 0 !important;
}

.el-dialog .el-dialog__body {
    font-size: 1.25rem/* 20px */;
    line-height: 1.75rem/* 28px */;

    overflow-wrap: normal;
    word-break: normal;
}

/* Extra small devices (phones, 600px and down) */
@media only screen and (max-width: 600px) {
    .el-dialog {
        width: 100% !important;
        margin-top: 7vh !important;
    }
}

/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (min-width: 600px) {
    .el-dialog {
        width: 600px !important;
        margin-top: 10vh !important;
    }
}

/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {
    .el-dialog {
        width: 700px !important;
        margin-top: 15vh !important;
    }
}

</style>