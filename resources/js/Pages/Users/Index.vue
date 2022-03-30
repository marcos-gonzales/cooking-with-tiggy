<template>
    <div class="flex my-4 items-center flex-end">
        <div class="grow flex items-center">
            <h1 class="text-center text-lg">Users</h1>
            <Link href="/users/create" class="text-blue-500 underline ml-4"
                >Create new user</Link
            >
        </div>
        <div class="mr-4">
            <label for="name" class="mr-4">Name</label>
            <input
                class="border rounded p-1"
                v-model="search"
                type="text"
                name="search"
                placeholder="please enter your full name"
                @keyup="searchUser"
            />
        </div>
    </div>

    <ul v-if="users" class="flex flex-col justify-end">
        <Link :href="users.id">
            <li v-for="user in users.data" :key="user.id" class="border p-2">
                Name: {{ user.name }}
                <span class="ml-96">{{ moment(user.created_at) }}</span>
                <Link
                    v-if="$page.props.auth.admin"
                    @click="deleteUser(user)"
                    class="border bg-blue-300 text-white"
                >
                    Delete
                </Link>
            </li>
        </Link>
    </ul>

    <!-- Pagination -->
    <div v-if="users.links.length">
        <div class="flex flex-wrap mt-8">
            <template v-for="(link, key) in users.links" :key="key">
                <div
                    v-if="link.url === null"
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="link.label"
                />

                <Link
                    v-else
                    class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-white focus:border-primary focus:text-primary"
                    :class="{ 'bg-white': link.active }"
                    :href="link.url"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import moment from "moment";

export default {
    data() {
        return {
            search: ref(),
        };
    },
    props: {
        users: Object,
        links: Array,
    },
    components: {
        Link,
    },
    methods: {
        moment: function (date) {
            return moment(date).fromNow();
        },
        searchUser() {
            Inertia.get(
                "/users",
                {
                    search: this.search,
                },
                { preserveState: true }
            );
        },
        deleteUser(user) {
            Inertia.delete(`users/${user.id}`, {
                id: user.id,
            });
        },
    },
};
</script>

<style></style>
