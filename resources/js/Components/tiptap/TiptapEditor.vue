<script setup lang="ts">
import { watch } from "vue";
import { useEditor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import Placeholder from "@tiptap/extension-placeholder";
import Link from "@tiptap/extension-link";
import Image from "@tiptap/extension-image"; // Basic image support
import TiptapToolbar from "./TiptapToolbar.vue";

const props = defineProps({
    modelValue: {
        type: String,
        default: "",
    },

    placeholder: {
        type: String,
        default: "Write something...",
    },

    hasError: {
        //To style the border on Error
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(["update:modelValue"]);

const editor = useEditor({
    content: props.modelValue,
    extensions: [
        StarterKit.configure({
            heading: {
                levels: [1, 2, 3], // Configure heading levels
            },
        }),

        // Disable extensions you don't need from StarterKit
        // e.g., horizontalRule: false,

        Placeholder.configure({
            placeholder: props.placeholder,
        }),

        Link.configure({
            openOnClick: false, // Don't open links on click in the editor
            autolink: true, // Autolink URLs
            linkOnPaste: true, // Link URLs pasted
        }),

        Image.configure({
            inline: false, // Allow images to be block elements
            // Note: Default image handling inserts via src.
            // For uploads, you'll need a custom node or upload handling logic.
        }),
    ],

    // Triggered whenever the editor content changes
    onUpdate: ({ editor }) => {
        // Emit the latest HTML content to the parent component
        emit("update:modelValue", editor.getHTML());
    },

    // Apply ProseMirror editor styles
    editorProps: {
        attributes: {
            class: "prose dark:prose-invert prose-sm sm:prose-base lg:prose-lg xl:prose-xl focus:outline-none px-3 py-2 min-h-[250px] max-w-full",
        },
    },
});

// Watch for external changes to modelValue and update the editor
// Important if the parent component resets the form data
watch(
    () => props.modelValue,
    (newValue) => {
        if (editor.value && editor.value.getHTML() !== newValue) {
            editor.value.commands.setContent(newValue, false); // Update content without emitting back
        }
    }
);

// Expose editor instance if needed by parent (optional)
// defineExpose({ editor });
</script>

<template>
    <div
        class="tiptap-wrapper border rounded-sm bg-background focus-within:right-1 focus-within:ring-ring"
        :class="{
            'border-destructive ring-destructive focus-within:ring-destructive':
                hasError,
            'border-primary': !hasError,
        }"
    >
        <!-- Pass the editor instance to the Toolbar -->
        <TiptapToolbar v-if="editor" :editor="editor" />

        <!-- Renders the actual editor content area -->
        <EditorContent :editor="editor" />
    </div>
</template>

<style>
/* Basic Tiptap styling adjustments */
.tiptap-wrapper {
    /* Inherit Shadcn variables where possible */
    color: hsl(var(--foreground));
}
.ProseMirror {
    /* Ensure it expands */
    width: 100%;
    min-height: 250px; /* Or inherit from options */
}

.ProseMirror p.is-editor-empty:first-child::before {
    /* Placeholder styles */
    content: attr(data-placeholder);
    float: left;
    color: hsl(var(--muted-foreground));
    pointer-events: none;
    height: 0;
}

/* Add styles for focus, links, code blocks etc. as needed */
.ProseMirror-focused {
    outline: none; /* Remove default outline, rely on wrapper ring */
}

.ProseMirror a {
    color: hsl(var(--primary));
    text-decoration: underline;
    cursor: pointer;
}

/* Style the image node */
.ProseMirror img {
    max-width: 100%;
    height: auto;
    display: block; /* Or inline based on configuration */
    margin-top: 0.5rem;
    margin-bottom: 0.5rem;
    border-radius: var(--radius);
}
.ProseMirror img.ProseMirror-selectednode {
    outline: 3px solid hsl(var(--primary) / 0.5);
}
</style>
