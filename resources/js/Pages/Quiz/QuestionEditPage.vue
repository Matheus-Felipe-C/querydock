<script setup lang="ts">
import AppLayout from '@/components/layout/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { Course } from '@/types/course';
import { Question } from '@/types/question';
import { route } from 'ziggy-js';
import QuestionForm from '@/components/ui/quiz/QuestionForm.vue';
import { Dataset } from '@/types/dataset';

defineOptions({
    layout: AppLayout,
});

const props = defineProps<{
    course: Course;
    question: Question;
    datasets: Dataset[];
}>();

const form = useForm({
    title: props.question.title,
    description: props.question.description,
    difficulty: props.question.difficulty,
    topics: props.question.topics,
    expected_answer: props.question.expected_answer,
    dataset_id: props.question.dataset_id,
    question_id: props.question.id,
})

const save = () => {
    form.put(
        route('courses.questions.update', {
            course: props.course.id,
            question: props.question.id,
        })
    )
}

</script>

<template>
    <QuestionForm
        :form="form"
        :course="course"
        :datasets="datasets"
        mode="edit"
        @submit="save"
    />
</template>
