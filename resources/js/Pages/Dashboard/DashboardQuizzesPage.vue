<script setup lang="ts">
import AppLayout from "@/components/layout/AppLayout.vue";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { ArrowRight } from "lucide-vue-next";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import { Course } from "@/types/course.ts";
import { QuizSummary } from "@/types/dashboard.ts";

defineOptions({
    layout: AppLayout,
});

const props = defineProps<{
    course: Course;
    recent_quizzes: QuizSummary[];
}>();
</script>

<template>
    <section class="w-full mx-auto py-4 px-4 md:px-0">
        <Card>
            <CardHeader class="flex justify-between">
                <CardTitle>Recent quizzes</CardTitle>
                <Badge variant="secondary">
                    {{ props.recent_quizzes.length }} displayed
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
                        <TableRow
                            v-for="quiz in props.recent_quizzes"
                            :key="quiz.id"
                        >
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
                </Table>
            </CardContent>
        </Card>
    </section>
</template>

<style scoped></style>
