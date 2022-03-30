<template>
    <head>
        <title>Register</title>
        <meta name="register" content="register to start cooking new and exiting recipes"/>
    </head>

    <div class="border rounded bg-slate-100 max-w-lg mx-auto mt-4">
        <h1 class="text-center text-xl text-amber-400">Register for an account</h1>

        <form class="flex flex-col my-4" @submit.prevent="register">
            <div class="flex flex-col p-2">
                <label class="pl-2" for="name" id="name">Name</label>
                <input class="border rounded pl-2 ml-2" v-model="name" type="text" name="name"
                       placeholder="please enter your full name">
            </div>

            <div class="flex flex-col p-2">
                <label class="pl-2" for="email" id="email">Email</label>
                <input class="border rounded pl-2 ml-2" v-model="email" type="text" name="email"
                       placeholder="youremail@example.org">
            </div>

            <div class="flex flex-col p-2">
                <label class="pl-2" for="file_path" id="file_path">Image Upload</label>
                <input class="border rounded pl-2 ml-2" type="file" name="file_path" @change="fileUpload">
            </div>

            <div class="flex flex-col p-2">
                <label class="pl-2" for="password" id="password">password</label>
                <input class="border rounded pl-2 ml-2" v-model="password" type="password" name="name"
                       placeholder="your password">
            </div>


            <button class="border bg-blue-300 my-4 rounded mx-auto"
                    style="width: 50% !important">Submit
            </button>

            <p class="text-center text-slate-300 pb-4 mt-2">
                Already have an account?
                <Link class="text-blue-500 underline" href="/login">Login</Link>
            </p>
        </form>
    </div>
</template>

<script>
import {Inertia} from '@inertiajs/inertia';
import {Link} from '@inertiajs/inertia-vue3';

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            file_path: ''
        }
    },
    methods: {
        register() {
            Inertia.post('/register', {
                name: this.name,
                email: this.email,
                password: this.password,
                file_path: this.file_path
            }, {
                forceFormData: true
            })
        },
        fileUpload(e) {
            this.file_path = e.target.files[0];
        }

    },
    props: {
        errors: Object
    },
    components: {
        Link
    }
}
</script>

<style>

</style>
