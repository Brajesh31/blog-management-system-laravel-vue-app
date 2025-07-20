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

import {
    FormControl,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from "@/Components/ui/form";

import { Input } from "@/Components/ui/input";

import { toast } from "vue-sonner";

import { EModal as ModalEnum } from "@/stores/modal";
import { useForm } from "@inertiajs/vue3";
import { toTypedSchema } from "@vee-validate/zod";
import { useForm as useVeeForm } from "vee-validate";
import { watch } from "vue";
import * as z from "zod";

import { useModalStore } from "@/stores/modal";
import { Loader2 } from "lucide-vue-next";

const modalStore = useModalStore();

const formSchema = toTypedSchema(
    z
        .object({
            name: z.string().min(1, {
                message: "Name is required",
            }),
            username: z.string().min(1, {
                message: "Username is required",
            }),
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
            password_confirmation: z.string().min(1, {
                message: "Password confirmation is required",
            }),
        })
        .refine(
            (data) => {
                return data.password === data.password_confirmation;
            },
            {
                message: "Passwords do not match",
                path: ["password_confirmation"],
            }
        )
);

//-- Inertia form handling
//this form object handles data, state(processing), errors from backend, and submission
const inertiaForm = useForm<{
    name: string;
    username: string;
    email: string;
    password: string;
    password_confirmation: string;
}>({
    name: "",
    username: "",
    email: "",
    password: "",
    password_confirmation: "",
});

//-- veeValidate integration (for typing schema to shadcn components)----
//We still use vee-validate's useForm to manage the schema link and setErrors

const { handleSubmit, setErrors, values, setFieldValue } = useVeeForm({
    validationSchema: formSchema,
    // Sync initial values (optional, could also sync via v-model directly)
    initialValues: {
        name: inertiaForm.name,
        username: inertiaForm.username,
        email: inertiaForm.email,
        password: inertiaForm.password,
        password_confirmation: inertiaForm.password_confirmation,
    },
});

// --- Sync Inertia Form state with VeeValidate State---
// This ensures v-models work correctly with both systems
watch(
    () => inertiaForm.name,
    (newValue) => setFieldValue("name", newValue)
);
watch(
    () => inertiaForm.username,
    (newValue) => setFieldValue("username", newValue)
);
watch(
    () => inertiaForm.email,
    (newValue) => setFieldValue("email", newValue)
);
watch(
    () => inertiaForm.password,
    (newValue) => setFieldValue("password", newValue)
);
watch(
    () => inertiaForm.password_confirmation,
    (newValue) => setFieldValue("password_confirmation", newValue)
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
    inertiaForm.post(route("register"), {
        //Post to the Breeze login Route
        preserveScroll: true, // Preserve scroll position

        onSuccess: () => {
            //Called AFTER Inertia Request finishes successfully (backend ok)
            modalStore.hideModal(ModalEnum.REGISTER); // Hide the modal
            //No need to reset form here usually, as page likely navigates
            toast.success("Registration successful", {
                description: "You have successfully registered.",
                duration: 2000,
            });
        },

        onError: (errors) => {
            // Called AFTER Inertia request finishes with errors (validation/auth failure)
            // Errors are automatically populated in inertiaForm.errors
            // The watch effect above handles passing them to setErrors for display
            inertiaForm.reset("password", "password_confirmation");
            toast.error("Registration Failed", {
                description:
                    errors.email ||
                    errors.password ||
                    errors.password_confirmation ||
                    errors.username ||
                    errors.name ||
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
    modalStore.isRegisterOpen = open; // Update the modal store state
    if (!open) {
        inertiaForm.clearErrors(); // Clear errors when closing the modal
    }
}
</script>

<template>
    <Dialog
        v-model:open="modalStore.isRegisterOpen"
        @update:open="updateOpenState"
    >
        <DialogContent class="sm:max-w-[425px]">
            <DialogHeader>
                <DialogTitle>Create Account</DialogTitle>
                <DialogDescription>
                    Enter your details below to create a new account.
                </DialogDescription>
            </DialogHeader>

            <form
                id="registerDialogForm"
                class="space-y-4"
                @submit.prevent="onSubmit"
            >
                <!-- Name Field -->
                <FormField name="name">
                    <FormItem>
                        <FormLabel>Name</FormLabel>
                        <FormControl>
                            <!-- v-model syncs with Inertia form state -->
                            <Input
                                type="text"
                                placeholder="John Doe"
                                v-model="inertiaForm.name"
                                autocomplete="username"
                            />
                        </FormControl>
                        <!-- FormMessage automatically picks up errors via setErrors -->
                        <FormMessage />
                    </FormItem>
                </FormField>

                <!-- username Field -->
                <FormField name="username">
                    <FormItem>
                        <FormLabel>Username</FormLabel>
                        <FormControl>
                            <!-- v-model syncs with Inertia form state -->
                            <Input
                                type="text"
                                placeholder="johndoe"
                                v-model="inertiaForm.username"
                                autocomplete="username"
                            />
                        </FormControl>
                        <!-- FormMessage automatically picks up errors via setErrors -->
                        <FormMessage />
                    </FormItem>
                </FormField>

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

                <!-- Password Confirmation Field -->
                <FormField name="password_confirmation">
                    <FormItem>
                        <FormLabel>Password Confirmation</FormLabel>
                        <FormControl>
                            <Input
                                type="password"
                                placeholder="••••••••"
                                v-model="inertiaForm.password_confirmation"
                                autocomplete="current-password"
                            />
                        </FormControl>
                        <FormMessage />
                    </FormItem>
                </FormField>

                <!-- Optional: Display general form error from backend if not field-specific -->
                <div
                    v-if="inertiaForm.errors.name"
                    class="text-sm font-medium text-destructive"
                >
                    {{ inertiaForm.errors.name }}
                </div>

                <div
                    v-if="inertiaForm.errors.username"
                    class="text-sm font-medium text-destructive"
                >
                    {{ inertiaForm.errors.username }}
                </div>

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
                    v-if="inertiaForm.errors.password_confirmation"
                    class="text-sm font-medium text-destructive"
                >
                    {{ inertiaForm.errors.password_confirmation }}
                </div>
            </form>

            <DialogFooter class="flex items-center">
                <Button
                    variant="link"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-hidden cursor-pointer"
                    @click.prevent="
                        modalStore.hideModal(ModalEnum.REGISTER);
                        modalStore.showModal(ModalEnum.LOGIN);
                    "
                >
                    Already registered?
                </Button>
                <!-- Link button type="submit" to the form using the form ID -->
                <!-- Disable button when Inertia form is processing -->
                <Button
                    type="submit"
                    form="registerDialogForm"
                    :disabled="inertiaForm.processing"
                >
                    <Loader2
                        v-if="inertiaForm.processing"
                        class="w-4 h-4 mr-2 animate-spin"
                    />
                    <span v-if="inertiaForm.processing">
                        Creating Account...
                    </span>
                    <span v-else>Create Account</span>
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
