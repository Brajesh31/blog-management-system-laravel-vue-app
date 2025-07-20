<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
// Correct paths for ui components and DropdownLink
import { Avatar, AvatarFallback, AvatarImage } from "@/Components/ui/avatar";
import { Button } from "@/Components/ui/button";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";
import DropdownLink from "@/Components/DropdownLink.vue"; // Correct path
import {
    BookOpen,
    LayoutDashboard,
    LogOut,
    PlusCircle,
    Settings,
} from "lucide-vue-next";

const props = defineProps({ user: { type: Object, required: true } });
const userInitials = computed(
    () =>
        props.user?.name
            ?.match(/\b(\w)/g)
            ?.join("")
            .substring(0, 2)
            .toUpperCase() || "??"
);
const profilePicUrl = computed(
    () => props.user.profile_pic || props.user.profile_photo_url || null
); // Check 'profile_pic' first as used in original
</script>

<template>
    <DropdownMenu v-if="user">
        <DropdownMenuTrigger as-child>
            <Button
                variant="ghost"
                class="flex items-center rounded-full focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 h-8 w-8 p-0"
                aria-label="User menu"
            >
                <Avatar class="h-8 w-8">
                    <AvatarImage
                        :src="profilePicUrl"
                        :alt="user.name"
                        v-if="profilePicUrl"
                    />
                    <AvatarFallback>{{ userInitials }}</AvatarFallback>
                </Avatar>
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end" class="w-56">
            <DropdownMenuLabel class="font-normal">
                <DropdownLink
                    :href="route('userprofile.show', user.username)"
                    class="flex flex-col space-y-1"
                >
                    <p class="text-sm font-medium leading-none">
                        {{ user.name }}
                    </p>
                    <p class="text-xs leading-none text-muted-foreground">
                        @{{ user.username }}
                    </p>
                </DropdownLink>
            </DropdownMenuLabel>
            <DropdownMenuSeparator />
            <DropdownMenuItem as-child>
                <Link :href="route('dashboard')">
                    <LayoutDashboard class="mr-2 h-4 w-4" />
                    <span>Dashboard</span>
                </Link>
            </DropdownMenuItem>
            <DropdownMenuItem as-child>
                <!-- NOTE: Update this route('login') placeholder -->
                <Link :href="route('post.create')">
                    <PlusCircle class="mr-2 h-4 w-4" /> <span>Create Post</span>
                </Link>
            </DropdownMenuItem>
            <DropdownMenuItem disabled>
                <BookOpen class="mr-2 h-4 w-4" /> <span>Reading List</span>
            </DropdownMenuItem>
            <DropdownMenuItem as-child>
                <!-- NOTE: Update this route('login') placeholder -->
                <Link :href="route('profile.edit')">
                    <Settings class="mr-2 h-4 w-4" /> <span>Settings</span>
                </Link>
            </DropdownMenuItem>
            <DropdownMenuSeparator />
            <DropdownMenuItem as-child>
                <DropdownLink
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="w-full flex items-center cursor-pointer"
                >
                    <LogOut class="mr-2 h-4 w-4" /> <span>Sign Out</span>
                </DropdownLink>
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
