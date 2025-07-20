<script setup lang="ts">
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from "@/Components/ui/card";

import { Button } from "@/Components/ui/button";
import { EModal, useModalStore } from "@/stores/modal";

import { computed } from "vue";

// --- Store ---
const modalStore = useModalStore();

// --- Props (Static count is used here,) ---
const props = defineProps({
    //you could make this dynamic if needed by fetching/passing data
    developerCount: {
        type: Number,
        default: 3009084, //Static example value
    },
});

// --- Computed ---
// Format the number with commas for display
const formattedCount = computed(() => {
    return props.developerCount.toLocaleString("en-US");
});

//-- methods to open modals---
// These functions will call the methods exposed by your Pinia store

const openRegisterModal = () => {
    //check if the method exists on the store before calling

    if (typeof modalStore.showModal === "function") {
        modalStore.showModal(EModal.REGISTER);
    } else {
        console.error("Error: modalStore.showModal() function not found");
        //Optionally show a user-facing error toast/message
    }
};

const openLoginModal = () => {
    //check if the method exists on the store before calling
    if (typeof modalStore.showModal === "function") {
        modalStore.showModal(EModal.LOGIN);
    } else {
        console.error("Error: modalStore.showModal() function not found");
        //Optionally show a user-facing error toast/message
    }
};
</script>

<template>
    <Card
        class="w-full max-w-md mx-auto rounded-sm bg-card text-card-foreground"
    >
        <CardHeader>
            <CardTitle> Join Our Developer Community </CardTitle>
            <CardDescription class="text-base pt-1 text-muted-foreground">
                <span class="font-semibold text-primary">{{
                    formattedCount
                }}</span>
                developers sharing & growing.
            </CardDescription>
        </CardHeader>

        <CardContent>
            <p class="text-sm text-muted-foreground">
                Join our community of developers and unlock a world of
                opportunities. Whether you're a seasoned pro or just starting,
                there's something for everyone. Connect, learn, and grow with
                us.
            </p>
        </CardContent>

        <CardFooter class="flex flex-col gap-3">
            <Button
                size="sm"
                variant="default"
                class="w-full"
                aria-label="Create a new account"
                @click="openRegisterModal"
            >
                Create Account
            </Button>

            <!-- Secondary Action: Log In -->
            <Button
                size="sm"
                variant="outline"
                class="w-full"
                aria-label="Log in to your account"
                @click="openLoginModal"
            >
                Log In
            </Button>
        </CardFooter>
    </Card>
</template>
