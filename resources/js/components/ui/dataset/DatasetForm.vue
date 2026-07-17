<script setup lang="ts">
import { Course } from '@/types/course';
import { computed } from 'vue';
import { route } from 'ziggy-js';
import Label from '../label/Label.vue';
import Input from '../input/Input.vue';
import SqlEditor from '../quiz/SqlEditor.vue';
import Breadcrumb from '../breadcrumb/Breadcrumb.vue';
import BreadcrumbList from '../breadcrumb/BreadcrumbList.vue';
import BreadcrumbItem from '../breadcrumb/BreadcrumbItem.vue';
import BreadcrumbLink from '../breadcrumb/BreadcrumbLink.vue';
import BreadcrumbSeparator from '../breadcrumb/BreadcrumbSeparator.vue';
import BreadcrumbPage from '../breadcrumb/BreadcrumbPage.vue';
import Card from '../card/Card.vue';
import CardHeader from '../card/CardHeader.vue';
import CardContent from '../card/CardContent.vue';
import Button from '../button/Button.vue';
import CardTitle from '../card/CardTitle.vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps<{
    form: any;
    mode: 'edit' | 'create';
    course: Course;
}>()

const emit = defineEmits<{
    submit: [];
}>();

const pageTitle = computed(() => {
    return props.mode === 'edit'
        ? `Edit Dataset: ${props.form.title}`
        : 'Create New Dataset'
});

const subtitle = computed(() => {
    return props.mode === 'edit'
        ? 'Update prompt, schema, or solution validation.'
        : 'Configure a new SQL exercise.'
})
</script>

<template>
    <div class="w-full mx-auto flex flex-col gap-2 px-4">
        <Breadcrumb>
            <BreadcrumbList>
                <BreadcrumbItem>
                    <BreadcrumbLink as-child>
                        <Link :href="route('courses.datasets.index', course.id)">
                            Datasets
                        </Link>
                    </BreadcrumbLink>
                </BreadcrumbItem>
                <BreadcrumbSeparator />
                <BreadcrumbItem>
                    <BreadcrumbPage>
                        {{ mode === 'edit' 
                            ? 'Edit Dataset'
                            : 'Create Dataset'}}
                    </BreadcrumbPage>
                </BreadcrumbItem>
            </BreadcrumbList>
        </Breadcrumb>

        <section class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-xl font-bold md:text-2xl">
                    {{ pageTitle }}
                </h1>
                <p class="text-sm text-muted-foreground">
                    {{ subtitle }}
                </p>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <Button variant="outline" as-child class="flex-1 sm:flex-initial justify-center">
                    <Link :href="route('courses.datasets.index', course.id)">
                        Cancel
                    </Link>
                </Button>
                <Button :disabled="form.processing" @click="emit('submit')" class="flex-1 sm:flex-initial justify-center">
                    {{ form.processing ? "Saving..." : "Save Changes" }}
                </Button>
            </div>
        </section>

        <section class="grid gap-4 grid-cols-1  ">
            <div class="grid w-full gap-6">
                <Card>
                    <CardHeader>
                        <CardTitle class="text-xl">Dataset Data</CardTitle>
                    </CardHeader>
                    <CardContent class="grid grid-cols-1 lg:grid-cols-[320px_1fr] gap-6">
                        <div class="flex flex-col gap-6">
                            <div class="grid gap-2">
                                <Label>
                                    Dataset Title 
                                    <span class="text-red-700">*</span>
                                </Label>
                                <Input v-model="form.name" />
                                <p v-if="form.errors.name" class="text-sm">
                                    {{ form.errors.name }}
                                </p>
                            </div>

                            <div class="grid gap-2">
                                <Label>
                                    Description
                                </Label>
                                <Input v-model="form.description" />
                            </div>
                        </div>

                        <div class="flex flex-col gap-1">
                            <Label>
                                SQL Script
                                <span class="text-red-700">*</span>
                            </Label>

                            <p v-if="form.errors.sql_script" class="text-sm bg-red-200 text-destructive">
                                {{ form.errors.sql_script }}
                            </p>

                            <SqlEditor v-model="form.sql_script" min-height="400px" />
                        </div>
                    </CardContent>
                </Card>
            </div>
        </section>
    </div>
</template>