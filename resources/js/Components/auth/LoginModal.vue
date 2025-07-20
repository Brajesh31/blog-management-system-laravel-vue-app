<script setup lang="ts">
import { Button } from "@/Components/ui/button";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from "@/Components/ui/dialog";

import { Checkbox } from "@/Components/ui/checkbox";

import {
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/Components/ui/form";

import { Input } from "@/Components/ui/input";

import { toast } from "vue-sonner";
import { Loader2 } from "lucide-vue-next";

import { EModal as ModalEnum } from "@/stores/modal";
import { useForm, Link } from "@inertiajs/vue3";
import { toTypedSchema } from "@vee-validate/zod";
import { useForm as useVeeForm } from "vee-validate";
import { watch } from "vue";
import * as z from "zod";

import { useModalStore } from "@/stores/modal";

const modalStore = useModalStore();

const formSchema = toTypedSchema(
    z.object({
        email: z
            .string()
            .email({
                message: "Please enter a valid email address",
            })
            .min(1, {
                message: "Email is required",
            }),
        password: z.string().min(1, {
            message: "Password must be at least 6 characters",
        }),
        remember: z.boolean().optional(),
    })
);

//-- Inertia form handling
//this form object handles data, state(processing), errors from backend, and submission
const inertiaForm = useForm<{
    email: string;
    password: string;
    remember: boolean;
}>({
    email: "",
    password: "",
    remember: false,
});

//-- veeValidate integration (for typing schema to shadcn components)----
//We still use vee-validate's useForm to manage the schema link and setErrors

const { handleSubmit, setErrors, values, setFieldValue } = useVeeForm({
    validationSchema: formSchema,
    // Sync initial values (optional, could also sync via v-model directly)
    initialValues: {
        email: inertiaForm.email,
        password: inertiaForm.password,
        remember: inertiaForm.remember,
    },
});

// --- Sync Inertia Form state with VeeValidate State---
// This ensures v-models work correctly with both systems
watch(
    () => inertiaForm.email,
    (newValue) => setFieldValue("email", newValue)
);
watch(
    () => inertiaForm.password,
    (newValue) => setFieldValue("password", newValue)
);
watch(
    () => inertiaForm.remember,
    (newValue) => setFieldValue("remember", newValue)
);

// --- sync backend errors (from inertia) to Frontend Validation (Veevalidate) ---
//This makes Inertia's erros show up in shadcn's FormMessage
watch(
    () => inertiaForm.errors,
    (newErrors) => {
        if (newErrors) {
            setErrors(newErrors);
        }
    }
);

// --- Submission Logic ---
// We use vee-validate's handleSubmit to trigger client-side validation FIRST
// If client-side validation passes, the 'onSubmit' function is called.
const onSubmit = handleSubmit(() => {
    // Client-side validation passed, now submit using Inertia
    inertiaForm.post(route("login"), {
        //Post to the Breeze login Route
        preserveScroll: true, // Preserve scroll position

        onSuccess: () => {
            //Called AFTER Inertia Request finishes successfully (backend ok)
            modalStore.hideModal(ModalEnum.LOGIN); // Hide the modal
            //No need to reset form here usually, as page likely navigates
            toast.success("Login successful", {
                description: "You have successfully logged in.",
            });

            // redirect on the same page if the user is already logged in
        },

        onError: (errors) => {
            // Called AFTER Inertia request finishes with errors (validation/auth failure)
            // Errors are automatically populated in inertiaForm.errors
            // The watch effect above handles passing them to setErrors for display
            inertiaForm.reset("password"); // Clear password field on error
            toast.error("Login failed", {
                description:
                    errors.email ||
                    errors.password ||
                    "Check credentials and try again.",
            });
        },
        onFinish: () => {
            // Called AFTER Inertia request finishes, regardless of success/error
            // inertiaForm.processing is automatically handled
        },
    });
});

// Function to handle dialog open state changes (e.g., closing via overlay click)
function updateOpenState(open: boolean) {
    modalStore.isLoginOpen = open; // Update the modal store state
    if (!open) {
        inertiaForm.clearErrors(); // Clear errors when closing the modal
    }
}
</script>

<template>
    <Dialog
        v-model:open="modalStore.isLoginOpen"
        @update:open="updateOpenState"
    >
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>Log In</DialogTitle>
                <DialogDescription>
                    Enter your credentials to access your account.
                </DialogDescription>
            </DialogHeader>

            <form
                id="loginDialogForm"
                class="space-y-4"
                @submit.prevent="onSubmit"
            >
                <!-- Email Field -->
                <FormField name="email">
                    <FormItem>
                        <FormLabel>Email</FormLabel>
                        <FormControl>
                            <!-- v-model syncs with Inertia form state -->
                            <Input
                                type="email"
                                placeholder="you@example.com"
                                v-model="inertiaForm.email"
                                autocomplete="username"
                            />
                        </FormControl>
                        <!-- FormMessage automatically picks up errors via setErrors -->
                        <FormMessage />
                    </FormItem>
                </FormField>

                <!-- Password Field -->
                <FormField name="password">
                    <FormItem>
                        <FormLabel>Password</FormLabel>
                        <FormControl>
                            <Input
                                type="password"
                                placeholder="••••••••"
                                v-model="inertiaForm.password"
                                autocomplete="current-password"
                            />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <!-- Remember Me Field -->
                <FormField name="remember">
                    <FormItem
                        class="flex flex-row items-start space-x-3 space-y-0"
                    >
                        <FormControl class="mr-0 flex items-center leading-0">
                            <Checkbox
                                :checked="inertiaForm.remember"
                                @update:checked="
                                        (value: boolean) =>
                                            (inertiaForm.remember = !!value)
                                    "
                            />
                        </FormControl>
                        <FormLabel class="font-normal">Remember me</FormLabel>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <!-- Optional: Display general form error from backend if not field-specific -->
                <div
                    v-if="inertiaForm.errors.email"
                    class="text-sm font-medium text-destructive"
                >
                    {{ inertiaForm.errors.email }}
                </div>
                <div
                    v-if="inertiaForm.errors.password"
                    class="text-sm font-medium text-destructive"
                >
                    {{ inertiaForm.errors.password }}
                </div>
                <div
                    v-if="inertiaForm.errors.remember"
                    class="text-sm font-medium text-destructive"
                >
                    {{ inertiaForm.errors.remember }}
                </div>
            </form>

            <DialogFooter class="flex items-center">
                <Link
                    :href="route('password.request')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-hidden"
                    @click.prevent="modalStore.hideModal(ModalEnum.LOGIN)"
                >
                    Forgot your password?
                </Link>

                <!-- Link button type="submit" to the form using the form ID -->
                <!-- Disable button when Inertia form is processing -->
                <Button
                    type="submit"
                    form="loginDialogForm"
                    :disabled="inertiaForm.processing"
                >
                    <Loader2
                        v-if="inertiaForm.processing"
                        class="w-4 h-4 mr-2 animate-spin"
                    />
                    <span v-if="inertiaForm.processing">Logging In...</span>
                    <span v-else>Log In</span>
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
