<template>
    <div v-if="validation[name].$error">
        <p
            v-for="error in validation[name].$errors"
            :key="error.$uid"
            class="text-red-700 text-sm"
        >
            {{ error.$message }}
        </p>
    </div>
</template>
<script>
export default {
    props: {
        validation: {
            type: Object,
            required: true,
        },
        name: {
            type: String,
            required: true,
        },
    }
}
</script>
