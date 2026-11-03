<script setup lang="ts">

import {onMounted, ref} from "vue";

const props = defineProps<{
    returnUrl: string;
    fields: Record<string, string>;
}>();

const form = ref<HTMLFormElement | null>(null);
onMounted(() => form.value?.submit());
</script>

<template>
    <form ref="form" :action="returnUrl" method="POST">
        <input v-for="(value, name) in fields" :key="name" type="hidden" :name="name" :value="value" />
        <noscript><button type="submit">Continue</button></noscript>
    </form>
    <p class="p-6 text-muted-foreground">Returning to Moodle...</p>
</template>

<style scoped>

</style>
