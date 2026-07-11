<script setup lang="ts">
import AppLayout from '@/components/layout/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import InputGroup from '@/components/ui/input-group/InputGroup.vue';
import InputGroupAddon from '@/components/ui/input-group/InputGroupAddon.vue';
import InputGroupInput from '@/components/ui/input-group/InputGroupInput.vue';
import QuestionBankCard from '@/components/ui/quiz/QuestionBankCard.vue';
import { Plus, SearchIcon, X } from 'lucide-vue-next';
import { PaginateQuestions } from '@/types/question';
import { Course } from '@/types/course';
import { route } from 'ziggy-js';
import { Link, router } from '@inertiajs/vue3';
import { reactive } from 'vue';
import { watchDebounced } from '@vueuse/core';
import Select from '@/components/ui/select/Select.vue';
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue';
import SelectValue from '@/components/ui/select/SelectValue.vue';
import SelectContent from '@/components/ui/select/SelectContent.vue';
import SelectItem from '@/components/ui/select/SelectItem.vue';

defineOptions({
    layout: AppLayout,
})

const props = defineProps<{
    course: Course;
    questions: PaginateQuestions;
    topics: string[],
    filters: {
        search?: string;
        difficulty?: string;
        topic?: string;
        sort?: string;
    }
}>();

const filters = reactive({
    search: props.filters?.search ?? '',
    difficulty: props.filters.difficulty ?? '',
    topic: props.filters.topic ?? '',
    sort: props.filters.sort ?? '',
})

watchDebounced(
    () => filters.search,
    () => {
        router.get(
            route('courses.questions.index', props.course.id),
            filters,
            {
                preserveState: true,
                replace: true,
            }
        )
    },
    {
        debounce: 300,
        maxWait: 1000,
    }
)

function applyFilters() {
    router.get(
        route('courses.questions.index', props.course.id),
        filters,
        {
            preserveState: true,
            replace: true,
        }
    );
}

function clearFilters() {
    filters.search = '';
    filters.difficulty = '';
    filters.topic = '';
    filters.sort = '';

    applyFilters();
}

</script>

<template>
    <div class="w-full mx-auto flex flex-col gap-6 px-4 py-6 md:py-0">
        <!-- Heading section -->
        <section class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-xl font-bold md:text-2xl">Question Bank</h1>
                <p class="text-sm text-muted-foreground">
                    Manage and organize your SQL assessment repository.
                </p>
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <Button as-child class="w-full sm:w-auto justify-center">
                    <Link :href="route('courses.questions.create', course.id)">
                        <Plus class="mr-2 h-4 w-4" />
                        Create new Question
                    </Link>
                </Button>
            </div>
        </section>

        <!-- Search and filtering section -->
        <section class="w-full flex flex-col gap-4 p-4 border rounded-lg md:flex-row md:items-center md:justify-between">
            <InputGroup class="w-full md:max-w-sm">
                <InputGroupInput 
                    v-model="filters.search" 
                    placeholder="Search for title or keyword..."
                />
                <InputGroupAddon>
                    <SearchIcon class="h-4 w-4" />
                </InputGroupAddon>
            </InputGroup>
            <div class="grid grid-cols-2 gap-2 w-full sm:flex sm:items-center sm:w-auto">
                <Select v-model="filters.difficulty" @update:model-value="applyFilters">
                    <SelectTrigger class="w-full sm:w-32.5">
                        <SelectValue placeholder="Difficulty" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem value="easy">Easy</SelectItem>
                        <SelectItem value="medium">Medium</SelectItem>
                        <SelectItem value="hard">Hard</SelectItem>
                    </SelectContent>
                </Select>
                <Select v-model="filters.topic" @update:model-value="applyFilters">
                    <SelectTrigger class="w-full sm:w-40">
                        <SelectValue placeholder="Topics" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem
                            v-for="topic in topics"
                            :key="topic"
                            :value="topic"
                        >
                            {{ topic }}
                        </SelectItem>
                    </SelectContent>
                </Select>
                <Button variant="ghost" class="col-span-2 text-muted-foreground gap-1 justify-center sm:col-span-1" @click="clearFilters">
                    <X class="h-4 w-4" />
                    Clear
                </Button>
            </div>
        </section>

        <!-- Question cards section -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div v-if="questions.data.length === 0" class="col-span-1 md:grid-cols-2 lg:grid-cols-3 text-center py-12 text-muted-foreground">
                <p class="text-lg font-medium">No questions found</p>
                <p class="text-sm">Create your first question to get started.</p>
            </div>
            <QuestionBankCard v-for="question in questions.data" :key="question.id" :question="question" :course-id="course.id" />
        </section>

        <div class="flex justify-center gap-2 mt-8">
            <Link 
                v-for="link in questions.links"
                :key="link.label"
                :href="link.url ?? ''"
                :class="[
                    'px-3 py-2 rounded border',
                    link.active && 'bg-primary text-primary-foreground',
                    link.url && 'opacity-50 pointer-events-none'
                ]"
                v-html="link.label"
            />
        </div>
    </div>
</template>