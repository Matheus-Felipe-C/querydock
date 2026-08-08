<script setup lang="ts">
import Card from '../card/Card.vue';
import CardHeader from '../card/CardHeader.vue';
import CardTitle from '../card/CardTitle.vue';
import { Clock, EllipsisVerticalIcon, List, User } from 'lucide-vue-next';
import DropdownMenu from '../dropdown-menu/DropdownMenu.vue';
import DropdownMenuTrigger from '../dropdown-menu/DropdownMenuTrigger.vue';
import DropdownMenuContent from '../dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '../dropdown-menu/DropdownMenuItem.vue';
import CardContent from '../card/CardContent.vue';
import CardFooter from '../card/CardFooter.vue';
import Button from '../button/Button.vue';
import { route } from 'ziggy-js';
import { Quiz } from '@/types/quiz.ts';
import { Link, router } from '@inertiajs/vue3';
import AlertDialog from '../alert-dialog/AlertDialog.vue';
import AlertDialogTrigger from '../alert-dialog/AlertDialogTrigger.vue';
import AlertDialogContent from '../alert-dialog/AlertDialogContent.vue';
import AlertDialogHeader from '../alert-dialog/AlertDialogHeader.vue';
import AlertDialogTitle from '../alert-dialog/AlertDialogTitle.vue';
import AlertDialogDescription from '../alert-dialog/AlertDialogDescription.vue';
import AlertDialogFooter from '../alert-dialog/AlertDialogFooter.vue';
import AlertDialogCancel from '../alert-dialog/AlertDialogCancel.vue';
import AlertDialogAction from '../alert-dialog/AlertDialogAction.vue';

const props = defineProps<{
    quiz: Quiz,
    courseId: number,
}>();

function deleteQuiz() {
    router.delete(
        route('courses.quizzes.destroy', {
            course: props.courseId,
            quiz: props.quiz,
        })
    )
};

</script>

<template>
    <Card class="flex flex-col justify-between">
        <CardHeader class="flex flex-row items-start justify-between gap-4">
            <div class="flex flex-col gap-2 min-w-0">
                <CardTitle class="text-lg font-bold leading-tight wrap-break-word">{{ quiz.title }}</CardTitle>
            </div>

            <div class="shrink-0">
                <AlertDialog>
                    <DropdownMenu>
                        <DropdownMenuTrigger as-child>
                            <Button variant="ghost">
                                <EllipsisVerticalIcon class="w-4 h-4" />
                            </Button>
                        </DropdownMenuTrigger>

                        <DropdownMenuContent align="end">
                            <DropdownMenuItem as-child>
                                <Link :href="route('courses.quizzes.edit', {
                                    course: courseId,
                                    quiz
                                })">
                                    Edit Quiz
                                </Link>
                            </DropdownMenuItem>

                            <AlertDialogTrigger as-child>
                                <DropdownMenuItem
                                    class="text-destructive data-highlighted:bg-destructive/10 data-highlighted:text-destructive"
                                    @select.prevent>
                                    Delete Quiz
                                </DropdownMenuItem>
                            </AlertDialogTrigger>
                        </DropdownMenuContent>
                    </DropdownMenu>

                    <AlertDialogContent>
                        <AlertDialogHeader>
                            <AlertDialogTitle>
                                Delete Quiz?
                            </AlertDialogTitle>

                            <AlertDialogDescription>
                                This action cannot be undone.
                                The quiz "{{ quiz.title }}" will be permanently deleted.
                            </AlertDialogDescription>
                        </AlertDialogHeader>

                        <AlertDialogFooter>
                            <AlertDialogCancel>
                                Cancel
                            </AlertDialogCancel>

                            <AlertDialogAction class="bg-red-600 hover:bg-red-700" @click="deleteQuiz">
                                Delete
                            </AlertDialogAction>
                        </AlertDialogFooter>
                    </AlertDialogContent>
                </AlertDialog>
            </div>
        </CardHeader>

        <CardContent>
            <div class="grid grid-cols-2 gap-x-2 gap-y-3 sm:gap-4 text-sm">
                <p class="font-medium text-muted-foreground flex gap-2 items-center min-w-0 truncate">
                    <List class="w-4 h-4 text-foreground shrink-0" /> 
                    <span>{{ props.quiz.questions_count }} Questions</span>
                </p>
                <p class="font-medium text-muted-foreground flex gap-2 items-center min-w-0 truncate">
                    <Clock class="w-4 h-4 text-foreground shrink-0" />                    
                    <span>{{ props.quiz.timeLimit ?? 0 }} mins</span>
                </p>
                <p class="font-medium text-muted-foreground flex gap-2 items-center min-w-0 truncate">
                    <User class="w-4 h-4 text-foreground shrink-0" />
                    <span>128 students</span>
                </p>
            </div>
        </CardContent>

        <CardFooter class="flex flex-wrap gap-3 justify-between items-center pt-0">
            <p class="text-muted-foreground italic text-xs">Edited 2 hours ago</p>
            <div class="flex items-center gap-1">
                <Button variant="ghost" size="sm">Preview</Button>
                <Button size="sm">Results</Button>
            </div>
        </CardFooter>
    </Card>
</template>