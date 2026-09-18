<script setup lang="ts">
import {Course} from "@/types/course.ts";
import {DashboardSummary, QuizSummary} from "@/types/dashboard.ts";
import {Button} from "@/components/ui/button";
import {route} from "ziggy-js";
import {ArrowRight, Plus} from "lucide-vue-next";
import {Link} from "@inertiajs/vue3";
import AppLayout from "@/components/layout/AppLayout.vue";
import {Card, CardContent, CardHeader, CardTitle} from "@/components/ui/card";
import {computed} from "vue";
import {Badge} from "@/components/ui/badge";
import {Table, TableBody, TableCell, TableHead, TableHeader, TableRow,} from "@/components/ui/table";

defineOptions({
    layout: AppLayout,
});

const props = defineProps<{
    course: Course;
    summary: DashboardSummary;
    recent_quizzes: QuizSummary[];
}>();

const lastFiveQuizzes = props.recent_quizzes.slice(0, 5);

const summaryStrip = computed(() => {
    return [
        {
            title: "Total quizzes",
            value: props.summary.quiz_count,
            details: "Quizzes",
        },
        {
            title: "Active now",
            value: props.summary.active_quiz_count,
            details: "Quizzes",
        },
        {
            title: "Total submissions",
            value: props.summary.submission_count,
            details: "Submissions",
        },
        {
            title: "Average score",
            value: String(props.summary.avg_score) + "%",
            details: "Course avg",
        },
    ];
});
</script>

<template>
    <div class="w-full mx-auto flex flex-col gap-2 px-4">
        <section
            class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between"
        >
            <h1 class="text-xl font-bold md:text-2xl">Dashboard</h1>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <Button
                    variant="default"
                    as-child
                    class="flex-1 sm:flex-initial justify-center"
                >
                    <Link :href="route(`courses.quizzes.create`, course.id)">
                        <Plus class="h-4 w-4" />
                        Create new Quiz
                    </Link>
                </Button>
            </div>
        </section>

        <!-- Summary strip -->
        <section class="mt-4">
            <div
                class="grid grid-cols-2 gap-4 rounded-xl border p-4 md:grid-cols-4 md:gap-0 md:divide-x
               [&>*:nth-child(odd)]:border-r md:[&>*:nth-child(odd)]:border-r-0"
            >
                <div
                    v-for="summary in summaryStrip"
                    :key="summary.title"
                    class="px-2 md:flex-1 md:px-6 md:first:pl-0 md:last:pr-0"
                >
                    <h4 class="uppercase text-muted-foreground text-xs">{{ summary.title }}</h4>
                    <div class="flex items-baseline gap-2">
                        <span class="font-bold text-xl">{{ summary.value }}</span>
                        <span class="text-muted-foreground">{{ summary.details }}</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Recent quizzes -->
        <section class="w-full mx-auto py-4">
            <Card>
                <CardHeader class="flex justify-between">
                    <CardTitle>Recent quizzes</CardTitle>
                    <Badge variant="secondary">
                        {{ lastFiveQuizzes.length }} displayed
                    </Badge>
                </CardHeader>
                <CardContent>
                    <!-- Desktop/tablet: real table -->
                    <div class="hidden md:block">
                        <Table>
                            <TableHeader>
                                <TableRow>
                                    <TableHead>Quiz Name</TableHead>
                                    <TableHead>Questions</TableHead>
                                    <TableHead>Submissions</TableHead>
                                    <TableHead>Avg. Score</TableHead>
                                    <TableHead>Last Updated</TableHead>
                                    <TableHead>Action</TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow
                                    v-for="quiz in lastFiveQuizzes"
                                    :key="quiz.id"
                                >
                                    <TableCell>{{ quiz.title }}</TableCell>
                                    <TableCell>{{
                                        quiz.questions_count
                                    }}</TableCell>
                                    <TableCell>{{
                                        quiz.submissions_count
                                    }}</TableCell>
                                    <TableCell
                                        >{{ quiz.avg_score ?? "—"
                                        }}{{
                                            quiz.avg_score !== null ? "%" : ""
                                        }}</TableCell
                                    >
                                    <TableCell>{{
                                        quiz.updated_at_human
                                    }}</TableCell>
                                    <TableCell>
                                        <Button variant="outline">
                                            Open
                                            <ArrowRight class="w-4 h-4" />
                                        </Button>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </div>

                    <!-- Mobile: stacked card list -->
                    <div class="flex flex-col divide-y md:hidden">
                        <div
                            v-for="quiz in lastFiveQuizzes"
                            :key="quiz.id"
                            class="flex items-center justify-between py-3"
                        >
                            <div class="min-w-0">
                                <p class="font-medium truncate">
                                    {{ quiz.title }}
                                </p>
                                <p class="text-sm text-muted-foreground">
                                    {{ quiz.questions_count }} questions ·
                                    {{ quiz.submissions_count }} submissions
                                    <span v-if="quiz.avg_score !== null">
                                        · {{ quiz.avg_score }}%</span
                                    >
                                </p>
                                <p class="text-xs text-muted-foreground">
                                    {{ quiz.updated_at_human }}
                                </p>
                            </div>
                            <Button
                                variant="outline"
                                size="icon"
                                class="shrink-0"
                            >
                                <ArrowRight class="w-4 h-4" />
                            </Button>
                        </div>
                    </div>

                    <!-- Shared footer (applies to both views) -->
                    <div
                        class="flex flex-col gap-3 pt-4 sm:flex-row sm:items-center sm:justify-between"
                    >
                        <span class="text-muted-foreground text-sm">
                            Showing {{ lastFiveQuizzes.length }} out of
                            {{ props.recent_quizzes.length }} active quizzes
                        </span>
                        <Link
                            :href="
                                route(
                                    'courses.dashboard.indexQuizzes',
                                    props.course.id,
                                )
                            "
                        >
                            <Button
                                variant="default"
                                class="flex w-full items-center gap-2 sm:w-auto"
                            >
                                View all
                                {{ props.recent_quizzes.length }} quizzes
                                <ArrowRight class="w-4 h-4" />
                            </Button>
                        </Link>
                    </div>
                </CardContent>
            </Card>
        </section>
    </div>
</template>

<style scoped></style>
