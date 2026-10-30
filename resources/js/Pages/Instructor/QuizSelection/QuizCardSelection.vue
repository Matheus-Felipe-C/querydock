<script setup lang="ts">

import {Quiz} from "@/types/quiz.ts";
import {Course} from "@/types/course.ts";
import {Card, CardContent, CardFooter, CardHeader, CardTitle} from "@/components/ui/card";
import { List, Clock, Check } from 'lucide-vue-next';
import {Button} from "@/components/ui/button";

defineProps<{
    quiz: Quiz,
    course: Course,
    selected: boolean,
}>();

defineEmits<{
    (e: 'select'): void
}>()
</script>

<template>
    <Card
        @click="$emit('select')"
        class="relative w-full flex flex-col justify-between text-left cursor-pointer transition-all duration-150
        hover:border-primary/60 hover:shadow-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring
        focus-visible:ring-offset-2"
        :class="selected ? 'border-primary bg-primary/5 ring-1 ring-primary' : 'border-border'"
    >
        <div
            class="absolute right-4 top-4 flex h-5 w-5 items-center
                   justify-center rounded-full border transition-colors"
            :class="selected
                ? 'border-primary bg-primary text-primary-foreground'
                : 'border-muted-foreground/40 text-transparent'"
        >
            <Check class="h-3 w-3" />
        </div>

        <CardHeader>
            <CardTitle>{{ quiz.title }}</CardTitle>
        </CardHeader>
        <CardContent class="pb-24">
            <div class="grid grid-cols-2 gap-x-2 gap-y-3 text-sm sm:gap-4">
                <p class="flex min-w-0 items-center gap-2 font-medium text-muted-foreground">
                    <List class="h-4 w-4 shrink-0 text-foreground" />
                    <span class="truncate">
                        {{ quiz.questions_count }} Questions
                    </span>
                </p>

                <p class="flex min-w-0 items-center gap-2 font-medium text-muted-foreground">
                    <Clock class="h-4 w-4 shrink-0 text-foreground" />
                    <span class="truncate">
                        {{ quiz.time_limit ?? "-" }} Mins
                    </span>
                </p>
            </div>
        </CardContent>
        <CardFooter class="fixed inset-x-0 bottom-0 z-50 border bg-background p-4">
            <div class="mx-auto flex max-w-7xl justify-end">
                <Button>
                    Add quiz to activity
                </Button>
            </div>
        </CardFooter>
    </Card>
</template>

<style scoped>

</style>
