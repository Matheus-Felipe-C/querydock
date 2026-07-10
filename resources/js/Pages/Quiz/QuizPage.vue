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
import { ListFilter, Plus } from 'lucide-vue-next';

defineOptions({
    layout: AppLayout,
})

const props = defineProps<{
    course: Course;
    quizzes: Quiz[];
}>();
</script>

<template>
    <div class="w-full mx-auto flex flex-col gap-6 py-6">
        <section class="flex items-start justify-between">
            <div>
                <h1 class="text-3xl font-bold">Quizzes</h1>
                <p class="text-sm text-muted-foreground">
                    Manage your SQL assessments, monitor student performance and draft new curriculum logic.
                </p>
            </div>
            <div flex items-center gap-2>
                <Button><Plus class="w-4 h-4" /> Create new Quiz</Button>
            </div>
        </section>

        <!-- Search and filtering -->
        <section class="w-full flex items-center justify-evenly gap-4">
            <ToggleGroup type="single">
                <ToggleGroupItem value="all" aria-label="Toggle all">
                    <p>All</p>
                </ToggleGroupItem>
                <ToggleGroupItem value="Published" aria-label="Toggle published">
                    <p>Published</p>
                </ToggleGroupItem>
                <ToggleGroupItem value="Drafts" aria-label="Toggle drafts">
                    <p>Drafts</p>
                </ToggleGroupItem>
                <ToggleGroupItem value="archived" aria-label="Toggle archived">
                    <p>Archived</p>
                </ToggleGroupItem>
            </ToggleGroup>

            <InputGroup class="max-w-2xl">
                <InputGroupInput placeholder="Filter by title..." />
                <InputGroupAddon>
                    <ListFilter class="h-4 w-4" />
                </InputGroupAddon>
            </InputGroup>

            <div>
                <NativeSelect>
                    <NativeSelectOption value="">Date Created</NativeSelectOption>
                    <NativeSelectOption value="last_month">Last Month</NativeSelectOption>
                </NativeSelect>
            </div>
        </section>

        <!-- Quiz cards -->
        <section class="grid grid-cols-3 gap-2">
            <!-- Change this later to quizzes.length === 0, just changed this to make it easier to test out the design without a major refactor -->
            <div v-if="!course.id" class="col-span-3 text-center py-12 text-muted-foreground">
                <p class="text-lg font-medium">No quizzes found</p>
                <p class="text-sm">Create your first quiz to get started.</p>
            </div>
            <div v-else>
                <QuizCard />
            </div>
        </section>
    </div>
</template>