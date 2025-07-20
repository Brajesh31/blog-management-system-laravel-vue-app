<script setup>
import { Button } from "@/Components/ui/button";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/Components/ui/popover"; // Correct path
import { Bell } from "lucide-vue-next";

const props = defineProps({
    notifications: { type: Array, required: true, default: () => [] },
    unreadCount: { type: Number, required: true, default: 0 },
});
const emit = defineEmits(["mark-read", "mark-all-read"]);
const handleNotificationClick = (notification) => {
    emit("mark-read", notification.id);
};
const handleMarkAllRead = () => {
    emit("mark-all-read");
};
</script>

<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button
                variant="ghost"
                size="icon"
                class="relative rounded-full"
                aria-label="Notifications"
            >
                <Bell class="h-5 w-5" />
                <span
                    v-if="unreadCount > 0"
                    class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-xs font-medium text-white"
                >
                    {{ unreadCount > 9 ? "9+" : unreadCount }}
                </span>
            </Button>
        </PopoverTrigger>
        <PopoverContent align="end" class="w-[90vw] sm:w-80 md:w-96 p-0">
            <div class="p-4 border-b">
                <h4 class="font-medium leading-none">Notifications</h4>
                <p class="text-sm text-muted-foreground mt-1">
                    You have {{ unreadCount }} unread messages.
                </p>
            </div>
            <div class="p-2 max-h-80 overflow-y-auto">
                <div
                    v-if="notifications.length === 0"
                    class="text-center text-sm text-muted-foreground py-8"
                >
                    No new notifications.
                </div>
                <div v-else>
                    <button
                        v-for="notification in notifications"
                        :key="notification.id"
                        @click="handleNotificationClick(notification)"
                        class="block w-full text-left rounded-md p-3 hover:bg-accent hover:text-accent-foreground transition-colors cursor-pointer"
                        :class="{ 'opacity-60': notification.read }"
                        type="button"
                    >
                        <div class="flex items-start space-x-3">
                            <span
                                v-if="!notification.read"
                                class="flex h-2 w-2 translate-y-1 rounded-full bg-sky-500 flex-shrink-0"
                            />
                            <span
                                v-else
                                class="flex h-2 w-2 translate-y-1 rounded-full bg-transparent flex-shrink-0"
                            />
                            <div class="flex-1 space-y-1">
                                <p class="text-sm font-medium leading-none">
                                    {{ notification.text }}
                                </p>
                                <p class="text-xs text-muted-foreground">
                                    {{ notification.time }}
                                </p>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
            <div
                v-if="notifications.length > 0"
                class="p-2 border-t flex justify-between items-center"
            >
                <Button
                    variant="link"
                    size="sm"
                    class="text-xs h-auto py-1 px-2"
                    @click="handleMarkAllRead"
                >
                    Mark all as read
                </Button>
                <Button
                    variant="ghost"
                    size="sm"
                    class="text-xs h-auto py-1 px-2"
                    disabled
                >
                    View all
                </Button>
            </div>
        </PopoverContent>
    </Popover>
</template>
