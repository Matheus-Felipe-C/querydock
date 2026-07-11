    <script setup lang="ts">
import { onBeforeUnmount, onMounted, ref } from 'vue';
import { EditorState } from '@codemirror/state';
import { basicSetup, EditorView } from 'codemirror';
import { sql } from '@codemirror/lang-sql';

const props = withDefaults(
    defineProps<{
        placeholder?: string;
        minHeight?: string;
    }>(),
    {
        placeholder: '',
        minHeight: '160px',
    }
)

const model = defineModel<string>({ default: '' });

const editorContainer = ref<HTMLDivElement | null>(null);

let editor: EditorView | null = null;

onMounted(() => {
    editor = new EditorView({
        state: EditorState.create({
            doc: model.value,
            extensions: [
                basicSetup,
                sql(),
                EditorView.lineWrapping,
                EditorView.updateListener.of((update) => {
                    if (update.docChanged) {
                        model.value = update.state.doc.toString()
                    };
                }),
            ],
        }),
        parent: editorContainer.value!
    })
})

onBeforeUnmount(() => {
    editor?.destroy();
})
</script>

<template>
    <div 
        ref="editorContainer" 
        class="w-full max-w-full min-h-40 rounded-md border bg-background overflow-hidden"
        :style="{ minHeight: props.minHeight }"
    />
</template>

<style>
/* Forces internal CodeMirror container to be within boundaries for mobile responsivity */

.cm-editor {
    width: 100% !important;
    max-width: 100% !important;
}

.cm-scroller {
    overflow-x: auto;
}
</style>