<script setup lang="ts">
import AppLayout from "@/components/layout/AppLayout.vue";
import {Course} from "@/types/course.ts";
import AppBreadcrumb from "@/components/AppBreadcrumb.vue";
import {route} from "ziggy-js";
import {computed} from "vue";
import {QuizSummary} from "@/types/dashboard.ts";
import {Quiz} from "@/types/quiz.ts";

defineOptions({
    layout: AppLayout
})

const props = defineProps<{
    course: Course,
    quizSummary: QuizSummary,
    quiz: Quiz,
}>();

const avgCompletionMinutes = computed(() =>
    props.quizSummary.avg_completion_seconds
        ? Math.round(props.quizSummary.avg_completion_seconds / 60)
        : null
);

const summaryStrip = computed(() => {
    return [
        {
            title: 'Average Score',
            value: props.quizSummary.avg_score,
            details: '%'
        },

        {
            title: 'Submissions',
            value: props.quizSummary.submissions_count,
            details: ''
        },

        {
            title: 'Median score',
            value: props.quizSummary.median_score,
            details: '%'
        },

        {
            title: 'Avg completion time',
            value: avgCompletionMinutes,
            details: ''
        }
    ]
})
</script>

<template>
    <div class="w-full mx-auto flex flex-col gap-2 px-4">
        <AppBreadcrumb
            :items="[
                { label: 'Quizzes', href: route('courses.quizzes.index', course.id) },
                { label: quiz.title, href: route('courses.quizzes.show', [course.id, quiz.id] ) },
                { label: 'Show quiz results' }
            ]"
        />
    </div>

    <section class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <h1 class="text-xl font-bold md:text-2xl">
                {{ quiz.title }}
            </h1>
    </section>

    <section class="mt-4">
        <div
            class="grid grid-cols-2 gap-4 rounded-xl border p-4 md:grid-cols-4 md:gap-0 md:divide-x
            [&>*:nth-child(odd)]:border-r md:[&>*:nth-child(odd)]:border-r-0"
        >
            <div
                v-for="summary in summaryStrip"
                :key="summary.title"
                class="px-2 md:flex-1 md:px-6 md:first:pl-0 md:last:pr-0"
            >
                <h4 class="uppercase text-muted-foreground text-xs">{{ summary.title }}</h4>
                <div class="flex items-baseline gap-2">
                    <span class="font-bold text-xl">{{ summary.value }}</span>
                    <span class="text-muted-foreground">{{ summary.details }}</span>
                </div>
            </div>
        </div>
    </section>
</template>

<style scoped>

</style>
