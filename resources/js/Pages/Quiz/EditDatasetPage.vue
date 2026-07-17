<script setup lang="ts">
import AppLayout from '@/components/layout/AppLayout.vue';
import DatasetForm from '@/components/ui/dataset/DatasetForm.vue';
import { Course } from '@/types/course';
import { Dataset } from '@/types/dataset';
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

defineOptions({
    layout: AppLayout,
})

const props = defineProps<{
    course: Course,
    dataset: Dataset,
}>();

const form = useForm({
    name: props.dataset.name,
    description: props.dataset.description,
    sql_script: props.dataset.sql_script,

})

function save() {
    form.patch(route('courses.datasets.update', {
        course: props.course.id,
        dataset: props.dataset,
    }))
}
</script>

<template>
    <DatasetForm
        :course="course"
        :form="form"
        @submit="save"
        mode="edit"
    />
</template>