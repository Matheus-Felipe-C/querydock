<script setup lang="ts">
import AppLayout from '@/components/layout/AppLayout.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import Breadcrumb from '@/components/ui/breadcrumb/Breadcrumb.vue';
import BreadcrumbItem from '@/components/ui/breadcrumb/BreadcrumbItem.vue';
import BreadcrumbLink from '@/components/ui/breadcrumb/BreadcrumbLink.vue';
import BreadcrumbList from '@/components/ui/breadcrumb/BreadcrumbList.vue';
import BreadcrumbPage from '@/components/ui/breadcrumb/BreadcrumbPage.vue';
import BreadcrumbSeparator from '@/components/ui/breadcrumb/BreadcrumbSeparator.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import { TableHead } from '@/components/ui/table';
import Table from '@/components/ui/table/Table.vue';
import TableBody from '@/components/ui/table/TableBody.vue';
import TableCell from '@/components/ui/table/TableCell.vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import ToggleGroup from '@/components/ui/toggle-group/ToggleGroup.vue';
import ToggleGroupItem from '@/components/ui/toggle-group/ToggleGroupItem.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { CheckCircle2, CircleAlert, FileCode, LoaderCircle, Play } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import { Course } from '@/types/course';
import { Question } from '@/types/question';
import { route } from 'ziggy-js';
import TopicInput from '@/components/ui/quiz/TopicInput.vue';

defineOptions({
    layout: AppLayout,
});

const props = defineProps<{
    course: Course;
    question: Question;
}>();

const form = useForm({
    title: props.question.title,
    description: props.question.description,
    difficulty: props.question.difficulty,
    topics: props.question.topics,
    expected_answer: props.question.expected_answer,
})

const save = () => {
    form.put(
        route('courses.questions.update', {
            course: props.course.id,
            question: props.question.id,
        })
    )
}

interface QueryExecutionResult {
    success: boolean;
    durationMs: number;
    columns: string[];
    rows: (string | number | null)[][];
    error?: string;
}

const isRunning = ref(true);

const executionResult = ref<QueryExecutionResult>({
    success: true,
    durationMs: 18,
    columns: ["id", "name", "score"],
    rows: [
        [1, "Alice", 95],
        [2, "Bob", 87],
        [3, "Charlie", 91],
        [4, "Diana", 78],
    ],
});

// Error mock
// executionResult.value = {
//     success: false,
//     durationMs: 3,

//     columns: [],
//     rows: [],

//     error:
//         'ERROR: relation "userss" does not exist\nLINE 1: SELECT * FROM userss',
// };

const questionStatus = computed(() => {
    if (executionResult.value?.success) {
        return {
            label: 'Published',
            variant: "default" as const,
        };
    }

    return {
        label: 'Draft',
        variant: "secondary" as const,
    };
})

</script>

<template>
    <div class="w-full mx-auto flex flex-col gap-2 px-4">
        <Breadcrumb>
            <BreadcrumbList>
                <BreadcrumbItem>
                    <BreadcrumbLink as-child>
                        <Link href="/dev/question-bank">Question Bank</Link>
                    </BreadcrumbLink>
                </BreadcrumbItem>
                <BreadcrumbSeparator />
                <BreadcrumbItem>
                    <BreadcrumbPage>Edit Question</BreadcrumbPage>
                </BreadcrumbItem>
            </BreadcrumbList>
        </Breadcrumb>

        <section class="flex items-start justify-between">
            <div>
                <h1 class="text-3xl font-bold">Edit Question: {{ form.title }}</h1>
                <p class="text-sm text-muted-foreground">Update prompt, schema, or solution validation.</p>
            </div>
            <div class="flex items-center gap-2">
                <Button variant="outline" as-child>
                    <Link :href="route('courses.questions.index', course.id)">
                        Cancel
                    </Link>
                </Button>
                <Button :disabled="form.processing" @click="save">
                    {{ form.processing ? "Saving..." : "Save Changes" }}
                </Button>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-[1fr_30rem]">
            <div class="max-w-3xl grid gap-6">
                <Card>
                    <CardHeader>
                        <CardTitle class="text-xl">Question metadata</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="grid gap-2 grid-cols-1">
                            <Label for="questionTitle">Question Title<span class="text-red-500">*</span></Label>
                            <Input id="questionTitle" placeholder="Find the customers with salaries over 1000"
                                required v-model="form.title" />

                            <div class="grid gap-6 py-4">
                                <div class="grid gap-2">
                                    <Label for="questionDifficulty">Question Difficulty<span
                                            class="text-red-500">*</span></Label>
                                    <ToggleGroup type="single" v-model="form.difficulty" variant="outline" size="lg">
                                        <ToggleGroupItem class="md:w-28" value="easy" aria-label="Easy difficulty">Easy
                                        </ToggleGroupItem>
                                        <ToggleGroupItem class="md:w-28" value="medium" aria-label="Medium difficulty">
                                            Medium</ToggleGroupItem>
                                        <ToggleGroupItem class="md:w-28" value="hard" aria-label="Hard difficulty">Hard
                                        </ToggleGroupItem>
                                    </ToggleGroup>
                                </div>

                                <div class="gap-2">
                                    <TopicInput id="questionTopics" v-model="form.topics" placeholder="CTEs, Window Functions, Aggregation" />
                                </div>

                            </div>
                        </div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle class="text-xl">Question Prompt</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <Textarea class="min-h-40" placeholder="Write a query to..." v-model="form.description" />
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2 text-xl">
                            <FileCode />Schema Configuration (DDL & Seed Data)
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <!-- TODO: Change this to a CodeMirror instance later -->
                        <Textarea class="min-h-40" placeholder="This will be changed to a CodeMirror instance later" />
                    </CardContent>
                </Card>
            </div>

            <div class="space-y-4">
                <Card>
                    <CardHeader>
                        <CardTitle class="text-xl flex items-center gap-2">
                            <CheckCircle2 />
                            Gold solution validation
                        </CardTitle>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div>
                            <Label for="reference-query" class="mb-2">Reference topics</Label>
                            <!-- TODO: Change this to a CodeMirror instance later -->
                            <Textarea id="reference-query" class="min-h-30"
                                placeholder="This will be changed to a CodeMirror instance later" />
                        </div>

                        <Button variant="secondary" class="w-full">
                            <Play />
                            Run Test
                        </Button>

                        <div class="space-y-2">
                            <Label>Results</Label>

                            <!-- Results -->
                            <div class="rounded-lg border overflow-hidden">
    
                                <!-- Idle -->
                                <div v-if="!executionResult && !isRunning"
                                    class="flex h-48 items-center justify-center text-sm text-muted-foreground">
                                    Run the query to see the results.
                                </div>
    
                                <!-- Loading -->
                                <div v-else-if="!executionResult && isRunning" class="flex items-center gap-2 p-6 text-sm">
                                    <LoaderCircle class="h-4 w-4 animate-spin" />
                                    Executing query...
                                </div>
    
                                <!-- Success -->
                                <template v-else-if="executionResult.success">
    
                                    <!-- Status -->
                                    <div class="flex items-center justify-between border-b bg-muted/40 px-4 py-2 text-sm">
                                        <div class="flex items-center gap-2 text-green-600">
                                            <CheckCircle2 class="h-4 w-4" />
                                            Query executed successfully
                                        </div>
    
                                        <div class="text-muted-foreground">
                                            {{ executionResult.rows.length }}
                                            rows •
                                            {{ executionResult.durationMs }} ms
                                        </div>
                                    </div>
    
                                    <!-- Scrollable table -->
                                    <div class="max-h-80 overflow-auto">
                                        <Table class="min-w-full">
                                            <TableHeader>
                                                <TableRow>
                                                    <TableHead v-for="column in executionResult.columns" :key="column">
                                                        {{ column }}
                                                    </TableHead>
                                                </TableRow>
                                            </TableHeader>
    
                                            <TableBody>
                                                <TableRow v-for="(row, i) in executionResult.rows" :key="i">
                                                    <TableCell v-for="(cell, j) in row" :key="j">
                                                        {{ cell }}
                                                    </TableCell>
                                                </TableRow>
                                            </TableBody>
                                        </Table>
                                    </div>
    
                                </template>
    
                                <!-- Error -->
                                <template v-else>
    
                                    <!-- Status -->
                                    <div class="flex items-center gap-2 border-b bg-red-50 px-4 py-2 text-sm text-red-700">
                                        <CircleAlert class="h-4 w-4" />
                                        Query failed
                                    </div>
    
                                    <!-- Error details -->
                                    <pre class="overflow-auto p-4 text-sm whitespace-pre-wrap text-red-800">{{
                                        executionResult.error
                                    }}</pre>
    
                                </template>
    
                            </div>
                        </div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle class="text-xl">Settings</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div class="space-y-2 border-b pb-4">
                            <Label for="question-point-value">Point Value</Label>
                            <Input 
                                id="question-point-value" 
                                type="number" 
                                min="0"
                                class="max-w-30"
                            />
                        </div>
                        <div class="flex items-start justify-between mt-4">
                            <div v-if="questionStatus.label === 'Published'">
                                <span class="font-semibold text-sm">Status</span>
                                <p class="text-muted-foreground text-sm">Ready for quizzes</p>
                            </div>
                            <div v-else>
                                <span class="font-semibold text-sm">Status</span>
                                <p class="text-muted-foreground text-sm">Not ready to add to a quiz yet</p>
                            </div>
                            <Badge class="text-sm" :variant="questionStatus.variant">
                                {{ questionStatus.label }}
                            </Badge>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </section>

    </div>
</template>