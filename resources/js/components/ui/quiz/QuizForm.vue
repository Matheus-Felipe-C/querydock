<script setup lang="ts">
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
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { Link } from '@inertiajs/vue3';
import { CircleAlert } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import { Course } from '@/types/course';
import { route } from 'ziggy-js';
import Alert from '../alert/Alert.vue';
import AlertTitle from '../alert/AlertTitle.vue';
import AlertDescription from '../alert/AlertDescription.vue';
import QuestionCard from './QuestionCard.vue';
import AddNewItem from './AddNewItem.vue';
import { QuizQuestion } from '@/types/QuizQuestion.ts';
import QuestionPickerDialog from './QuestionPickerDialog.vue';

const props = defineProps<{
    form: any,
    mode: 'create' | 'edit',
    course: Course
}>();

const emit = defineEmits<{
    submit: [];
}>();

const pageTitle = computed(() => {
    return props.mode === 'edit'
        ? `Edit Quiz: ${props.form.title}`
        : 'Create new Quiz';
});

const selectedQuestions = ref<QuizQuestion[]>([]);
const pickerOpen = ref(false);

function handleQuestionSelection(newQuestions: QuizQuestion[]) {
    selectedQuestions.value = [...selectedQuestions.value, ...newQuestions];

    props.form.questions = selectedQuestions.value.map(q => q.question.id);
}

</script>

<template>
    <div class="w-full mx-auto flex flex-col gap-2 px-4">
        <Alert v-if="form.hasErrors" variant="destructive" class="mb-4">
            <CircleAlert class="w-4 h-4" />
            <AlertTitle>Error</AlertTitle>
            <AlertDescription>
                There was a problem saving the question. Please check the fields below.
            </AlertDescription>
        </Alert>
        <Breadcrumb>
            <BreadcrumbList>
                <BreadcrumbItem>
                    <BreadcrumbLink as-child>
                        <Link :href="route('courses.quizzes.index', course.id)">Quizzes</Link>
                    </BreadcrumbLink>
                </BreadcrumbItem>
                <BreadcrumbSeparator />
                <BreadcrumbItem>
                    <BreadcrumbPage>
                        {{ mode === 'edit'
                            ? 'Edit Quiz'
                            : 'Create Quiz' }}
                    </BreadcrumbPage>
                </BreadcrumbItem>
            </BreadcrumbList>
        </Breadcrumb>

        <section class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-xl font-bold md:text-2xl">
                    {{ pageTitle }}
                </h1>
                <p class="text-sm text-muted-foreground">
                    Configure quiz details and define questions to be used.
                </p>
            </div>
            <div class="flex items-center gap-2 w-full sm:w-auto">
                <Button variant="outline" as-child class="flex-1 sm:flex-initial justify-center">
                    <Link :href="route('courses.quizzes.index', course.id)">
                        Cancel
                    </Link>
                </Button>
                <Button :disabled="form.processing" @click="emit('submit')"
                    class="flex-1 sm:flex-initial justify-center">
                    {{ form.processing ? "Saving..." : "Save Changes" }}
                </Button>
            </div>
        </section>
        <Card>
            <CardHeader>
                <CardTitle>Quiz Configuration</CardTitle>
            </CardHeader>
            <CardContent class="space-y-6">

                <!-- Quiz title + Time limit -->
                <div class=" grid grid-cols-3 gap-4">
                    <div class="col-span-2 space-y-2">
                        <Label>
                            Quiz Title <span class="text-destructive">*</span>
                        </Label>
                        <Input v-model="form.title" placeholder="e.g., Midterms: Advanced Joins & Subqueries"
                            required />
                    </div>
                    <div class="space-y-2">
                        <Label>Time Limit (Minutes)</Label>
                        <Input v-model="form.time_limit" type="number" placeholder="Optional" />
                    </div>
                </div>

                <!-- Instructions -->
                <div class="space-y-2">
                    <Label>
                        Instructions <span class="text-muted-foreground text-sm font-normal">(Markdown supported)</span>
                    </Label>
                    <Textarea v-model="form.instructions" placeholder="provide context or rules for this assessment..."
                        class="resize-none min-h-20"></Textarea>
                </div>
            </CardContent>
        </Card>

        <div v-if="selectedQuestions.length">
            <QuestionCard  
                v-for="(question, index) in selectedQuestions" 
                :key="question.question.id" 
                :question="question" 
                :index="index" 
                @update:weight="val => question.weight = val"
                @update:is_bonus="val => question.is_bonus = val"
                @update:is_optional="val => question.is_optional = val"
                @remove="selectedQuestions.splice(index, 1)"
            />
        </div>

        <div v-else class="text-center text-muted-foreground py-12">
            <p class="text-lg font-medium">
                No questions selected.
            </p>
        </div>
        <AddNewItem label="Add new item" @click="pickerOpen = true" />
        <!-- QuizForm.vue -->
        <QuestionPickerDialog v-model:open="pickerOpen" :course-id="course.id"
            :selected-item="selectedQuestions.map(q => q.question.id)" @selected="handleQuestionSelection" />
    </div>
</template>