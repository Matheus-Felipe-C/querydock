<script setup lang="ts">
import {Course} from "@/types/course.ts";
import {Quiz} from "@/types/quiz.ts";

const props = defineProps<{
    course: Course;
    quiz: Quiz;
}>();

const questions = props.quiz.questions;
const currentQuestion = questions?.[0] ?? null;
</script>

<template>
    <div v-if="currentQuestion">
        <h1>{{currentQuestion.title}}</h1>
    </div>
</template>

<style scoped>

</style>
