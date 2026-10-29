<script setup lang="ts">
defineProps<{
    title: string,
    description?: string,
}>();
</script>

<template>
    <section class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-xl font-bold md:text-2xl">{{ title }}</h1>
            <p class="text-sm text-muted-foreground">
                {{ description }}
            </p>
        </div>
        <div v-if="$slots.default" class="flex items-center gap-2 w-full sm:w-auto">
            <slot />
        </div>
    </section>
</template>

<style scoped>

</style>
