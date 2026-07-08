<script setup lang="ts">
import { ref } from 'vue';
import Label from '../label/Label.vue';
import { XCircle } from 'lucide-vue-next';
import Input from '../input/Input.vue';

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

const topicInput = ref("");

function addTopic() {
    const value = topicInput.value
        .trim()
        .replace(/\s+/g, " ")
        .toLowerCase();

    if (!value) return;

    if (!topics.value.includes(value)) {
        topics.value.push(value);
    }

    topicInput.value = "";
}

function removeTopic(topic: string) {
    topics.value = topics.value.filter(t => t !== topic);
}
</script>

<template>
    <div class="grid gap-2">
        <Label>{{ label }}</Label>

        <div
            v-if="topics.length"
            class="flex flex-wrap gap-2"
        >
            <div
                v-for="topic in topics"
                :key="topic"
                class="bg-secondary text-secondary-foreground flex items-center gap-1 rounded-md px-2"
            >
                {{ topic }}

                <button
                    type="button"
                    @click="removeTopic(topic)"
                >
                    <XCircle class="h-3 w-3" />
                </button>
            </div>
        </div>

        <Input
            v-model="topicInput"
            :placeholder="placeholder"
            @keydown.enter.prevent="addTopic"
        />
    </div>
</template>