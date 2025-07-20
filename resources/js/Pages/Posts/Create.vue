<script setup lang="ts">
import { onBeforeUnmount, onMounted, ref } from "vue";
import Button from "@/Components/ui/button/Button.vue";
import Card from "@/Components/ui/card/Card.vue";
import CardContent from "@/Components/ui/card/CardContent.vue";
import CardDescription from "@/Components/ui/card/CardDescription.vue";
import CardHeader from "@/Components/ui/card/CardHeader.vue";
import CardTitle from "@/Components/ui/card/CardTitle.vue";

import Label from "@/components/ui/label/Label.vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { toast } from "vue-sonner";
import { AlertCircle, Save, Send, XCircle } from "lucide-vue-next";
import TiptapEditor from "@/Components/tiptap/TiptapEditor.vue";
import Alert from "@/Components/ui/alert/Alert.vue";
import AlertTitle from "@/Components/ui/alert/AlertTitle.vue";
import AlertDescription from "@/Components/ui/alert/AlertDescription.vue";
import CardFooter from "@/Components/ui/card/CardFooter.vue";
import { Input } from "@/Components/ui/input";

// --- Types ---
interface IPostFormData {
    title: string;
    content: string; // Will store HTML from Tiptap
    image: File | null;
    visibility: "draft" | "published" | null; // Add visibility field
    [key: string]: string | File | "draft" | "published" | null; // Ensure compatibility
}

// --- Refs & State ---
const imageInputRef = ref<HTMLInputElement | null>(null);
const imagePreviewUrl = ref<string | null>(null);
const isSubmittingDraft = ref(false); // Track if the form is being submitted as a draft
const isSubmittingPublished = ref(false); // Track if the form is being submitted as published

const MAX_SIZE_MB = 2;
const ALLOWED_TYPES = [
    "image/jpeg",
    "image/png",
    "image/gif",
    "image/jpg",
    "image/webp",
];

// --- Inertia Form ---

const inertiaForm = useForm<IPostFormData>({
    title: "",
    content: "<p></p>", // Initialize empty, Tiptap will update via v-model
    image: null,
    visibility: null, // Will be set before submission
});

// --- Image Handling --- (Keep existing functions: triggerImageInput, handleImageChange, removeImage)
const triggerImageInput = () => {
    if (imageInputRef.value) {
        imageInputRef.value.click();
    } else {
        console.error("imageInputRef is not properly initialized!");
    }
};

const handleImageChange = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.[0] || null;

    if (!file) {
        removeImage(); // Clear if selection was cancelled
        return;
    }
    // Validate file type
    if (!ALLOWED_TYPES.includes(file.type)) {
        toast.error("Invalid file type.", {
            description:
                "Only JPEG, PNG, GIF, JPG, and WEBP formats are allowed.",
        });
        return;
    }

    // Validate file size
    if (file.size > MAX_SIZE_MB * 1024 * 1024) {
        toast.error(`File size exceeds ${MAX_SIZE_MB}MB.`, {
            description: "Please select a smaller image.",
        });
        return;
    }

    inertiaForm.image = file;

    if (imagePreviewUrl.value) {
        URL.revokeObjectURL(imagePreviewUrl.value);
    }

    imagePreviewUrl.value = URL.createObjectURL(file); // Create new URL for preview
};

const removeImage = () => {
    inertiaForm.image = null;
    if (imagePreviewUrl.value) URL.revokeObjectURL(imagePreviewUrl.value);
    imagePreviewUrl.value = null;
    if (imageInputRef.value) imageInputRef.value.value = ""; // Reset input
};

// --- Form Validation ---
const validateform = (forVisiblity: "draft" | "published"): boolean => {
    let isValid = true;
    inertiaForm.clearErrors(); // Clear previous errors

    // Title is always required (even for draft)
    if (!inertiaForm.title.trim()) {
        inertiaForm.setError("title", "Title is required.");
        isValid = false;
    }

    // Content is required for publishing

    const isEmptyContent =
        !inertiaForm.content.trim() || inertiaForm.content === "<p></p>";

    if (forVisiblity === "published" && isEmptyContent) {
        inertiaForm.setError(
            "content",
            "Post content cannot be empty to publish."
        );
        isValid = false;
    }

    // Show generic error if invalid but specific field errors not set
    if (!isValid) {
        toast.error("Validation Error", {
            description: "Please check the form for errors.",
        });
    }
    return isValid;
};

// --- Form Submission ---
const submitPost = (visibility: "draft" | "published") => {
    // Set visibility just before submitting
    inertiaForm.visibility = visibility;

    // Basic Validation check befor sending

    if (!validateform(visibility)) {
        return; // Stop submission if validation fails
    }

    //set processing state based on which button was clicked
    if (visibility === "draft") {
        isSubmittingDraft.value = true;
        isSubmittingPublished.value = false;
    } else {
        isSubmittingDraft.value = false;
        isSubmittingPublished.value = true;
    }

    inertiaForm.post(route("post.store"), {
        onSuccess: () => {
            const successMessage =
                visibility === "draft"
                    ? "Post saved as draft successfully."
                    : "Post published successfully.";

            toast.success("Success!", {
                description: "Post created successfully.",
            });
            inertiaForm.reset(); // Resets title, content, image
            removeImage(); // Explicitly clear preview/input just in case reset doesn't fully clear File object state

            // Tiptap content will clear due to v-model and reset
            inertiaForm.defaults(); // Reset form to initial default state after success
            inertiaForm.clearErrors(); // Clear any potential stale errors
        },
        onError: (errors) => {
            console.error("Post creation/save error:", errors);
            // Inertia usually sets errors on the form object, which are displayed automatically.
            // We can add a generic toast for visibility.
            toast.error("Submission Error", {
                description: "Please check the form fields for errors.",
            });
        },

        onFinish: () => {
            // Reset processing states regardless of success or error
            isSubmittingDraft.value = false;
            isSubmittingPublished.value = false;
        },
    });
};

// --- Handle Unload/Navigation ---
const handleBeforeUnload = (event: BeforeUnloadEvent) => {
    // Check if the form has been modified and is not currently submitting
    if (inertiaForm.isDirty && !inertiaForm.processing) {
        // Standard way to trigger the browser's "unsaved changes" dialog
        event.preventDefault();
        // Most modern browsers ignore the custom message and show a generic one.
        event.returnValue =
            "You have unsaved changes. Are you sure you want to leave?";
    }
    // If form is not dirty or is processing, do nothing, allow navigation/closing
};

// --- Lifecycle ---
onMounted(() => {
    window.addEventListener("beforeunload", handleBeforeUnload);
});

// --- Lifecycle ---
onBeforeUnmount(() => {
    // Clean up object URL
    if (imagePreviewUrl.value) URL.revokeObjectURL(imagePreviewUrl.value);
    // Clean up event listener
    window.removeEventListener("beforeunload", handleBeforeUnload);
});
</script>

<template>
    <MainLayout>
        <Head title="Create New Post" />

        <div class="container mx-auto px-4 py-8 md:py-12 max-w-4xl">
            <Card>
                <CardHeader>
                    <CardTitle class="text-2xl font-bold"
                        >Create New Post</CardTitle
                    >
                    <CardDescription
                        >Share your knowledge and thoughts with the
                        community.</CardDescription
                    >
                </CardHeader>

                <form>
                    <CardContent class="space-y-6">
                        <!-- Image Upload Section -->
                        <div class="space-y-6">
                            <Label for="post-image-button"
                                >Cover Image (Optional)</Label
                            >

                            <Button
                                type="button"
                                variant="outline"
                                @click="triggerImageInput"
                                id="post-image-button"
                                class="w-full sm:w-auto flex-shrink-0"
                            >
                                {{
                                    inertiaForm.image
                                        ? "Change Image"
                                        : "Upload Image"
                                }}
                            </Button>
                            <!-- <Input
                                type="file"
                                accept="image/jpeg, image/png, image/gif, image/webp, image/jpg"
                                class="hidden"
                                ref="imageInputRef"
                                @change="handleImageChange"
                            /> -->

                            <input
                                type="file"
                                accept="image/jpeg, image/png, image/gif, image/webp, image/jpg"
                                class="hidden"
                                ref="imageInputRef"
                                @change="handleImageChange"
                            />

                            <!-- ****** END OF FIX ****** -->
                            <p
                                class="text-sm text-muted-foreground mt-2 sm:mt-0"
                            >
                                Max {{ MAX_SIZE_MB }}MB. JPG, PNG, GIF, WEBP
                                allowed.
                            </p>

                            <div
                                v-if="imagePreviewUrl"
                                class="mt-4 relative border rounded-md overflow-hidden"
                            >
                                <img
                                    :src="imagePreviewUrl"
                                    alt="Image Preview"
                                    class="max-h-60 w-auto object-contain mx-auto"
                                />
                                <Button
                                    type="button"
                                    variant="destructive"
                                    size="icon"
                                    @click="removeImage"
                                    class="absolute top-2 right-2 h-7 w-7 rounded-full opacity-80 hover:opacity-100"
                                    aria-label="Remove image"
                                >
                                    <XCircle class="h-4 w-4" />
                                </Button>
                            </div>
                            <p
                                v-if="inertiaForm.errors.image"
                                class="text-sm font-medium text-destructive"
                            >
                                {{ inertiaForm.errors.image }}
                            </p>
                        </div>

                        <!-- Title Input -->
                        <div class="space-y-2">
                            <Label for="post-title"
                                >Post Title
                                <span class="text-red-500">*</span></Label
                            >
                            <Input
                                id="post-title"
                                type="text"
                                placeholder="Your Awesome Post Title"
                                v-model="inertiaForm.title"
                                :aria-invalid="!!inertiaForm.errors.title"
                                aria-describedby="title-error"
                                required
                            />
                            <p
                                v-if="inertiaForm.errors.title"
                                id="title-error"
                                class="text-sm font-medium text-destructive"
                            >
                                {{ inertiaForm.errors.title }}
                            </p>
                        </div>

                        <!-- Tiptap Editor for Content -->
                        <div class="space-y-2">
                            <Label for="post-content">
                                Content
                                <span class="text-red-500">*</span>
                                <!-- Add tooltip or similar if needed -->
                            </Label>
                            <!-- Use the TiptapEditor component -->
                            <!-- v-model syncs inertiaForm.content with the editor's output -->
                            <TiptapEditor
                                id="post-content"
                                v-model="inertiaForm.content"
                                :has-error="!!inertiaForm.errors.content"
                                aria-describedby="content-error"
                                placeholder="Write your post here using markdown or the toolbar..."
                            />
                            <p
                                v-if="inertiaForm.errors.content"
                                id="content-error"
                                class="text-sm font-medium text-destructive"
                            >
                                {{ inertiaForm.errors.content }}
                            </p>
                        </div>

                        <!-- General Form Errors -->
                        <Alert
                            v-if="
                                inertiaForm.hasErrors &&
                                !inertiaForm.errors.title &&
                                !inertiaForm.errors.content &&
                                !inertiaForm.errors.image
                            "
                            variant="destructive"
                            class="mt-4"
                        >
                            <AlertCircle class="h-4 w-4" />
                            <!-- Optional: Add an icon -->
                            <AlertTitle>Error</AlertTitle>
                            <AlertDescription>
                                <!-- Display the first non-field-specific error -->
                                {{
                                    Object.values(inertiaForm.errors).find(
                                        (error, key) =>
                                            ![
                                                "title",
                                                "content",
                                                "image",
                                            ].includes(key.toString())
                                    ) ||
                                    "An unexpected error occurred. Please check your input."
                                }}
                            </AlertDescription>
                        </Alert>
                    </CardContent>

                    <CardFooter
                        class="flex flex-col sm:flex-row justify-end gap-3 pt-6"
                    >
                        <!-- Save Draft Button -->
                        <Button
                            type="button"
                            variant="outline"
                            @click="submitPost('draft')"
                            :disabled="
                                inertiaForm.processing || !inertiaForm.isDirty
                            "
                        >
                            <Save class="mr-2 h-4 w-4" />
                            <span v-if="isSubmittingDraft">
                                Saving Draft...
                            </span>
                            <span v-else>Save Draft</span>
                        </Button>

                        <!-- Publish Button -->
                        <Button
                            type="button"
                            @click="submitPost('published')"
                            :disabled="inertiaForm.processing"
                        >
                            <Send class="mr-2 h-4 w-4" />
                            <span v-if="isSubmittingPublished">
                                Publishing...
                            </span>
                            <span v-else>Publish Post</span>
                        </Button>
                    </CardFooter>
                </form>
            </Card>
        </div>
    </MainLayout>
</template>
