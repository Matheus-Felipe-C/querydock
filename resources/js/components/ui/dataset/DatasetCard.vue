<script setup lang="ts">
import { Dataset } from '@/types/dataset';
import Card from '../card/Card.vue';
import CardHeader from '../card/CardHeader.vue';
import CardTitle from '../card/CardTitle.vue';
import { EllipsisVerticalIcon } from '@lucide/vue';
import DropdownMenu from '../dropdown-menu/DropdownMenu.vue';
import DropdownMenuTrigger from '../dropdown-menu/DropdownMenuTrigger.vue';
import Button from '../button/Button.vue';
import DropdownMenuItem from '../dropdown-menu/DropdownMenuItem.vue';
import DropdownMenuContent from '../dropdown-menu/DropdownMenuContent.vue';
import CardContent from '../card/CardContent.vue';
import CardFooter from '../card/CardFooter.vue';
import { computed } from 'vue';
import SqlEditor from '../quiz/SqlEditor.vue';
import { Link, router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import AlertDialog from '../alert-dialog/AlertDialog.vue';
import AlertDialogTrigger from '../alert-dialog/AlertDialogTrigger.vue';
import AlertDialogHeader from '../alert-dialog/AlertDialogHeader.vue';
import AlertDialogContent from '../alert-dialog/AlertDialogContent.vue';
import AlertDialogTitle from '../alert-dialog/AlertDialogTitle.vue';
import AlertDialogDescription from '../alert-dialog/AlertDialogDescription.vue';
import AlertDialogFooter from '../alert-dialog/AlertDialogFooter.vue';
import AlertDialogCancel from '../alert-dialog/AlertDialogCancel.vue';
import AlertDialogAction from '../alert-dialog/AlertDialogAction.vue';

const props = defineProps<{
    dataset: Dataset;
    courseId: number;
}>();

const sqlPreview = computed(() => {
    const lines = props.dataset.sql_script.split('\n');
    if (lines.length > 5) {
        return lines.slice(0, 5).join('\n') + '\n...';
    }

    return props.dataset.sql_script;
})

function deleteDataset() {
    router.delete(
        route('courses.datasets.destroy', {
            course: props.courseId,
            dataset: props.dataset,
        })
    )
}

</script>

<template>
    <Card>
        <CardHeader>
            <div class="flex justify-between">
                <CardTitle>{{ dataset.name }}</CardTitle>

                <AlertDialog>
                    <DropdownMenu>
                        <DropdownMenuTrigger as-child>
                            <Button variant="ghost">
                                <EllipsisVerticalIcon class="w-4 h-4" />
                            </Button>
                        </DropdownMenuTrigger>

                        <DropdownMenuContent align="end">
                            <DropdownMenuItem as-child>
                                <Link :href="route('courses.datasets.edit', {
                                    course: courseId,
                                    dataset: dataset,
                                })">
                                    Edit Dataset
                                </Link>
                            </DropdownMenuItem>

                            <AlertDialogTrigger as-child>
                                <DropdownMenuItem
                                    class="text-destructive data-highlighted:bg-destructive/10 data-highlighted:text-destructive"
                                    @select.prevent>
                                    Delete Dataset
                                </DropdownMenuItem>
                            </AlertDialogTrigger>
                        </DropdownMenuContent>
                    </DropdownMenu>

                    <AlertDialogContent>
                        <AlertDialogHeader>
                            <AlertDialogTitle>
                                Delete Dataset?
                            </AlertDialogTitle>

                            <AlertDialogDescription>
                                This action cannot be undone.
                                The dataset "{{ dataset.name }}" will be permanently deleted.
                            </AlertDialogDescription>
                        </AlertDialogHeader>

                        <AlertDialogFooter>
                            <AlertDialogCancel>
                                Cancel
                            </AlertDialogCancel>

                            <AlertDialogAction class="bg-red-600 hover:bg-red-700" @click="deleteDataset">
                                Delete
                            </AlertDialogAction>
                        </AlertDialogFooter>
                    </AlertDialogContent>
                </AlertDialog>
            </div>
        </CardHeader>

        <CardContent>
            <div class="grid gap-2">
                <p class="text-sm text-muted-foreground">
                    {{ dataset.description }}
                </p>
                <SqlEditor :model-value="sqlPreview" read-only min-height="120px" class="text-sm font-mono" />
            </div>
        </CardContent>

        <CardFooter class="border-t flex items-start justify-between gap-2 bg-muted/20 rounded-b-xl">
            <div class="flex items-center justify-between gap-6">
                <div class="flex flex-col gap-1">
                    <p class="text-xs text-muted-foreground">USAGE</p>
                    <p class="text-sm">42 Qs</p>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex flex-col gap-1">
                        <p class="text-xs text-muted-foreground">MODIFIED</p>
                        <p class="text-sm">2d ago</p>
                    </div>
                </div>
            </div>
        </CardFooter>
    </Card>
</template>