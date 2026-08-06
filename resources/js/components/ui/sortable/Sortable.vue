<script setup lang="ts" generic="T">
import SortableJS from "sortablejs";
import {
    onMounted,
    onBeforeUnmount,
    useTemplateRef,
} from "vue";

interface Props<T> {
    modelValue: T[];
    itemKey: (item: T) => string | number;

    animation?: number;
    group?: string | SortableJS.GroupOptions;
    handle?: string;
    filter?: string;
    disabled?: boolean;
    ghostClass?: string;
    chosenClass?: string;
    dragClass?: string;
    tag?: string;
}

const props = withDefaults(defineProps<Props<T>>(), {
    animation: 150,
    tag: "div",
});

const emit = defineEmits<{
    "update:modelValue": [T[]];
    start: [evt: SortableJS.SortableEvent];
    end: [evt: SortableJS.SortableEvent];
    add: [evt: SortableJS.SortableEvent];
    remove: [evt: SortableJS.SortableEvent];
    update: [evt: SortableJS.SortableEvent];
    sort: [evt: SortableJS.SortableEvent];
}>();

const container = useTemplateRef<HTMLElement>("container");

let sortable: SortableJS | null = null;

onMounted(() => {
    sortable = SortableJS.create(container.value!, {
        animation: props.animation,
        group: props.group,
        handle: props.handle,
        filter: props.filter,
        disabled: props.disabled,
        ghostClass: props.ghostClass,
        chosenClass: props.chosenClass,
        dragClass: props.dragClass,

        onStart(evt) {
            emit("start", evt);
        },

        onAdd(evt) {
            emit("add", evt);
        },

        onRemove(evt) {
            emit("remove", evt);
        },

        onUpdate(evt) {
            if (
                evt.oldIndex == null ||
                evt.newIndex == null ||
                evt.oldIndex === evt.newIndex
            ) {
                return;
            }

            const list = [...props.modelValue];

            const [item] = list.splice(evt.oldIndex, 1);
            list.splice(evt.newIndex, 0, item);

            emit("update:modelValue", list);
            emit("update", evt);
        },

        onSort(evt) {
            emit("sort", evt);
        },

        onEnd(evt) {
            emit("end", evt);
        },
    });
});

onBeforeUnmount(() => {
    sortable?.destroy();
});

defineExpose({
    get sortable() {
        return sortable;
    },
});
</script>

<template>
    <component
        :is="tag"
        ref="container"
    >
        <template
            v-for="(item, index) in modelValue"
            :key="itemKey(item)"
        >
            <slot
                name="item"
                :element="item"
                :index="index"
            />
        </template>
    </component>
</template>