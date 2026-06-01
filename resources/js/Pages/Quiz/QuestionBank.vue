<script setup lang="ts">
import AppLayout from '@/components/layout/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import InputGroup from '@/components/ui/input-group/InputGroup.vue';
import InputGroupAddon from '@/components/ui/input-group/InputGroupAddon.vue';
import InputGroupInput from '@/components/ui/input-group/InputGroupInput.vue';
import NativeSelect from '@/components/ui/native-select/NativeSelect.vue';
import NativeSelectOption from '@/components/ui/native-select/NativeSelectOption.vue';
import QuestionBankCard from '@/components/ui/quiz/QuestionBankCard.vue';
import { Plus, SearchIcon, X, XCircle } from 'lucide-vue-next';
import { Question } from '@/types/question';
import Dialog from '@/components/ui/dialog/Dialog.vue';
import DialogTrigger from '@/components/ui/dialog/DialogTrigger.vue';
import DialogContent from '@/components/ui/dialog/DialogContent.vue';
import DialogHeader from '@/components/ui/dialog/DialogHeader.vue';
import DialogTitle from '@/components/ui/dialog/DialogTitle.vue';
import DialogDescription from '@/components/ui/dialog/DialogDescription.vue';
import DialogFooter from '@/components/ui/dialog/DialogFooter.vue';
import DialogClose from '@/components/ui/dialog/DialogClose.vue';
import Input from '@/components/ui/input/Input.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import Label from '@/components/ui/label/Label.vue';
import ToggleGroup from '@/components/ui/toggle-group/ToggleGroup.vue';
import ToggleGroupItem from '@/components/ui/toggle-group/ToggleGroupItem.vue';
import { Course } from '@/types/course';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineOptions({
    layout: AppLayout,
})

const props = defineProps<{
    course: Course
    questions: Question[]
}>();

const form = useForm({
    title: '',
    description: '',
    difficulty: '',
    topic: [] as string[],
})

const topicInput = ref('');

function addTopic() {
    const value = topicInput.value.trim().toLowerCase();

    if (!value) return;

    if (!form.topic.includes(value)) {
        form.topic.push(value);
    }

    topicInput.value = '';
}

function removeTopic(topic: string) {
    form.topic = form.topic.filter(t => t !== topic);
}

function handleSubmit() {    
    form.post(`/courses/${props.course.id}/questions`, {
        preserveScroll: true,

        onSuccess: () => {
            form.reset();
        }
    });
}
</script>

<template>
    <div class="w-full mx-auto flex flex-col gap-6 py-6">
        <!-- Heading section -->
        <section class="flex items-start justify-between">
            <div>
                <h1 class="text-3xl font-bold">Question Bank</h1>
                <p class="text-sm text-muted-foreground">
                    Manage and organize your SQL assessment repository.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <!-- Dialog for creating a new question -->
                <Dialog>
                    <DialogTrigger as-child>
                        <Button variant="default">
                            <Plus class="mr-2 h-4 w-4" />
                            Create New Question
                        </Button>
                    </DialogTrigger>

                    <DialogContent class="sm:max-w-lg">
                        <DialogHeader>
                            <DialogTitle class="text-lg font-semibold">Create New Question</DialogTitle>
                            <DialogDescription class="text-sm text-muted-foreground">
                                Fill in the details below to add a new SQL challenge.
                            </DialogDescription>
                        </DialogHeader>

                        <form class="grid gap-5 py-2" @submit.prevent="handleSubmit">
                            <div class="grid gap-2">
                                <Label for="question-title">Question Title</Label>
                                <Input id="question-title" v-model="form.title" placeholder="e.g. Find the top 5 customers by revenue" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="question-description">Description</Label>
                                <Textarea id="question-description" v-model="form.description" placeholder="Describe the SQL challenge..."
                                    class="min-h-25 resize-none" />
                            </div>

                            <div class="grid gap-2">
                                <Label>Difficulty</Label>
                                <ToggleGroup type="single" v-model="form.difficulty" class="justify-start gap-2">
                                    <ToggleGroupItem value="easy"
                                        class="text-green-600 data-[state=on]:bg-green-100 data-[state=on]:text-green-700">
                                        Easy
                                    </ToggleGroupItem>
                                    <ToggleGroupItem value="medium"
                                        class="text-yellow-600 data-[state=on]:bg-yellow-100 data-[state=on]:text-yellow-700">
                                        Medium
                                    </ToggleGroupItem>
                                    <ToggleGroupItem value="hard"
                                        class="text-red-600 data-[state=on]:bg-red-100 data-[state=on]:text-red-700">
                                        Hard
                                    </ToggleGroupItem>
                                </ToggleGroup>
                            </div>
                            <div class="grid gap-2">
                                <Label>Topic</Label>
                                <div class="flex flex-wrap gap-2">
                                    <div 
                                    v-for="topic in form.topic" 
                                    :key="topic" 
                                    class="bg-secondary text-secondary-foreground flex items-center gap-1 rounded-md px-2 py-1 text-sm"
                                    >
                                    {{ topic }}
                                    <button type="button" @click="removeTopic(topic)"><XCircle class="h-3 w-3"/></button>
                                    </div>
                                </div>
                                <Input
                                v-model="topicInput"
                                placeholder="Type a topic and press enter"
                                @keydown.enter.prevent="addTopic"
                                />
                            </div>

                            <DialogFooter class="pt-2">
                                <DialogClose as-child>
                                    <Button type="button" variant="outline">Cancel</Button>
                                </DialogClose>
                                <Button type="submit" :disabled="form.processing">Create Question</Button>
                            </DialogFooter>
                        </form>
                    </DialogContent>
                </Dialog>
            </div>
        </section>

        <!-- Search and filtering section -->
        <section class="w-full flex items-center justify-between gap-4 px-4 py-2 border rounded-lg">
            <InputGroup class="w-full max-w-sm">
                <InputGroupInput placeholder="Search for title or keyword..." />
                <InputGroupAddon>
                    <SearchIcon class="h-4 w-4" />
                </InputGroupAddon>
            </InputGroup>
            <div class="flex items-center gap-2">
                <NativeSelect>
                    <NativeSelectOption value="">Difficulty</NativeSelectOption>
                    <NativeSelectOption value="easy">Easy</NativeSelectOption>
                    <NativeSelectOption value="medium">Medium</NativeSelectOption>
                    <NativeSelectOption value="hard">Hard</NativeSelectOption>
                </NativeSelect>
                <NativeSelect>
                    <NativeSelectOption value="">Topic</NativeSelectOption>
                    <NativeSelectOption value="join">Join</NativeSelectOption>
                    <NativeSelectOption value="group-by">Group By</NativeSelectOption>
                </NativeSelect>
                <NativeSelect>
                    <NativeSelectOption value="">Date Created</NativeSelectOption>
                    <NativeSelectOption value="newest">Newest First</NativeSelectOption>
                    <NativeSelectOption value="oldest">Oldest First</NativeSelectOption>
                </NativeSelect>
                <Button variant="ghost" class="text-muted-foreground gap-1">
                    <X class="h-4 w-4" />
                    Clear
                </Button>
            </div>
        </section>

        <!-- Question cards section -->
        <section class="grid grid-cols-2 gap-4">
            <div v-if="questions.length === 0" class="col-span-2 text-center py-12 text-muted-foreground">
                <p class="text-lg font-medium">No questions found</p>
                <p class="text-sm">Create your first question to get started.</p>
            </div>
            <QuestionBankCard v-for="question in questions" :key="question.id" :question="question" />
        </section>
    </div>
</template>