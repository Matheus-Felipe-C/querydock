<script setup lang="ts">
import Card from '../card/Card.vue';
import CardHeader from '../card/CardHeader.vue';
import CardTitle from '../card/CardTitle.vue';
import { Clock, EllipsisVertical, List, User } from 'lucide-vue-next';
import DropdownMenu from '../dropdown-menu/DropdownMenu.vue';
import DropdownMenuTrigger from '../dropdown-menu/DropdownMenuTrigger.vue';
import DropdownMenuContent from '../dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '../dropdown-menu/DropdownMenuItem.vue';
import CardContent from '../card/CardContent.vue';
import CardFooter from '../card/CardFooter.vue';
import Button from '../button/Button.vue';

const props = defineProps<{
    title: string,
    questionCount: number,
    timeLimit: number,
}>();

</script>

<template>
    <Card class="flex flex-col h-full justify-between">
        <CardHeader class="flex flex-row items-start justify-between gap-4">
            <div class="flex flex-col gap-2 min-w-0">
                <CardTitle class="text-lg font-bold leading-tight wrap-break-word">{{ title }}</CardTitle>
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
                    <span>{{ props.questionCount }} Questions</span>
                </p>
                <p class="font-medium text-muted-foreground flex gap-2 items-center min-w-0 truncate">
                    <Clock class="w-4 h-4 text-foreground shrink-0" />                    
                    <span>{{ props.timeLimit }} mins</span>
                </p>
                <p class="font-medium text-muted-foreground flex gap-2 items-center min-w-0 truncate">
                    <User class="w-4 h-4 text-foreground shrink-0" />
                    <span>128 students</span>
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