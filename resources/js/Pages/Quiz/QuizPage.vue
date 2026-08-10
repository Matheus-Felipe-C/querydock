<script setup lang="ts">
import AppLayout from '@/components/layout/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import InputGroup from '@/components/ui/input-group/InputGroup.vue';
import InputGroupAddon from '@/components/ui/input-group/InputGroupAddon.vue';
import InputGroupInput from '@/components/ui/input-group/InputGroupInput.vue';
import Pagination from '@/components/ui/pagination/Pagination.vue';
import PaginationNext from '@/components/ui/pagination/PaginationNext.vue';
import PaginationPrevious from '@/components/ui/pagination/PaginationPrevious.vue';
import QuizCard from '@/components/ui/quiz/QuizCard.vue';
import Select from '@/components/ui/select/Select.vue';
import SelectContent from '@/components/ui/select/SelectContent.vue';
import SelectItem from '@/components/ui/select/SelectItem.vue';
import SelectTrigger from '@/components/ui/select/SelectTrigger.vue';
import SelectValue from '@/components/ui/select/SelectValue.vue';
import ToggleGroup from '@/components/ui/toggle-group/ToggleGroup.vue';
import ToggleGroupItem from '@/components/ui/toggle-group/ToggleGroupItem.vue';
import { Course } from '@/types/course';
import { Quiz } from '@/types/quiz';
import { Link, router } from '@inertiajs/vue3';
import { ListFilter, Plus } from 'lucide-vue-next';
import { AcceptableValue, PaginationList, PaginationListItem } from 'reka-ui';
import { reactive, watch } from 'vue';
import { route } from 'ziggy-js';

defineOptions({
    layout: AppLayout,
})

interface PaginatedCollection<T> {
    data: T[];
    links: Array<{
        url: string | null;
        label: string;
        active: boolean;
    }>;
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
}

const props = defineProps<{
    course: Course;
    quizzes: PaginatedCollection<Quiz>;
    filters: {
        search?: string;
        status?: string;
        sort?: string;
    };
}>();

const filterForm = reactive({
    search: props.filters.search ?? '',
    status: props.filters.status ?? '',
    sort: props.filters.sort ?? '',
});

let timeout: ReturnType<typeof setTimeout>;

function applyFilters(immediate = false) {
    clearTimeout(timeout);

    const executeRequest = () => {
        router.get(
            route('courses.quizzes.index', props.course.id),
            { ...filterForm },
            { preserveState: true, replace: true }
        );
    };

    if (immediate) {
        executeRequest();
    } else {
        timeout = setTimeout(executeRequest, 300);
    }
}

watch(
    () => ({ ...filterForm }),
    () => applyFilters(false),
    { deep: true }
);

function changeSort(sort: AcceptableValue) {
    if (typeof sort !== 'string') {
        return;
    }

    filterForm.sort = sort;

    applyFilters(true);
}

function handlePageChange(page: number) {
    router.get(
        route('courses.quizzes.index', props.course.id),
        {
            ...props.filters,
            page: page,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
}
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
                <ToggleGroup v-model="filterForm.status" type="single" class="justify-start inline-flex w-full sm:w-auto">
                    <ToggleGroupItem class="flex-1 sm:flex-initial" value="" aria-label="Toggle all">
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
                    <InputGroupInput v-model="filterForm.search" placeholder="Filter by title..." />
                    <InputGroupAddon>
                        <ListFilter class="h-4 w-4" />
                    </InputGroupAddon>
                </InputGroup>

                <div class="w-full sm:w-48 shrink-0">
                    <Select :model-value="filterForm.sort" @update:model-value="changeSort">
                        <SelectTrigger class="w-48">
                            <SelectValue placeholder="Sort By.."/>
                        </SelectTrigger>

                        <SelectContent>
                            <SelectItem value="latest">Sort by: latest</SelectItem>
                            <SelectItem value="oldest">Sort by: oldest</SelectItem>
                        </SelectContent>
                    </Select>
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
            <template v-else>
                <QuizCard
                    v-for="quiz in props.quizzes.data"
                    :key="quiz.id"
                    :quiz="quiz"
                    :course-id="props.course.id"
                />
            </template>
        </section>

        <!-- Pagination controls -->
        <div v-if="props.quizzes.total > props.quizzes.per_page" class="flex justify-center pt-6">
            <Pagination
                :total="props.quizzes.total" 
                :items-per-page="props.quizzes.per_page"
                :sibling-count="1"
                :default-page="props.quizzes.current_page"
                :page="props.quizzes.current_page"
                @update:page="handlePageChange"
            >
                <PaginationList v-slot="{ items }" class="flex items-center gap-1">
                    <PaginationPrevious :disabled="props.quizzes.current_page === 1" />

                    <template v-for="(item, index) in items">
                        <PaginationListItem
                            v-if="item.type === 'page'"
                            :key="index"
                            :value="item.value"
                            as-child
                        >
                            <Button
                                class="w-9 h-9 p-0 text-sm"
                                :variant="item.value === props.quizzes.current_page ? 'default' : 'outline'"
                                @click="handlePageChange(item.value)"
                            >
                                {{ item.value }}
                            </Button>
                        </PaginationListItem>

                        <span
                            v-else
                            :key="`ellipsis-${index}`"
                            class="w-9 h-9 flex items-center justify-center text-sm text-muted-foreground"
                        >
                            &#8230;
                        </span>
                    </template>

                    <PaginationNext
                        :disabled="props.quizzes.current_page === props.quizzes.last_page"
                    />
                </PaginationList>
            </Pagination>
        </div>
    </div>
</template>