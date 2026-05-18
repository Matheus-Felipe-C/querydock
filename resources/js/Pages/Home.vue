<script setup lang="ts">
import { useId } from 'vue'
import { Button } from '@/components/ui/button';
import Card from '@/components/ui/card/Card.vue';
import CardHeader from '@/components/ui/card/CardHeader.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import Label from '@/components/ui/label/Label.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import { Input } from '@/components/ui/input';
import QuestionCard from '@/components/ui/quiz/QuestionCard.vue';
import AppLayout from '@/components/layout/AppLayout.vue';

defineOptions({
  layout: AppLayout,
})

const quizTitleId = useId();
const timeLimitId = useId();
const instructionsId = useId();
</script>

<template>
    <div class="w-full max-w-3xl mx-auto flex flex-col gap-6 py-6">
      <!-- Heading section-->
      <div class="flex items-start justify-between">
        <div>
          <h1 class="text-3xl font-bold">Quiz Builder</h1>
          <p class="text-sm text-muted-foreground">
            Configure quiz details and define SQL evaluation logic
          </p>
        </div>
        <div class="flex items-center gap-2">
          <Button variant="outline">Save Draft</Button>
          <Button variant="default">Save & Publish</Button>
        </div>
      </div>
      <Card>
        <CardHeader>
          <CardTitle>Quiz Configuration</CardTitle>
        </CardHeader>
        <CardContent class="space-y-6">

          <!-- Quiz title + Time limit -->
          <div class=" grid grid-cols-3 gap-4">
            <div class="col-span-2 space-y-2">
              <Label :for="quizTitleId">
                Quiz Title <span class="text-destructive">*</span>
              </Label>
              <Input :id="quizTitleId" placeholder="e.g., Midterms: Advanced Joins & Subqueries" required />
            </div>
            <div class="space-y-2">
              <Label :for="timeLimitId">Time Limit (Minutes)</Label>
              <Input :id="timeLimitId" type="number" placeholder="Optional" />
            </div>
          </div>

          <!-- Instructions -->
          <div class="space-y-2">
            <Label :for="instructionsId">
              Instructions <span class="text-muted-foreground text-sm font-normal">(Markdown supported)</span>
            </Label>
            <Textarea :id="instructionsId" placeholder="provide context or rules for this assessment..."
              class="resize-none min-h-20"></Textarea>
          </div>
        </CardContent>
      </Card>

      <QuestionCard></QuestionCard>
    </div>
</template>