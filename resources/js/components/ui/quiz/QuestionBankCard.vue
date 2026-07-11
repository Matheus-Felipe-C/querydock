<script setup lang="ts">
import { LayersPlus, Pencil, Trash2 } from 'lucide-vue-next';
import Card from '../card/Card.vue';
import CardContent from '../card/CardContent.vue';
import CardFooter from '../card/CardFooter.vue';
import CardHeader from '../card/CardHeader.vue';
import CardTitle from '../card/CardTitle.vue';
import Button from '../button/Button.vue';
import Badge from '../badge/Badge.vue';
import { Question } from '@/types/question';
import { route } from 'ziggy-js';
import { Link, router } from '@inertiajs/vue3';
import AlertDialog from '../alert-dialog/AlertDialog.vue';
import AlertDialogTrigger from '../alert-dialog/AlertDialogTrigger.vue';
import AlertDialogContent from '../alert-dialog/AlertDialogContent.vue';
import AlertDialogTitle from '../alert-dialog/AlertDialogTitle.vue';
import AlertDialogHeader from '../alert-dialog/AlertDialogHeader.vue';
import AlertDialogDescription from '../alert-dialog/AlertDialogDescription.vue';
import AlertDialogFooter from '../alert-dialog/AlertDialogFooter.vue';
import AlertDialogCancel from '../alert-dialog/AlertDialogCancel.vue';
import AlertDialogAction from '../alert-dialog/AlertDialogAction.vue';
import { computed } from 'vue';

const props = defineProps<{
    question: Question
    courseId: number;
}>();

function deleteQuestion() {
    router.delete(
        route('courses.questions.destroy', {
            course: props.courseId,
            question: props.question.id,
        })
    )
}

const difficultyConfig = {
    easy: {
        label: 'EASY',
        className: 'bg-blue-100 text-blue-700 hover:bg-blue-200'
    },
    medium: {
        label: 'MEDIUM',
        className: 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200'
    },
    hard: {
        label: 'HARD',
        className: 'bg-red-100 text-red-700 hover:bg-red-200'
    }
}

const currentDifficulty = computed(() => {
    const diff = (props.question.difficulty ?? 'easy').toLowerCase() as 'easy' | 'medium' | 'hard';

    return difficultyConfig[diff] || difficultyConfig.easy;
})

</script>

<template>
    <Card>
        <!-- Question header -->
        <CardHeader>
            <div class="flex justify-between">
                <CardTitle>{{ question.title }}</CardTitle>

                <Badge 
                    :class="['px-2 py-1 transition-colors uppercase', currentDifficulty.className]"
                >
                    {{ currentDifficulty.label }}
                </Badge>
            </div>
            <!-- Question tags -->
            <div class="flex flex-wrap gap-2">
                <Badge variant="secondary" v-for="topic in question.topics">{{ topic }}</Badge>
            </div>
        </CardHeader>
        <CardContent>
            <div class="rounded-md bg-[#1e2433] text-sm font-mono text-blue-300 p-4 min-h-32">
                <!-- Replace this div with a CodeMirror/Monaco instance -->
                <p class="text-muted-foreground text-xs">Code editor goes here</p>
            </div>
        </CardContent>
        <CardFooter class="flex flex-col p-0">
            <div class="w-11/12 mx-auto border-t"></div>
            <div class="flex justify-between items-center w-full px-6 mt-4">
                <span class="text-muted-foreground">Created at</span>
                <div class="flex items-center gap-2">
                    <AlertDialog>
                        <AlertDialogTrigger>
                            <Button
                            variant="ghost"
                            size="icon"
                            class="text-red-600 hover:text-red-700 hover:bg-red-50"
                            >
                                <Trash2 class="w-8 h-8" />
                            </Button>
                        </AlertDialogTrigger>
                        <AlertDialogContent>
                            <AlertDialogHeader>
                                <AlertDialogTitle>
                                    Delete question?
                                </AlertDialogTitle>
                                <AlertDialogDescription>
                                    This action cannot be undone. The question "{{ question.title }}" will be permanently deleted.
                                </AlertDialogDescription>
                            </AlertDialogHeader>
                            <AlertDialogFooter>
                                <AlertDialogCancel>
                                    Cancel
                                </AlertDialogCancel>
                                <AlertDialogAction
                                    class="bg-red-600 hover:bg-red-700"
                                    @click="deleteQuestion"
                                >
                                    Delete
                                </AlertDialogAction>
                            </AlertDialogFooter>
                        </AlertDialogContent>
                    </AlertDialog>
                    <Link :href="route('courses.questions.edit', {
                        course: courseId,
                        question: question.id,
                    })">
                        <Pencil class="w-8 h-8 px-1 hover:bg-gray-200" />
                    </Link>
                    <Button><LayersPlus/>Add</Button>
                </div>
            </div>
        </CardFooter>
    </Card>
</template>