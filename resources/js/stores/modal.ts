import { defineStore } from "pinia";

// define the modal state interface for type safety
interface IAuthModalState {
    isLoginOpen: boolean;
    isRegisterOpen: boolean;
}

export enum EModal {
    LOGIN = "login",
    REGISTER = "register",
}

type TModal = EModal.LOGIN | EModal.REGISTER;

export const useModalStore = defineStore("modal", {
    state: (): IAuthModalState => ({
        isLoginOpen: false,
        isRegisterOpen: false,
    }),

    actions: {
        showModal(modal: TModal) {
            this.isLoginOpen = modal === "login";
            this.isRegisterOpen = modal === "register";
        },

        hideModal(modal: TModal) {
            if (modal === EModal.LOGIN) {
                this.isLoginOpen = false;
            }

            if (modal === EModal.REGISTER) {
                this.isRegisterOpen = false;
            }
        },

        closeAllModals() {
            this.isLoginOpen = false;
            this.isRegisterOpen = false;
        },
    },
});
