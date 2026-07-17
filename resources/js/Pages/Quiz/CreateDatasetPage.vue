<script setup lang="ts">
import AppLayout from '@/components/layout/AppLayout.vue';
import DatasetForm from '@/components/ui/dataset/DatasetForm.vue';
import { Course } from '@/types/course';
import { useForm } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

defineOptions({
    layout: AppLayout,
})

const props = defineProps<{
    course: Course;
}>()

const form = useForm({
    name: '',
    description: '',
    sql_script: '',
})

function save() {
    form.post(route('courses.datasets.store', {
        course: props.course.id,
    }))
}
</script>

<template>
    <DatasetForm 
    :course="course"
    :form="form"
    @submit="save"
    mode="create"
    />
</template>