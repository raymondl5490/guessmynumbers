<template>
    <button
        class="w-24 h-10 text-center bg-gray-200 rounded-full cursor-pointer md:w-28 md:h-12 md:text-lg hover:bg-gray-500 hover:text-white"
    >
        {{ number }}
    </button>
</template>
<script>
export default {
    name: 'NumberPadNumber',
    props: {
        number: {
            require,
        },
    },
}
</script>