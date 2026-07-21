<script setup lang="ts">
import { GripVertical, Trash2 } from 'lucide-vue-next';
import Card from '../card/Card.vue';
import Button from '../button/Button.vue';
import Label from '../label/Label.vue';
import Input from '../input/Input.vue';
import CardContent from '../card/CardContent.vue';
// 1. Add missing component imports
import Checkbox from '../checkbox/Checkbox.vue';
import Badge from '../badge/Badge.vue';
import { QuizQuestion } from '@/types/QuizQuestion.ts';

const props = defineProps<{
    question: QuizQuestion;
    index: number;
}>();

const emit = defineEmits<{
    'update:weight': [number];
    'update:is_bonus': [boolean];
    'update:is_optional': [boolean];
    'remove': [];
}>();
</script>

<template>
    <Card class="relative transition-all hover:border-muted-foreground/40">
        <CardContent class="p-4 space-y-3">
            <!-- Header Row -->
            <div class="flex items-start gap-3">
                <div class="drag-handle cursor-grab active:cursor-grabbing text-muted-foreground hover:text-foreground pt-1">
                    <GripVertical class="w-4 h-4" />
                </div>

                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">
                            Question {{ index + 1 }}
                        </span>
                        <Badge v-if="question.question.difficulty" variant="outline" class="text-xs">
                            {{ question.question.difficulty }}
                        </Badge>
                    </div>

                    <h4 class="font-medium text-sm sm:text-base line-clamp-2">
                        {{ question.question.title }}
                    </h4>
                </div>

                <Button variant="ghost" size="icon" class="text-muted-foreground hover:text-destructive shrink-0" @click="emit('remove')">
                    <Trash2 class="w-4 h-4" />
                </Button>
            </div>

            <hr class="border-border/60" />

            <!-- Controls Row -->
            <div class="flex flex-wrap items-center justify-between gap-4 text-sm pt-1">
                <div class="flex flex-wrap items-center gap-6">
                    <!-- Point Weight -->
                    <div class="flex items-center gap-2">
                        <Label class="text-xs text-muted-foreground">Points / Weight</Label>
                        <Input 
                            type="number" 
                            min="0" 
                            step="0.5"
                            class="w-20 h-8 text-sm" 
                            :model-value="question.weight" 
                            @update:model-value="val => emit('update:weight', Number(val))" 
                        />
                    </div>

                    <!-- Is Bonus Toggle -->
                    <div class="flex items-center gap-2">
                        <!-- 2. Added shrink-0 class to prevent shrinking -->
                        <Checkbox 
                            :id="`bonus-${question.question.id}`" 
                            :model-value="question.is_bonus"
                            class="shrink-0"
                            @update:model-value=" val => emit('update:is_bonus', val === true)"
                        />
                        <Label :for="`bonus-${question.question.id}`" class="text-xs cursor-pointer select-none">
                            Bonus
                        </Label>
                    </div>

                    <!-- Is Optional Toggle -->
                    <div class="flex items-center gap-2">
                        <Checkbox 
                            :id="`optional-${question.question.id}`" 
                            :model-value="question.is_optional"
                            class="shrink-0"
                            @update:model-value="val => emit('update:is_optional', val === true)"
                        />
                        <Label :for="`optional-${question.question.id}`" class="text-xs cursor-pointer select-none">
                            Optional
                        </Label>
                    </div>
                </div>

                <div v-if="question.is_bonus" class="text-xs text-amber-600 font-medium">
                    (Extra Credit)
                </div>
            </div>
        </CardContent>
    </Card>
</template>