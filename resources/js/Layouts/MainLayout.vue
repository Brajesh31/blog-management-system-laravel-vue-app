<script setup>
import LoginModal from "@/Components/auth/LoginModal.vue";
import RegistrationModal from "@/Components/auth/RegistrationModal.vue";
import MobileMenuSheet from "@/Components/layouts/main/MobileMenuSheet.vue";
import PrimaryNavbar from "@/Components/layouts/main/PrimaryNavbar.vue";
import { Sheet } from "@/Components/ui/sheet"; // <-- Import Sheet here
import { Toaster } from "@/Components/ui/sonner";
import { useAuth } from "@/hooks/useAuth";
import { Head, router } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const appName = import.meta.env.VITE_APP_NAME || "BlogApp";
const searchInput = ref("");
const showingMobileMenu = ref(false); // State for controlling the sheet

const { isAuthenticated, user } = useAuth();

const notifications = ref([
    /* ... placeholder data ... */
]);
const unreadCount = computed(
    () => notifications.value.filter((n) => !n.read).length
);

const handleSearchSubmit = (query) => {
    /* ... */
};
const handleMarkRead = (notificationId) => {
    /* ... */
};
const handleMarkAllRead = () => {
    /* ... */
};

router.on("navigate", () => {
    showingMobileMenu.value = false;
}); // Keep this to close on nav
</script>

<template>
    <Head :title="appName" />
    <div
        class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 flex flex-col"
    >
        <!-- Wrap Navbar and Sheet Content in the Sheet Root  -->
        <Sheet v-model:open="showingMobileMenu">
            <PrimaryNavbar
                :user="user"
                :isAuthenticated="isAuthenticated"
                :notifications="notifications"
                :unread-count="unreadCount"
                v-model:searchInput="searchInput"
                @search-submitted="handleSearchSubmit"
                @mark-read="handleMarkRead"
                @mark-all-read="handleMarkAllRead"
                class="flex-shrink-0"
            />

            <!-- MobileMenuSheet now only contains the SheetContent -->
            <MobileMenuSheet
                :user="user"
                :appName="appName"
                v-model:searchInput="searchInput"
                @search-submitted="handleSearchSubmit"
                @close-sheet="showingMobileMenu = false"
            />
        </Sheet>
        <!-- {/* End Sheet Root */} -->

        <header
            class="bg-white dark:bg-gray-800 shadow flex-shrink-0"
            v-if="$slots.header"
        >
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <main class="flex-grow py-8 md:py-12">
            <slot />
        </main>

        <footer
            class="text-center py-4 text-sm text-gray-500 dark:text-gray-400 border-t border-gray-200 dark:border-gray-700 mt-auto flex-shrink-0"
        >
            © {{ new Date().getFullYear() }} {{ appName }}. All rights reserved.
        </footer>
    </div>

    <template :v-if="!isAuthenticated">
        <LoginModal />
        <RegistrationModal />
    </template>
    <Toaster richColors position="bottom-right" />
</template>
