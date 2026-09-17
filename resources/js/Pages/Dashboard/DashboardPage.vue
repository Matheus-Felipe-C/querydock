<script setup lang="ts">
import {Course} from "@/types/course.ts";
import {DashboardSummary, QuizSummary} from "@/types/dashboard.ts";
import {Button} from "@/components/ui/button";
import {route} from "ziggy-js";
import {Plus, ArrowRight} from "lucide-vue-next";
import {Link} from "@inertiajs/vue3";
import AppLayout from "@/components/layout/AppLayout.vue";
import {Card, CardContent, CardHeader, CardTitle} from "@/components/ui/card";
import {computed} from "vue";
import {Badge} from "@/components/ui/badge";
import {Table, TableBody, TableCell, TableFooter, TableHead, TableHeader, TableRow} from "@/components/ui/table";

defineOptions({
    layout: AppLayout
})

const props = defineProps<{
    course: Course;
    summary: DashboardSummary;
    recent_quizzes: QuizSummary[];
}>();

const lastFiveQuizzes = props.recent_quizzes.slice(0, 5);

const summaryStrip = computed(() => {
    return [
        {
            title: 'Total quizzes',
            value: props.summary.quiz_count,
            details: 'Quizzes'
        },
        {
            title: 'Active now',
            value: props.summary.active_quiz_count,
            details: 'Quizzes'
        },
        {
            title: 'Total submissions',
            value: props.summary.submission_count,
            details: 'Submissions'
        },
        {
            title: 'Average score',
            value: String(props.summary.avg_score) + '%',
            details: 'Course avg'
        }
    ]
})
</script>

<template>
    <div class="w-full mx-auto flex flex-col gap-2 px-4">
        <section class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <h1 class="text-xl font-bold md:text-2xl">
                Dashboard
            </h1>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <Button variant="default" as-child class="flex-1 sm:flex-initial justify-center">
                    <Link :href="route(`courses.quizzes.create`, course.id)">
                        <Plus class="h-4 w-4" />
                        Create new Quiz
                    </Link>
                </Button>
            </div>
        </section>

        <!-- Summary strip -->
        <section>
            <Card class="w-full mx-auto py-4 px-4 md:px-0">
                <CardContent class="flex items-center justify-between">
                    <div
                        v-for="( summary, index ) in summaryStrip"
                        :key="summary.title"
                        class="flex-1 px-6 first:pl-0 last:pr-0"
                        :class="{ 'border-r': index < summaryStrip.length - 1}"
                    >
                        <h4 class="uppercase text-muted-foreground">{{ summary.title }}</h4>
                        <div class="flex items-baseline gap-2">
                            <span class="font-bold text-xl">{{ summary.value }}</span>
                            <span class="text-muted-foreground">{{ summary.details }}</span>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </section>

        <!-- Recent quizzes -->
        <section class="w-full mx-auto py-4 px-4 md:px-0">
            <Card>
                <CardHeader class="flex justify-between">
                    <CardTitle>Recent quizzes</CardTitle>
                    <Badge variant="secondary">
                        {{ lastFiveQuizzes.length }} displayed
                    </Badge>
                </CardHeader>
                <CardContent>
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
                            <TableRow v-for="quiz in lastFiveQuizzes" :key="quiz.id">
                                <TableCell>{{ quiz.title }}</TableCell>
                                <TableCell>{{ quiz.questions_count }}</TableCell>
                                <TableCell>{{ quiz.submissions_count }}</TableCell>
                                <TableCell>{{ quiz.avg_score }}</TableCell>
                                <TableCell>{{ quiz.updated_at_human }}</TableCell>
                                <TableCell>
                                    <Button variant="outline">
                                        Open
                                        <ArrowRight class="w-4 h-4" />
                                    </Button>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                        <TableFooter>
                            <TableRow>
                                <TableCell colspan="5" class="text-muted-foreground text-sm">
                                    Showing {{ lastFiveQuizzes.length }} out of {{ props.recent_quizzes.length }} active quizzes
                                </TableCell>
                                <TableCell>
                                    <Button
                                        variant="default"
                                        class="flex flex-row items-center gap-2"
                                    >
                                        <a :href="route('courses.dashboard.indexQuizzes', props.course.id)">
                                           View all {{ props.recent_quizzes.length }} quizzes <ArrowRight class="w-4 h-4" />
                                        </a>

                                    </Button>
                                </TableCell>
                            </TableRow>
                        </TableFooter>
                    </Table>
                </CardContent>
            </Card>
        </section>
    </div>
</template>

<style scoped>

</style>
