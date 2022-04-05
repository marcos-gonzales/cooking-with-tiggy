<template>
    <div class="grid grid-cols-1 sm:grid-cols-2">
        <div>
            <img src="images/tiggy/tiggy2.jpeg" alt="tiggy_poncho">
        </div>
        <div class="border rounded bg-slate-100 w-full">
            <form
                class="flex flex-col  mx-auto p-4 h-52"
                @submit.prevent="login"
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

                <div class="flex flex-col p-2">
                    <label for="password" id="password">password</label>
                    <input
                        class="border rounded px-1"
                        v-model="password"
                        type="password"
                        name="name"
                        placeholder="your password"
                    />
                </div>
                <div v-if="errors.password >= 1" class="text-red-500" v-text="errors.password"></div>
                <button
                    class="border bg-blue-300 my-4 rounded mx-auto"
                    style="width: 50% !important"
                >
                    Submit
                </button>
            </form>

            <p class="text-center text-slate-300 pb-4 mt-2">
                Don't have an account?
                <Link class="text-blue-500 underline" href="/register">Register</Link>
            </p>

            <p class="text-center text-slate-300 pb-4 mt-10">
                forgot your password?
                <Link class="text-blue-500 underline" href="/forgot-password">reset password</Link>
            </p>
        </div>
    </div>
</template>

<script>
import {Head, Link} from "@inertiajs/inertia-vue3";
import {Inertia} from '@inertiajs/inertia';


export default {
    data() {
        return {
            email: this.email,
            password: this.password
        }
    },
    components: {
        Link,
        Head,
    },
    methods: {
        login() {
            Inertia.post('/login', {
                email: this.email,
                password: this.password
            });
        }
    },
    props: {
        errors: Object
    }
};
</script>

<style></style>
