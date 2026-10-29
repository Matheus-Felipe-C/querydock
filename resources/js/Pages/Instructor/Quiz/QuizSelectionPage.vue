<script setup lang="ts">

import PageHeader from "@/components/PageHeader.vue";
import {Quiz} from "@/types/quiz.ts";

defineProps<{
    quiz: Quiz,
}>();
</script>

<template>
    <div class="w-full mx-auto flex flex-col gap-6 py-4 px-6 md:px-0">
        <PageHeader title="Select a quiz" />


    </div>
</template>
