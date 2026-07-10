<script setup lang="ts">
import Card from '../card/Card.vue';
import CardHeader from '../card/CardHeader.vue';
import Badge from '../badge/Badge.vue';
import CardTitle from '../card/CardTitle.vue';
import { Clock, EllipsisVertical, List, Star, User } from 'lucide-vue-next';
import DropdownMenu from '../dropdown-menu/DropdownMenu.vue';
import DropdownMenuTrigger from '../dropdown-menu/DropdownMenuTrigger.vue';
import DropdownMenuContent from '../dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '../dropdown-menu/DropdownMenuItem.vue';
import CardContent from '../card/CardContent.vue';
import CardFooter from '../card/CardFooter.vue';
import Button from '../button/Button.vue';

// const props = defineProps<{
//     course: Course;
//     quiz: Quiz;
// }>();

</script>

<template>
    <Card>
        <CardHeader class="flex justify-between gap-4">
            <div class="flex flex-col gap-2">
                <Badge class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-2 py-1">Published</Badge>
                <CardTitle>Midterm: Advanced Joins</CardTitle>
            </div>

            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <Button variant="ghost">
                        <EllipsisVertical />
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent class="w-56" align="start">
                    <DropdownMenuItem>Edit quiz</DropdownMenuItem>
                    <DropdownMenuItem class="text-destructive data-highlighted:bg-destructive/10 data-highlighted:text-destructive">Delete quiz</DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </CardHeader>
        <CardContent>
            <div class="grid grid-cols-2 gap-4">
                <p class="font-bold flex gap-2 items-center">
                    <List class="w-4 h-4" /> 
                    15 Questions
                </p>
                <p class="font-bold flex gap-2 items-center">
                    <Clock class="w-4 h-4" />                    
                    45 mins
                </p>
                <p class="font-bold flex gap-2 items-center">
                    <User class="w-4 h-4" />
                    128 students
                </p>
                <p class="font-bold flex gap-2 items-center">
                    <Star class="w-4 h-4" />
                    82% Avg
                </p>
            </div>
        </CardContent>
        <CardFooter class="flex justify-between items-center">
            <p class="text-muted-foreground italic text-sm">Edited 2 hours ago</p>
            <div>
                <Button variant="ghost">Preview</Button>
                <Button>Results</Button>
            </div>
        </CardFooter>
    </Card>
</template>