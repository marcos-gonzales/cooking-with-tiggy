<template>
    <div class="border rounded bg-slate-100 w-full">
        <h2 class="text-center text-amber-300">If we find an account with your email we'll send you a reset password link</h2>
        <small class="text-blue-300 text-center block mt-2">The link will expire in 30 minutes... better get to
            it..<i class="fa-solid fa-truck-fast"></i></small>
        <form
            class="flex flex-col  mx-auto p-4 h-52"
            @submit.prevent="resetPassword"
        >
            <div class="flex flex-col p-2 h-72">
                <label for="email" id="email">Email</label>
                <input
                    class="border rounded px-1"
                    v-model="email"
                    type="text"
                    name="name"
                    placeholder="youremail@example.org"
                />
            </div>
            <div v-if="errors.email" class="text-red-500" v-text="errors.email"></div>
            <button
                class="border bg-blue-300 my-4 rounded mx-auto"
            >
                Submit
            </button>
        </form>
    </div>
</template>
<script>
import {Inertia} from '@inertiajs/inertia';

export default {
    data() {
        return {
            email: ''
        }
    },
    methods: {
        resetPassword() {
            Inertia.post(`/forgot-password`, {
                email: this.email
            });
        }
    },
    props: {
        errors: Object
    }
}
</script>
