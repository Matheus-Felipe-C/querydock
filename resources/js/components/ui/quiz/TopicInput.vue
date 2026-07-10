<script setup lang="ts">
import Label from '../label/Label.vue';
import TagsInput from '../tags-input/TagsInput.vue';
import TagsInputItem from '../tags-input/TagsInputItem.vue';
import TagsInputItemText from '../tags-input/TagsInputItemText.vue';
import TagsInputItemDelete from '../tags-input/TagsInputItemDelete.vue';
import TagsInputInput from '../tags-input/TagsInputInput.vue';

const topics = defineModel<string[]>({
    required: true,
});

withDefaults(
    defineProps<{
        label?: string,
        placeholder?: string,
    }>(),
    {
        label: "Topics",
        placeholder: "Type a topic and press enter",
    }
);
</script>

<template>
    <div class="grid gap-2">
        <Label>{{ label }}</Label>

        <TagsInput v-model="topics">
            <TagsInputItem v-for="item in topics" :key="item" :value="item">
                <TagsInputItemText />
                <TagsInputItemDelete />
            </TagsInputItem>

            <TagsInputInput :placeholder="placeholder" />
        </TagsInput>
    </div>
</template>