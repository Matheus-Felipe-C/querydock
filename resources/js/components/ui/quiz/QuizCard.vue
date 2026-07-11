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
    <Card class="flex flex-col h-full justify-between">
        <CardHeader class="flex flex-row items-start justify-between gap-4">
            <div class="flex flex-col gap-2 min-w-0">
                <div class="flex">
                    <Badge class="bg-blue-100 text-blue-700 hover:bg-blue-200 px-2 py-1">Published</Badge>
                </div>
                <CardTitle class="text-lg font-bold leading-tight break-words">Midterm: Advanced Joins</CardTitle>
            </div>

            <div class="shrink-0">
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Button variant="ghost">
                            <EllipsisVertical />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent class="w-56" align="end">
                        <DropdownMenuItem>Edit quiz</DropdownMenuItem>
                        <DropdownMenuItem class="text-destructive data-highlighted:bg-destructive/10 data-highlighted:text-destructive">Delete quiz</DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </CardHeader>

        <CardContent>
            <div class="grid grid-cols-2 gap-x-2 gap-y-3 sm:gap-4 text-sm">
                <p class="font-medium text-muted-foreground flex gap-2 items-center min-w-0 truncate">
                    <List class="w-4 h-4 text-foreground shrink-0" /> 
                    <span>15 Questions</span>
                </p>
                <p class="font-medium text-muted-foreground flex gap-2 items-center min-w-0 truncate">
                    <Clock class="w-4 h-4 text-foreground shrink-0" />                    
                    <span>45 mins</span>
                </p>
                <p class="font-medium text-muted-foreground flex gap-2 items-center min-w-0 truncate">
                    <User class="w-4 h-4 text-foreground shrink-0" />
                    <span>128 students</span>
                </p>
                <p class="font-medium text-muted-foreground flex gap-2 items-center min-w-0 truncate">
                    <Star class="w-4 h-4 text-foreground shrink-0" />
                    <span>82% Avg</span>
                </p>
            </div>
        </CardContent>

        <CardFooter class="flex flex-wrap gap-3 justify-between items-center pt-0">
            <p class="text-muted-foreground italic text-xs">Edited 2 hours ago</p>
            <div class="flex items-center gap-1">
                <Button variant="ghost" size="sm">Preview</Button>
                <Button size="sm">Results</Button>
            </div>
        </CardFooter>
    </Card>
</template>