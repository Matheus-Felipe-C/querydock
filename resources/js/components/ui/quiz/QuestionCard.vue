<script setup lang="ts">
import { ChevronUp, Copy, GripVertical, Trash } from 'lucide-vue-next';
import Card from '../card/Card.vue';
import Button from '../button/Button.vue';
import Label from '../label/Label.vue';
import Input from '../input/Input.vue';
import { useId } from 'vue';
import CardContent from '../card/CardContent.vue';
import AddNewItem from './AddNewItem.vue';

const promptId = useId();
const gradeWeightId = useId();
</script>

<template>
    <Card>
        <!-- Question header -->
        <div class="flex items-center justify-between px-4 border-b">
            <div class="flex items-center gap-2">
                <GripVertical class="w-4 h-4 text-muted-foreground cursor-grab"></GripVertical>
                <span class="text-xs font-semibold tracking-widest uppercase text-muted-foreground">
                    Question 1
                </span>
            </div>
            <div class="flex items-center gap-1">
                <Button variant="ghost" size="icon">
                    <Copy class="w-4 h-4"></Copy>
                </Button>
                <Button variant="ghost" size="icon">
                    <Trash class="w-4 h-4"></Trash>
                </Button>
                <Button variant="ghost" size="icon">
                    <ChevronUp class="w-4 h-4"></ChevronUp>
                </Button>
            </div>
        </div>

        <CardContent>

            <!-- Prompt + Grade Weight-->
            <div class="grid grid-cols-4 gap-4 py-4">
                <div class="col-span-3 space-y-2">
                    <Label :for="promptId">Prompt / Scenario</Label>
                    <Input :id="promptId"
                        placeholder="Retrieve the names of all employees who have a salary greater than 5000" />
                </div>
                <div class="space-y-2">
                    <Label :for="gradeWeightId">Grade Weight (Pts)</Label>
                    <Input :id="gradeWeightId" type="number" placeholder="10" />
                </div>
            </div>

            <!-- Schema setup -->
            <div class="space-y-2 mb-6">
                <div class="flex items-center justify-between">
                    <Label class="flex items-center gap-2">
                        <span>Schema Setup (DDL/DML)</span>
                    </Label>
                    <span class="text-xs text-muted-foreground uppercase tracking-widest">PostgreSQL</span>
                </div>
                <div class="rounded-md bg-[#1e2433] text-sm font-mono text-blue-300 p-4 min-h-32">
                    <!-- Replace this div with a CodeMirror/Monaco instance -->
                    <p class="text-muted-foreground text-xs">Code editor goes here</p>
                </div>
            </div>

            <!-- Expected solution -->
            <div class="space-y-2">
                <Label>Expected solution</Label>
                <div class="rounded-md bg-[#1e2433] text-sm font-mono text-blue-300 p-4 min-h-32">
                    <!-- Replace with CodeMirror later -->
                    <p class="textm-muted-foreground text-xs">Code editor goes here</p>
                </div>
            </div>
        </CardContent>
    </Card>
    <AddNewItem label="Add new question"></AddNewItem>
</template>