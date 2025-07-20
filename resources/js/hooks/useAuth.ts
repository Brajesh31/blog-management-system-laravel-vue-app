import { computed, ref, watch } from "vue";
import { usePage } from "@inertiajs/vue3";

export const useAuth = () => {
    const page = usePage();
    const user = ref(page.props.auth?.user);

    // Watch for changes in authentication state
    watch(
        () => page.props.auth?.user,
        (newUser) => {
            user.value = newUser;
        }
    );

    const isAuthenticated = computed(() => !!user.value);

    return { user, isAuthenticated };
};
