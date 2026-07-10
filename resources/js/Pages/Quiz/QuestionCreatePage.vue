<script setup lang="ts">
import AppLayout from '@/components/layout/AppLayout.vue';
import QuestionForm from '@/components/ui/quiz/QuestionForm.vue';
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
    description: '',
    difficulty: '',
    topics: [] as string[],
})

function save() {
    form.post(route('courses.questions.store', {
        course: props.course.id
    }))
}
</script>

<template>
    <QuestionForm
        :form="form"
        :course="course"
        @submit="save"
        mode="create"
    />
</template>