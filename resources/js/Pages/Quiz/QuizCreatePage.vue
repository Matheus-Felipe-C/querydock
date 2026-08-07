<script setup lang="ts">
import AppLayout from '@/components/layout/AppLayout.vue';
import QuizForm from '@/components/ui/quiz/QuizForm.vue';
import { Course } from '@/types/course';
import { QuizQuestion } from '@/types/QuizQuestion';
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

defineOptions({
    layout: AppLayout,
});

const props = defineProps<{
    course: Course;
}>();

const form = useForm({
    title: '',
    instructions: '',
    time_limit: '',
});

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
    })).post(route('courses.quizzes.store', props.course.id));

    form.post(route('courses.quizzes.store', {
        course: props.course.id,
    }))
}
</script>

<template>
    <QuizForm
        :form="form"
        :course="course"
        @submit="save"
        mode="create"
    />
</template>