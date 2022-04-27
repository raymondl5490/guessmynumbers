<template>
    <div class="w-20 h-20 bg-gray-300 m-2 text-2xl text-gray-900 flex justify-center items-center">
        {{ guessedNumber }}
    </div>
</template>
<script>
export default {
    props: {
        guessedNumber: {
            type: Number,
        },
        style: {
            type: String,
            default: ''
        }
    }
}
</script>
