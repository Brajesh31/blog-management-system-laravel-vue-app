<script setup>
import { Link } from "@inertiajs/vue3";
// Correct paths for local layout components relative to PrimaryNavbar.vue
import SearchBar from "./SearchBar.vue";
import NotificationPopover from "./NotificationPopover.vue";
import UserDropdownMenu from "./UserDropdownMenu.vue";
import GuestAuthButtons from "./GuestAuthButtons.vue";
// Correct paths for ui components from their respective folders
import { Button } from "@/Components/ui/button";
import { SheetTrigger } from "@/Components/ui/sheet"; // Important: For mobile menu button
import { Menu, PlusCircle } from "lucide-vue-next"; // Import necessary icons

// Define props received from GuestLayout
const props = defineProps({
    user: Object, // Can be null if not logged in
    notifications: Array,
    unreadCount: Number,
    searchInput: String, // For v-model binding with SearchBar
});

// Define events emitted back up to GuestLayout
const emit = defineEmits([
    "update:searchInput", // For v-model on search
    "search-submitted",
    "mark-read",
    "mark-all-read",
    // 'open-mobile-menu' // No longer needed as SheetTrigger handles it
]);

// --- Event Handlers to relay events from child components ---
const handleSearchUpdate = (value) => {
    emit("update:searchInput", value);
};

const handleSearchSubmit = (value) => {
    emit("search-submitted", value);
};

const handleMarkRead = (id) => {
    emit("mark-read", id);
};

const handleMarkAllRead = () => {
    emit("mark-all-read");
};
</script>

<template>
    <!-- Sticky Navbar Structure -->
    <nav
        class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky top-0 z-40"
    >
        <!-- z-40 to be above content but potentially below modals  -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- {/* Left Side: Logo */} -->
                <div class="shrink-0 flex items-center">
                    <Link :href="route('home')">
                        <img
                            class="h-7 w-auto block"
                            src="/images/blogx-logo.png"
                            alt="Logo"
                        />
                        <!-- Ensure image path is correct  -->
                    </Link>
                </div>

                <!-- Center: Desktop Search Bar  -->
                <div
                    class="hidden sm:flex sm:items-center sm:justify-center flex-grow px-6"
                >
                    <SearchBar
                        :modelValue="searchInput"
                        @update:modelValue="handleSearchUpdate"
                        @submit="handleSearchSubmit"
                        placeholder="Search posts..."
                        wrapperClass="relative w-full max-w-md lg:max-w-lg"
                    />
                </div>

                <!-- Right Side: Desktop Links & Actions -->
                <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                    <!-- Show Guest buttons if user is not logged in -->
                    <template v-if="!user">
                        <GuestAuthButtons />
                    </template>
                    <!-- Show Authenticated user actions if logged in -->
                    <template v-else>
                        <!-- Create Post Button -->
                        <Button variant="default" size="sm" as-child>
                            <!-- {/* --- TODO: Update this route placeholder --- */} -->
                            <Link :href="route('post.create')">
                                <PlusCircle class="h-4 w-4 mr-2" /> Create Post
                            </Link>
                        </Button>
                        <!-- Notification Popover Component  -->
                        <NotificationPopover
                            :notifications="notifications"
                            :unread-count="unreadCount"
                            @mark-read="handleMarkRead"
                            @mark-all-read="handleMarkAllRead"
                        />
                        <!-- User Dropdown Menu Component  -->
                        <UserDropdownMenu :user="user" />
                    </template>
                </div>

                <!-- Right Side: Mobile Header Items (Notification + Hamburger) -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <!-- Mobile Notification Popover (only shown if user is logged in)  -->
                    <NotificationPopover
                        v-if="user"
                        :notifications="notifications"
                        :unread-count="unreadCount"
                        @mark-read="handleMarkRead"
                        @mark-all-read="handleMarkAllRead"
                        class="mr-2"
                    />
                    <!-- Hamburger Button (Sheet Trigger) -->
                    <!-- This SheetTrigger finds the <Sheet> context provided by GuestLayout  -->
                    <SheetTrigger as-child>
                        <Button
                            variant="ghost"
                            size="icon"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400"
                            aria-label="Open main menu"
                        >
                            <Menu class="h-6 w-6" />
                        </Button>
                    </SheetTrigger>
                </div>
            </div>
        </div>
    </nav>
</template>
