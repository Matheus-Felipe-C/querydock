<script setup lang="ts">
import AppLayout from '@/components/layout/AppLayout.vue';
import QuizForm from '@/components/ui/quiz/QuizForm.vue';
import { Course } from '@/types/course';
import { Quiz } from '@/types/quiz';
import { QuizQuestion } from '@/types/QuizQuestion';
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

defineOptions({
    layout: AppLayout,
});

const props = defineProps<{
    course: Course;
    quiz: Quiz & { questions?: any[]};
}>();

const form = useForm({
    title: props.quiz.title,
    instructions: props.quiz.instructions,
    time_limit: props.quiz.timeLimit,
});

const initialQuestions: QuizQuestion[] = (props.quiz.questions ?? []).map((q) => ({
    question: q,
    weight: q.pivot?.weight ?? 1,
    position: q.pivot?.position ?? 1,
    is_bonus: Boolean(q.pivot?.is_bonus),
    is_optional: Boolean(q.pivot?.is_optional),
}))

function save(questions: QuizQuestion[]) {
    form.transform((data) => ({
        ...data,
        questions: questions.map((q, index) => ({
            id: q.question.id,
            weight: q.weight,
            position: index + 1,
            is_bonus: q.is_bonus,
            is_optional: q.is_optional,
        })),
    })).put(route('courses.quizzes.update', {
        course: props.course.id, 
        quiz: props.quiz,
    }));
}
</script>

<template>
    <QuizForm
        :form="form"
        :course="course"
        :initial-questions="initialQuestions"
        @submit="save"
        mode="edit"
    />
</template>