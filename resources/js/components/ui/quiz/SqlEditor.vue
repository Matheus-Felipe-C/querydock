    <script setup lang="ts">
import { onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { EditorState } from '@codemirror/state';
import { basicSetup, EditorView } from 'codemirror';
import { sql } from '@codemirror/lang-sql';

const props = withDefaults(
    defineProps<{
        placeholder?: string;
        minHeight?: string;
        readOnly?: boolean;
    }>(),
    {
        placeholder: '',
        minHeight: '160px',
        readOnly: false,
    }
)

const model = defineModel<string>({ default: '' });

const editorContainer = ref<HTMLDivElement | null>(null);

let editor: EditorView | null = null;

onMounted(() => {
    const extensions = [
        basicSetup,
        sql(),
        EditorView.lineWrapping,
    ];

    if (props.readOnly) {
        extensions.push(
            EditorState.readOnly.of(true),
            EditorView.editable.of(false),
        );
    } else {
        extensions.push(
            EditorView.updateListener.of((update) => {
                if (update.docChanged) {
                    model.value = update.state.doc.toString();
                }
            })
        );
    }
    editor = new EditorView({
        state: EditorState.create({
            doc: model.value,
            extensions: extensions,
        }),
        parent: editorContainer.value!,
    });
});

// Watch for Dataset changes to update the text context
watch(() => model.value, (newVal) => {
    if (editor && newVal !== editor.state.doc.toString()) {
        editor.dispatch({
            changes: { from: 0, to: editor.state.doc.length, insert: newVal}
        });
    }
});

onBeforeUnmount(() => {
    editor?.destroy();
})
</script>

<template>
    <div 
        ref="editorContainer" 
        class="w-full max-w-full min-h-40 rounded-md border bg-background overflow-hidden"
        :class="{ 'opacity-85 bg-muted/30 cursor-not-allowed': props.readOnly }"
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

/* Hides the flashing text caret cursor when in read-only mode */
.cm-readonly .cm-cursor {
    display: none !important;
}
</style>