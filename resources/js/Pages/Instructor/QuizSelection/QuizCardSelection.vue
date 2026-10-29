<script setup lang="ts">

import {Quiz} from "@/types/quiz.ts";
import {Course} from "@/types/course.ts";
import {Card, CardHeader, CardTitle} from "@/components/ui/card";

defineProps<{
    quiz: Quiz,
    course: Course,
    selected: boolean,
}>();

defineEmits<{
    (e: 'select'): void
}>()
</script>

<template>
    <Card class="flex flex-col justify-between">
        <CardHeader>
            <CardTitle>{{ quiz.title }}</CardTitle>
        </CardHeader>
    </Card>
</template>

<style scoped>

</style>
