<script setup>
import { Link } from "@inertiajs/vue3";
import SearchBar from "./SearchBar.vue";
import { Button } from "@/Components/ui/button";
// Remove Sheet import, only need SheetContent and others
import { SheetContent, SheetHeader, SheetTitle } from "@/Components/ui/sheet";
import DropdownLink from "@/Components/DropdownLink.vue";
import {
    Home,
    LayoutDashboard,
    PlusCircle,
    BookOpen,
    Settings,
    User,
    LogOut,
} from "lucide-vue-next";

const props = defineProps({
    user: Object,
    searchInput: String,
    appName: { type: String, default: "App" },
    // No longer need modelValue for open state
});

// Add emit for closing the sheet explicitly when needed (e.g., clicking links)
const emit = defineEmits([
    "update:searchInput",
    "search-submitted",
    "close-sheet",
]);

const closeSheet = () => {
    emit("close-sheet"); // Emit event for parent (GuestLayout) to handle
};

const handleSearchUpdate = (value) => {
    emit("update:searchInput", value);
};
const handleSearchSubmit = (value) => {
    emit("search-submitted", value);
    closeSheet(); // Close sheet after search submit
};
</script>

<template>
    <!-- Remove the <Sheet> wrapper  -->
    <SheetContent side="left" class="w-[280px] sm:w-[320px] flex flex-col p-0">
        <SheetHeader class="p-4 border-b">
            <SheetTitle as-child>
                <Link
                    :href="route('home')"
                    class="flex items-center gap-2"
                    @click="closeSheet"
                >
                    <img
                        class="h-6 w-auto"
                        src="/images/blogx-logo.png"
                        alt="Logo"
                    />
                </Link>
            </SheetTitle>
        </SheetHeader>

        <!-- {/* Scrollable Content Area */} -->
        <div class="flex-grow overflow-y-auto p-4 space-y-2">
            <!-- Use @click="closeSheet" on links/buttons that should close the menu -->
            <Button
                variant="ghost"
                class="w-full justify-start"
                as-child
                @click="closeSheet"
            >
                <Link :href="route('home')">
                    <Home class="mr-2 h-4 w-4" /> Home
                </Link>
            </Button>
            <template v-if="user">
                <Button
                    variant="ghost"
                    class="w-full justify-start"
                    as-child
                    @click="closeSheet"
                >
                    <Link :href="route('dashboard')">
                        <LayoutDashboard class="mr-2 h-4 w-4" /> Dashboard
                    </Link>
                </Button>
                <Button
                    variant="ghost"
                    class="w-full justify-start"
                    as-child
                    @click="closeSheet"
                >
                    <Link :href="route('login')">
                        <PlusCircle class="mr-2 h-4 w-4" /> Create Post
                    </Link>
                </Button>
                <Button variant="ghost" class="w-full justify-start" disabled>
                    <BookOpen class="mr-2 h-4 w-4" /> Reading List
                </Button>
                <Button
                    variant="ghost"
                    class="w-full justify-start"
                    as-child
                    @click="closeSheet"
                >
                    <Link :href="route('login')">
                        <Settings class="mr-2 h-4 w-4" /> Settings
                    </Link>
                </Button>
            </template>
            <template v-else>
                <Button
                    variant="ghost"
                    class="w-full justify-start"
                    as-child
                    @click="closeSheet"
                >
                    <Link :href="route('login')">
                        <User class="mr-2 h-4 w-4" /> Log In
                    </Link>
                </Button>
            </template>
        </div>

        <!-- Sticky Footer Area -->
        <div class="mt-auto border-t p-4 space-y-4">
            <SearchBar
                :modelValue="searchInput"
                @update:modelValue="handleSearchUpdate"
                @submit="handleSearchSubmit"
                placeholder="Search..."
            />
            <template v-if="user">
                <DropdownLink
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="w-full justify-start text-red-600 hover:text-red-700 dark:text-red-500 dark:hover:text-red-400 flex items-center px-2 py-1.5 rounded-md hover:bg-accent"
                    @click="closeSheet"
                >
                    <LogOut class="mr-2 h-4 w-4" /> Sign Out
                </DropdownLink>
            </template>
            <template v-else>
                <Button
                    variant="default"
                    class="w-full justify-center"
                    as-child
                    @click="closeSheet"
                >
                    <Link :href="route('register')"> Create Account </Link>
                </Button>
            </template>
        </div>
    </SheetContent>
    <!-- End remove the <Sheet> wrapper  -->
</template>
