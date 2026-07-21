<script setup lang="ts">
import { Question } from '@/types/question';
import { QuizQuestion } from '@/types/QuizQuestion';
import { computed, ref, watch } from 'vue';
import { route } from 'ziggy-js';
import Dialog from '../dialog/Dialog.vue';
import DialogContent from '../dialog/DialogContent.vue';
import DialogHeader from '../dialog/DialogHeader.vue';
import DialogTitle from '../dialog/DialogTitle.vue';
import DialogDescription from '../dialog/DialogDescription.vue';
import Checkbox from '../checkbox/Checkbox.vue';
import DialogFooter from '../dialog/DialogFooter.vue';
import Button from '../button/Button.vue';
import Label from '../label/Label.vue';

const props = defineProps<{
    open: boolean;
    courseId: number;
    selectedItem: number[];
}>();

const emit = defineEmits<{
    'update:open': [boolean];
    selected: [QuizQuestion[]];
}>();

const questions = ref<(Question[])>([]);
const checkedIds = ref<number[]>([]);
const loading = ref(false);

// QuestionPickerDialog.vue
watch(
    () => props.open,
    async (open) => {
        if (!open) return;

        loading.value = true;

        try {
            // Pass the exclude array properly in the query params
            const response = await fetch(
                route('courses.questions.picker', {
                    course: props.courseId,
                    exclude: props.selectedItem, // Sends array of IDs to exclude
                }),
                {
                    headers: {
                        Accept: 'application/json',
                    },
                }
            );

            if (!response.ok) {
                throw new Error('Failed to load questions');
            }

            const data = await response.json();

            questions.value = data.data;
            checkedIds.value = [];
        } finally {
            loading.value = false;
        }
    }
);

const availableQuestions = computed(() => {
    return questions.value.filter(
        q => !props.selectedItem.includes(q.id),
    );
})

function addQuestions() {
    const selected: QuizQuestion[] = questions.value
        .filter(question => checkedIds.value.includes(question.id))
        .map((question, index) => ({
            question,
            weight: 1,
            position: index + 1,
            is_bonus: false,
            is_optional: false,
        }));

    emit('selected', selected);
    emit('update:open', false);
}

function toggleQuestion(id: number, checked: boolean | string) {
    const isChecked = checked === true;

    if (isChecked) {
        checkedIds.value.push(id);
    } else {
        checkedIds.value = checkedIds.value.filter(i => i !== id);
    }
}
</script>

<template>
    <Dialog :open="open" @update:open="emit('update:open', $event)">
        <DialogContent class="max-w-3xl">
            <DialogHeader>
                <DialogTitle>Add Questions</DialogTitle>
                <DialogDescription>
                    Select one or more questions from the question bank.
                </DialogDescription>
            </DialogHeader>

            <div v-if="loading">
                Loading...
            </div>

            <div v-else class="space-y-2 max-h-[500px] overflow-y-auto">
                <p v-if="availableQuestions.length === 0" class="text-center text-muted-foreground text-sm py-4">
                    No additional questions available to add.
                </p>

                <div v-else v-for="question in questions" :key="question.id"
                    class="flex items-center gap-3 rounded border p-3">
                    <Checkbox :id="`question-${question.id}`" :model-value="checkedIds.includes(question.id)"
                        @update:model-value="checked => toggleQuestion(question.id, checked)" />
                    <Label :for="`question-${question.id}`" class="flex-1 cursor-pointer">
                        <p class="font-medium">
                            {{ question.title }}
                        </p>

                        <p class="text-sm text-muted-foreground">
                            {{ question.difficulty }}
                        </p>
                    </Label>
                </div>
            </div>

            <DialogFooter>
                <Button variant="outline" @click="emit('update:open', false)">
                    Cancel
                </Button>

                <Button @click="addQuestions">
                    Add {{ checkedIds.length }} questions
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>