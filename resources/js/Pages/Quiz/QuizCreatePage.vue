<script setup lang="ts">
import AppLayout from '@/components/layout/AppLayout.vue';
import QuizForm from '@/components/ui/quiz/QuizForm.vue';
import { Course } from '@/types/course';
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

function save() {
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