<script setup>
import { Button } from "@/Components/ui/button"; // Correct path
import { useModalStore } from "@/stores/modal"; // Correct path

const modalStore = useModalStore();
const openLogin = () => modalStore.showModal("login");
const openRegister = () => modalStore.showModal("register");
</script>

<template>
    <div>
        <Button class="mr-3" variant="ghost" @click="openLogin">
            Log in
        </Button>
        <Button variant="default" @click="openRegister">
            Create Account
        </Button>
    </div>
</template>
