<script setup lang="ts">
import GuestLayout from "@/Layouts/MainLayout.vue";
import { usePage, Link } from "@inertiajs/vue3";
import { computed } from "vue";
import { Avatar, AvatarFallback, AvatarImage } from "@/Components/ui/avatar"; // Shadcn Avatar
import { Card, CardContent, CardHeader, CardTitle } from "@/Components/ui/card"; // Shadcn Card

//define the structure of the user data coming
interface IProfileUserData {
    id: string | number;
    name: string;
    username: string;
    profile_pic: string;
    join_date: string;
    created_at: string;
}
// Define the props received from the Inertia controller response
const props = defineProps<{ profileUser: IProfileUserData }>();

//Access the authenticated user (if needed, e.g., to show an 'edit Profile' button)
const authUser = computed(() => usePage().props.auth.user);

const getInitials = (name: string): string => {
    return name
        .split(" ")
        .map((n) => n[0])
        .slice(0, 2) // Max 2 initials
        .join("")
        .toUpperCase();
};
</script>

<template>
    <GuestLayout>
        <div class="container mx-auto px-4 py-8 md:py-12 max-w-3xl">
            <Card
                class="overflow-hidden shadow-lg bg-card text-card-foreground border"
            >
                <!-- Optional Banner Area -->
                <div
                    class="h-32 bg-gradient-to-r from-purple-400 via-pink-500 to-red-500"
                ></div>

                <CardHeader class="relative border-b pb-4 -mt-16">
                    <div class="flex items-end space-x-4">
                        <!-- Avatar -->
                        <Avatar
                            class="h-24 w-24 border-4 border-background rounded-full -mt-4 bg-muted"
                        >
                            <!-- Use the URL from the accessor -->
                            <!-- <AvatarImage
                                :src="profileUser.profile_pic"
                                :alt="profileUser.name"
                            /> -->
                            <AvatarFallback class="text-xl font-semibold">
                                {{ getInitials(profileUser.name) }}
                            </AvatarFallback>
                        </Avatar>

                        <!-- Basic Info -->
                        <div class="pt-16">
                            <CardTitle class="text-2xl font-bold">
                                {{ profileUser.name }}
                            </CardTitle>
                            <p class="text-muted-foreground">
                                @{{ profileUser.username }}
                            </p>
                        </div>
                    </div>
                </CardHeader>

                <CardContent class="p-6 space-y-4">
                    <!-- Join Date -->
                    <div
                        class="flex items-center space-x-2 text-muted-foreground"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                            />
                        </svg>
                        <span>Joined on {{ profileUser.join_date }}</span>
                    </div>

                    <!-- Placeholder for Bio -->
                    <!-- <div
                        v-if="profileUser.bio"
                        class="prose prose-sm dark:prose-invert max-w-none"
                    > -->
                    <!-- <p>{{ profileUser.bio }}</p> -->
                    <!-- Add 'bio' field if you implement it -->
                    <!-- </div> -->
                    <!-- <div v-else class="text-muted-foreground italic">
                        No bio provided yet.
                    </div> -->

                    <!-- Placeholder for other info (Location, Website, etc.) -->
                    <!-- ... -->

                    <!-- Placeholder for Edit Button (if viewing own profile) -->
                    <div
                        v-if="authUser && authUser.id === profileUser.id"
                        class="pt-4"
                    >
                        <Link
                            :href="route('profile.edit')"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                        >
                            Edit Profile
                        </Link>
                    </div>
                </CardContent>
            </Card>

            <!-- Placeholder for User's Posts/Content -->
            <div class="mt-8">
                <h2 class="text-xl font-semibold mb-4">
                    Posts by {{ profileUser.name }}
                </h2>
                <div
                    class="p-6 bg-card rounded-lg border text-muted-foreground"
                >
                    User's posts will appear here...
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
