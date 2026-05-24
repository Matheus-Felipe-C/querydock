<script setup lang="ts">
import { Eye, LayersPlus, Pencil } from 'lucide-vue-next';
import Card from '../card/Card.vue';
import CardContent from '../card/CardContent.vue';
import CardFooter from '../card/CardFooter.vue';
import CardHeader from '../card/CardHeader.vue';
import CardTitle from '../card/CardTitle.vue';
import Button from '../button/Button.vue';
import Badge from '../badge/Badge.vue';
import { Question } from '@/types/question';

defineProps<{
    question: Question
}>();

</script>

<template>
    <Card>
        <!-- Question header -->
        <CardHeader>
            <div class="flex justify-between">
                <CardTitle>{{ question.title }}</CardTitle>
                <Badge class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-2 py-1">MEDIUM</Badge>
            </div>
            <!-- Question tags -->
            <div class="flex flex-wrap gap-2">
                <Badge variant="secondary" v-for="tag in question.tags">{{ tag }}</Badge>
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
                    <Eye class="w-8 h-8 px-1 hover:bg-gray-200" />
                    <Pencil class="w-8 h-8 px-1 hover:bg-gray-200" />
                    <Button><LayersPlus/>Add</Button>
                </div>
            </div>
        </CardFooter>
    </Card>
</template>