<template>
    <div class="border rounded bg-slate-100 w-full">
        <h2 class="text-center text-amber-300">Reset Password</h2>
        <small class="text-blue-300 text-center block mt-2">The link will expire in 30 minutes... better get to
            it..<i class="fa-solid fa-truck-fast"></i></small>
        <form
            class="flex flex-col  mx-auto p-4 h-52"
            @submit.prevent="resetPassword(token)"
        >
            <div class="flex flex-col p-2 h-72">
                <label for="password" id="password">Password</label>
                <input
                    class="border rounded px-1"
                    v-model="password"
                    type="password"
                    name="password"
                    placeholder="youremail@example.org"
                />
            </div>
            <div v-if="errors.password" class="text-red-500" v-text="errors.password"></div>
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
            password: ''
        }
    },
    methods: {
        resetPassword(token) {
            Inertia.post(`/forgot-password/${token}`, {
                password: this.password
            })
        }
    },
    props: {
        errors: Object,
        token: Object
    }
}
</script>
