<script setup lang="ts">
import AppLayout from '@/components/layout/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import InputGroup from '@/components/ui/input-group/InputGroup.vue';
import InputGroupAddon from '@/components/ui/input-group/InputGroupAddon.vue';
import InputGroupInput from '@/components/ui/input-group/InputGroupInput.vue';
import NativeSelect from '@/components/ui/native-select/NativeSelect.vue';
import NativeSelectOption from '@/components/ui/native-select/NativeSelectOption.vue';
import QuestionBankCard from '@/components/ui/quiz/QuestionBankCard.vue';
import { Plus, SearchIcon, X } from 'lucide-vue-next';
import { Question } from '@/types/question';
import { Course } from '@/types/course';
import { route } from 'ziggy-js';
import { Link } from '@inertiajs/vue3';

defineOptions({
    layout: AppLayout,
})

const props = defineProps<{
    course: Course
    questions: Question[]
}>();

</script>

<template>
    <div class="w-full mx-auto flex flex-col gap-6 py-6">
        <!-- Heading section -->
        <section class="flex items-start justify-between">
            <div>
                <h1 class="text-3xl font-bold">Question Bank</h1>
                <p class="text-sm text-muted-foreground">
                    Manage and organize your SQL assessment repository.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <Button as-child>
                    <Link :href="route('courses.questions.create', course.id)">
                        <Plus class="mr-2 h-4 w-4" />
                        Create new Question
                    </Link>
                </Button>
            </div>
        </section>

        <!-- Search and filtering section -->
        <section class="w-full flex items-center justify-between gap-4 px-4 py-2 border rounded-lg">
            <InputGroup class="w-full max-w-sm">
                <InputGroupInput placeholder="Search for title or keyword..." />
                <InputGroupAddon>
                    <SearchIcon class="h-4 w-4" />
                </InputGroupAddon>
            </InputGroup>
            <div class="flex items-center gap-2">
                <NativeSelect>
                    <NativeSelectOption value="">Difficulty</NativeSelectOption>
                    <NativeSelectOption value="easy">Easy</NativeSelectOption>
                    <NativeSelectOption value="medium">Medium</NativeSelectOption>
                    <NativeSelectOption value="hard">Hard</NativeSelectOption>
                </NativeSelect>
                <NativeSelect>
                    <NativeSelectOption value="">Topic</NativeSelectOption>
                    <NativeSelectOption value="join">Join</NativeSelectOption>
                    <NativeSelectOption value="group-by">Group By</NativeSelectOption>
                </NativeSelect>
                <NativeSelect>
                    <NativeSelectOption value="">Date Created</NativeSelectOption>
                    <NativeSelectOption value="newest">Newest First</NativeSelectOption>
                    <NativeSelectOption value="oldest">Oldest First</NativeSelectOption>
                </NativeSelect>
                <Button variant="ghost" class="text-muted-foreground gap-1">
                    <X class="h-4 w-4" />
                    Clear
                </Button>
            </div>
        </section>

        <!-- Question cards section -->
        <section class="grid grid-cols-2 gap-4">
            <div v-if="questions.length === 0" class="col-span-2 text-center py-12 text-muted-foreground">
                <p class="text-lg font-medium">No questions found</p>
                <p class="text-sm">Create your first question to get started.</p>
            </div>
            <QuestionBankCard v-for="question in questions" :key="question.id" :question="question" :course-id="course.id" />
        </section>
    </div>
</template>