<script setup lang="ts">
import AppLayout from '@/components/layout/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import InputGroup from '@/components/ui/input-group/InputGroup.vue';
import InputGroupAddon from '@/components/ui/input-group/InputGroupAddon.vue';
import InputGroupInput from '@/components/ui/input-group/InputGroupInput.vue';
import NativeSelect from '@/components/ui/native-select/NativeSelect.vue';
import NativeSelectOption from '@/components/ui/native-select/NativeSelectOption.vue';
import QuizCard from '@/components/ui/quiz/QuizCard.vue';
import ToggleGroup from '@/components/ui/toggle-group/ToggleGroup.vue';
import ToggleGroupItem from '@/components/ui/toggle-group/ToggleGroupItem.vue';
import { Course } from '@/types/course';
import { Quiz } from '@/types/quiz';
import { Link } from '@inertiajs/vue3';
import { ListFilter, Plus } from 'lucide-vue-next';
import { route } from 'ziggy-js';

defineOptions({
    layout: AppLayout,
})

const props = defineProps<{
    course: Course;
    quizzes: Quiz[];
}>();
</script>

<template>
    <div class="w-full mx-auto flex flex-col gap-6 py-4 px-6 md:px-0">
        <section class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-xl font-bold md:text-2xl">Quizzes</h1>
                <p class="text-sm text-muted-foreground">
                    Manage your SQL assessments, monitor student performance and draft new curriculum logic.
                </p>
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <Button class="w-full sm:w-auto justify-center" as-child>
                    <Link :href="route('courses.quizzes.create', course.id )">
                        <Plus class="w-4 h-4" /> 
                        Create new Quiz
                    </Link>
                </Button>
            </div>
        </section>

        <!-- Search and filtering -->
        <section class="w-full flex flex-col gap-4 py-4 border rounded-lg lg:flex-row lg:items-center lg:justify-between">
            <div class="overflow-x-auto -mx-4 px-4 pb-1 sm:overflow-visible sm:mx-0 sm:px-0 sm:pb-0">
                <ToggleGroup type="single" class="justify-start inline-flex w-full sm:w-auto">
                    <ToggleGroupItem class="flex-1 sm:flex-initial" value="all" aria-label="Toggle all">
                        <p>All</p>
                    </ToggleGroupItem>
                    <ToggleGroupItem class="flex-1 sm:flex-initial" value="Published" aria-label="Toggle published">
                        <p>Published</p>
                    </ToggleGroupItem>
                    <ToggleGroupItem class="flex-1 sm:flex-initial" value="Drafts" aria-label="Toggle drafts">
                        <p>Drafts</p>
                    </ToggleGroupItem>
                    <ToggleGroupItem class="flex-1 sm:flex-initial" value="archived" aria-label="Toggle archived">
                        <p>Archived</p>
                    </ToggleGroupItem>
                </ToggleGroup>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center w-full lg:max-w-2xl lg:justify-end">
                <InputGroup class="max-w-2xl">
                    <InputGroupInput placeholder="Filter by title..." />
                    <InputGroupAddon>
                        <ListFilter class="h-4 w-4" />
                    </InputGroupAddon>
                </InputGroup>

                <div class="w-full sm:w-48 shrink-0">
                    <NativeSelect>
                        <NativeSelectOption value="">Date Created</NativeSelectOption>
                        <NativeSelectOption value="last_month">Last Month</NativeSelectOption>
                    </NativeSelect>
                </div>
            </div>
        </section>

        <!-- Quiz cards -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Change this later to quizzes.length === 0, just changed this to make it easier to test out the design without a major refactor -->
            <div v-if="!course.id" class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-12 text-muted-foreground">
                <p class="text-lg font-medium">No quizzes found</p>
                <p class="text-sm">Create your first quiz to get started.</p>
            </div>
            <div v-else>
                <QuizCard />
            </div>
        </section>
    </div>
</template>