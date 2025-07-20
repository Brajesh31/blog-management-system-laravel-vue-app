<script setup lang="ts">
import { ref } from "vue";
import type { Editor } from "@tiptap/vue-3";
import { Button } from "@/Components/ui/button";
import { Separator } from "@/Components/ui/separator";
import {
    Bold,
    Italic,
    Strikethrough,
    Code,
    Heading1,
    Heading2,
    Heading3,
    List,
    ListOrdered,
    Quote,
    Code2,
    Link as LinkIcon,
    Image as ImageIcon,
    Pilcrow,
    Undo,
    Redo,
    Minus,
} from "lucide-vue-next";

const props = defineProps<{ editor: Editor }>();

//--- Linking Handling ---

const showLinkInput = ref(false);
const linkUrl = ref("");

const setLink = () => {
    //cancelled

    if (linkUrl.value === null || linkUrl.value === "") {
        showLinkInput.value = false;
        linkUrl.value = "";
        return;
    }
    // empty
    // if (linkUrl.value === '') {
    //     props.editor.chain().focus().extendMarkRange('link').unsetLink().run();
    //      showLinkInput.value = false;
    //      linkUrl.value = '';
    //     return
    // }

    // update link
    props.editor
        .chain()
        .focus()
        .extendMarkRange("link")
        .setLink({ href: linkUrl.value })
        .run();
    showLinkInput.value = false;
    linkUrl.value = "";
};

const openLinkDialog = () => {
    linkUrl.value = props.editor.getAttributes("link").href ?? "";
    showLinkInput.value = true;

    // Consider using a Shadcn Dialog component here for better UX
};

// --- Image Handling (Basic URL Prompt) ---

const addImage = () => {
    const url = window.prompt("Enter image URL:");

    if (url) {
        props.editor.chain().focus().setImage({ src: url }).run();
    }
};
</script>

<template>
    <div
        class="toolbar flex flex-wrap items-center gap-1 p-2 border-b bg-muted/50 rounded-t-md"
    >
        <Button
            :disabled="!editor.can().chain().focus().undo().run()"
            @click="editor.chain().focus().undo().run()"
            variant="ghost"
            size="sm"
            aria-label="Undo"
        >
            <Undo class="w-4 h-4" />
        </Button>

        <Button
            :disabled="!editor.can().chain().focus().redo().run()"
            @click="editor.chain().focus().redo().run()"
            variant="ghost"
            size="sm"
            aria-label="Redo"
        >
            <Redo class="w-4 h-4" />
        </Button>

        <Separator orientation="vertical" class="h-6 mx-1" />

        <!-- Headings -->

        <Button
            @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
            :variant="
                editor.isActive('heading', { level: 1 }) ? 'secondary' : 'ghost'
            "
            size="sm"
            aria-label="Heading 1"
        >
            <Heading1 class="w-4 h-4" />
        </Button>

        <Button
            @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
            :variant="
                editor.isActive('heading', { level: 2 }) ? 'secondary' : 'ghost'
            "
            size="sm"
            aria-label="Heading 2"
        >
            <Heading2 class="w-4 h-4" />
        </Button>

        <Button
            @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
            :variant="
                editor.isActive('heading', { level: 3 }) ? 'secondary' : 'ghost'
            "
            size="sm"
            aria-label="Heading 3"
        >
            <Heading3 class="w-4 h-4" />
        </Button>

        <Button
            @click="editor.chain().focus().setParagraph().run()"
            :variant="editor.isActive('paragraph') ? 'secondary' : 'ghost'"
            size="sm"
            aria-label="Paragraph"
        >
            <Pilcrow class="h-4 w-4" />
        </Button>

        <Separator orientation="vertical" class="h-6 mx-1" />

        <!-- Basic Formatting -->

        <Button
            @click="editor.chain().focus().toggleBold().run()"
            :variant="editor.isActive('bold') ? 'secondary' : 'ghost'"
            size="sm"
            aria-label="Bold"
        >
            <Bold class="w-4 h-4" />
        </Button>

        <Button
            @click="editor.chain().focus().toggleItalic().run()"
            :variant="editor.isActive('italic') ? 'secondary' : 'ghost'"
            size="sm"
            aria-label="Italic"
        >
            <Italic class="h-4 w-4" />
        </Button>

        <Button
            @click="editor.chain().focus().toggleStrike().run()"
            :variant="editor.isActive('strike') ? 'secondary' : 'ghost'"
            size="sm"
            aria-label="Strikethrough"
        >
            <Strikethrough class="h-4 w-4" />
        </Button>

        <Button
            @click="editor.chain().focus().toggleCode().run()"
            :variant="editor.isActive('code') ? 'secondary' : 'ghost'"
            size="sm"
            aria-label="Inline Code"
        >
            <Code class="h-4 w-4" />
        </Button>

        <Separator orientation="vertical" class="h-6 mx-1" />

        <!-- Lists -->
        <Button
            @click="editor.chain().focus().toggleBulletList().run()"
            :variant="editor.isActive('bulletList') ? 'secondary' : 'ghost'"
            size="sm"
            aria-label="Bullet List"
        >
            <List class="h-4 w-4" />
        </Button>
        <Button
            @click="editor.chain().focus().toggleOrderedList().run()"
            :variant="editor.isActive('orderedList') ? 'secondary' : 'ghost'"
            size="sm"
            aria-label="Numbered List"
        >
            <ListOrdered class="h-4 w-4" />
        </Button>

        <Separator orientation="vertical" class="h-6 mx-1" />

        <!-- Blocks -->
        <Button
            @click="editor.chain().focus().toggleBlockquote().run()"
            :variant="editor.isActive('blockquote') ? 'secondary' : 'ghost'"
            size="sm"
            aria-label="Blockquote"
        >
            <Quote class="h-4 w-4" />
        </Button>

        <Button
            @click="editor.chain().focus().toggleCodeBlock().run()"
            :variant="editor.isActive('codeBlock') ? 'secondary' : 'ghost'"
            size="sm"
            aria-label="Code Block"
        >
            <Code2 class="h-4 w-4" />
        </Button>

        <Button
            @click="editor.chain().focus().setHorizontalRule().run()"
            variant="ghost"
            size="sm"
            aria-label="Horizontal Rule"
        >
            <Minus class="h-4 w-4" />
        </Button>

        <Separator orientation="vertical" class="h-6 mx-1" />

        <!-- Link & Image -->
        <!-- Basic Link Input (Consider using a Shadcn Dialog for better UX) -->

        <div class="flex items-center gap-1">
            <Button
                @click="openLinkDialog"
                :variant="editor.isActive('link') ? 'secondary' : 'ghost'"
                size="sm"
                aria-label="Add/Edit Link"
            >
                <LinkIcon class="h-4 w-4" />
            </Button>

            <template v-if="showLinkInput">
                <input
                    type="url"
                    v-model="linkUrl"
                    placeholder="https://example.com"
                    class="p-1 border rounded text-xs bg-background h-8 focus:outline-none focus:ring-1 focus:ring-ring"
                />
                <Button @click="setLink" size="sm" variant="secondary">
                    Set
                </Button>
                <Button
                    @click="
                        showLinkInput = false;
                        linkUrl = '';
                    "
                    size="sm"
                    variant="ghost"
                >
                    X
                </Button>
            </template>
            <Button
                @click="addImage"
                variant="ghost"
                size="sm"
                aria-label="Add Image via URL"
            >
                <ImageIcon class="h-4 w-4" />
            </Button>
        </div>
    </div>
</template>
