<template>
    <div>
        This is my game.

        <h3>Here is data served from vue3</h3>
        <p>{{ configuredData }}</p>
    </div>
</template>
<script>
export default {
    data() {
        return {
            configuredData: 'wow look a message'
        }
    }
}
</script>
