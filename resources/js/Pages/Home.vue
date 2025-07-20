<script setup lang="ts">
import CommunityJoinCard from "@/Components/home/CommunityJoinCard.vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from "@inertiajs/vue3";
import ChallengesCard from "@/Components/home/ChallengesCard.vue";
import { useAuth } from "@/hooks/useAuth";

defineOptions({ layout: MainLayout });

const { isAuthenticated } = useAuth(); // Assuming you have a useAuth composable to check authentication status
</script>

<template>
    <Head title="Home" />

    <div class="container container-lg mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <!-- left card (hidden below lg) -->
            <div class="hidden md:block md:col-span-3 lg:col-span-3">
                <template v-if="!isAuthenticated">
                    <CommunityJoinCard />
                </template>
            </div>

            <div class="col-span-1 md:col-span-8 lg:col-span-6">
                <div>
                    <h1 class="text-2xl font-bold mb-4">
                        Welcome to the Blog!
                    </h1>
                    <p>
                        Browse public posts below or create an account to start
                        sharing your thoughts.
                    </p>
                    <!-- You would typically list public posts here -->
                    <div class="mt-6">
                        <!-- Placeholder for post list -->
                        <p class="text-gray-500">
                            Public posts will appear here...
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Card (hidden below md) -->
            <div class="hidden lg:block lg:col-span-3">
                <ChallengesCard />
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Add page-specific styles if needed */
</style>
