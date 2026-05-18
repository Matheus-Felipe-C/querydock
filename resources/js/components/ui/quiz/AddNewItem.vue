<script setup lang="ts">
import { Plus } from 'lucide-vue-next';

defineProps({
    label: String,
})
</script>

<template>
    <button
        type="button"
        class="w-full border-2 border-dashed border-muted-foreground/30 rounded-lg py-8 flex flex-col items-center justify-center gap-2 text-muted-foreground hover:text-foreground transition-colors cursor-pointer"
    >
        <Plus class="w-5 h-5" />
        <span>{{ label }}</span>
    </button>
</template>