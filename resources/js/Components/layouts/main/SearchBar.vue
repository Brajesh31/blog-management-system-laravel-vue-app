<script setup>
import { ref, watch } from "vue";
// Correct paths for ui components based on your structure
import { Button } from "@/Components/ui/button";
import { Input } from "@/Components/ui/input";
import { Search } from "lucide-vue-next";

const props = defineProps({
    modelValue: { type: String, default: "" },
    placeholder: { type: String, default: "Search..." },
    wrapperClass: { type: String, default: "relative w-full" },
});
const emit = defineEmits(["update:modelValue", "submit"]);
const internalValue = ref(props.modelValue);
watch(
    () => props.modelValue,
    (newValue) => {
        internalValue.value = newValue;
    }
);
watch(internalValue, (newValue) => {
    emit("update:modelValue", newValue);
});
const handleSubmit = () => {
    emit("submit", internalValue.value);
};
</script>

<template>
    <form @submit.prevent="handleSubmit" :class="wrapperClass">
        <Input
            type="search"
            :placeholder="placeholder"
            class="pr-10 w-full"
            v-model="internalValue"
        />
        <Button
            type="submit"
            variant="ghost"
            size="icon"
            class="absolute right-1 top-1/2 -translate-y-1/2 h-8 w-8"
            aria-label="Search"
        >
            <Search class="h-4 w-4 text-gray-500 dark:text-gray-400" />
        </Button>
    </form>
</template>
