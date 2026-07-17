<script setup lang="ts">
import AppLayout from '@/components/layout/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import DatasetCard from '@/components/ui/dataset/DatasetCard.vue';
import Select from '@/components/ui/select/Select.vue';
import SelectContent from '@/components/ui/select/SelectContent.vue';
import SelectItem from '@/components/ui/select/SelectItem.vue';
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue';
import SelectValue from '@/components/ui/select/SelectValue.vue';
import { Course } from '@/types/course';
import { Dataset } from '@/types/dataset';
import { Link } from '@inertiajs/vue3';
import { Plus } from '@lucide/vue';
import { route } from 'ziggy-js';

defineOptions({
    layout: AppLayout,
});

const props = defineProps<{
    course: Course;
    datasets: Dataset[];   
}>();
</script>

<template>
    <div class="w-full mx-auto flex flex-col gap-6 px-4 py-6 md:py-0">
        <section class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-xl font-bold md:text-2xl">Datasets</h1>
                <p class="text-sm text-muted-foreground">
                    Manage database schemas and initial data for your questions.
                </p>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <Button as-child class="w-full sm:w-auto justify-center">
                    <Link :href="route('courses.datasets.create', course.id)">
                        <Plus class=" mr-2 w-4 h-4" />
                        Create new Dataset
                    </Link>
                </Button>
            </div>
        </section>

        <section>
            <Select>
                <SelectTrigger class="w-40">
                    <SelectValue placeholder="Sort by..." />
                </SelectTrigger>
                <SelectContent>
                    <SelectItem value="newest">Sort by: Newest</SelectItem>
                    <SelectItem value="name">Sort by: Name</SelectItem>
                    <SelectItem value="usage">Sort by: Usage</SelectItem>
                </SelectContent>
            </Select>
        </section>

        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div v-if="datasets.length === 0" class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 text-muted-foreground">
                <p class="text-lg font-medium">No datasets found</p>
                <p class="text-sm">Create your first dataset to get started.</p>
            </div>
            <DatasetCard v-for="dataset in datasets" :key="dataset.id" :course-id="course.id" :dataset="dataset" />
        </section>
    </div>
</template>