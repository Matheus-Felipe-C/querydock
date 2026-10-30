<script setup lang="ts">

import PageHeader from "@/components/PageHeader.vue";
import {Quiz} from "@/types/quiz.ts";
import {Course} from "@/types/course.ts";
import QuizCardSelection from "@/Pages/Instructor/QuizSelection/QuizCardSelection.vue";
import {ref} from "vue";

defineProps<{
    quizzes: Quiz[],
    course: Course,
}>();

const selectedQuizId = ref<number | null>(null);
</script>

<template>
    <div class="w-full mx-auto flex flex-col gap-6 py-4 px-6 md:px-0">
        <PageHeader title="Select a quiz" />

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div
                v-if="quizzes.length == 0"
                class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-12 text-muted-foreground"
            >
                <p class="text-lg font-medium">No quizzes found</p>
                <p class="text-sm">Create your first quiz to get started.</p>
            </div>
            <template v-else>
                <QuizCardSelection
                    v-for="quiz in quizzes"
                    :key="quiz.id"
                    :quiz="quiz"
                    :course="course"
                    :selected="selectedQuizId == quiz.id"
                    @select="selectedQuizId = quiz.id"
                />
            </template>
        </div>
    </div>
</template>
