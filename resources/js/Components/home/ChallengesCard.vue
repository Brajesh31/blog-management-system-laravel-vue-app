<script setup lang="ts">
import { Card, CardContent, CardHeader } from "@/Components/ui/card";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";

import { Button } from "@/Components/ui/button";

import { MoreHorizontal } from "lucide-vue-next";

// Props for dynamic content (optional, but good practice)
const props = defineProps({
    imageUrl: {
        type: String,
        default:
            "https://images.pexels.com/photos/2386141/pexels-photo-2386141.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2",
    },
    challengeTitle: {
        type: String,
        default: "Sample Challenge Title",
    },

    challengeDescription: {
        type: String,
        default:
            "This is a sample challenge description. It can be a bit longer to give more context about the challenge.",
    },
    challengeUrl: {
        type: String,
        default: "#",
    },
});
</script>

<template>
    <Card
        class="w-full max-w-md mx-auto rounded-sm bg-card text-card-foreground"
    >
        <CardHeader
            class="flex flex-row items-center justify-between pb-2 px-4"
        >
            <span
                class="text-sm text-muted-foreground flex items-center gap-1.5"
            >
                <span class="text-base">👋</span>
                What's happening this week
            </span>

            <!-- Dropdown menu for the Ellipsis -->
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <Button variant="ghost" size="sm" class="w-8 h-8 p-0">
                        <span class="sr-only">Open Menu</span>
                        <MoreHorizontal class="h-4 w-4" />
                    </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end">
                    <!-- Add Actual actions here -->
                    <DropdownMenuItem>Follow #challenge</DropdownMenuItem>
                    <DropdownMenuItem>Hide this</DropdownMenuItem>
                    <DropdownMenuItem>Report abuse</DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </CardHeader>

        <CardContent class="px-4 pb-6">
            <h2 class="text-lg font-semibold flex items-center gap-1.5 mb-2">
                Challenges
                <span class="text-xl">🤗</span>
                <!-- Emoji -->
            </h2>

            <!-- Inner Box for "Happening Now" -->
            <div class="border rounded-lg overflow-hidden p-3">
                <h3
                    class="text-sm font-medium text-muted-foreground mb-2 flex items-center gap-1"
                >
                    Happening Now <span class="text-base">✨</span>
                    <!-- Emoji -->
                </h3>

                <a
                    :href="challengeUrl"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    <img
                        :src="imageUrl"
                        alt="`${challengeTitle} Banner`"
                        class="w-full h-auto rounded aspect-[16/8] object-cover mb-2"
                    />
                </a>

                <a
                    href="#"
                    class="text-sm text-muted-foreground hover:underline mb-0.5"
                >
                    {{ challengeTitle }}
                </a>
                <!-- Challenge Description -->
                <p class="text-sm text-muted-foreground">
                    {{ challengeDescription }}
                </p>
            </div>

            <!-- concluding phrase -->
            <p class="mt-3 text-sm font-medium flex items-center gap-1">
                Have a great week <span class="text-base">❤️</span>
                <!-- Emoji -->
            </p>
        </CardContent>
    </Card>
</template>

<style scoped>
/* Add component-specific styles here if needed */
.aspect-\[16\/8\] {
    aspect-ratio: 16 / 8;
}
</style>
