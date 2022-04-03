<template>
    <nav>
        <ul class="flex justify-end bg-cyan-400 h-12 space-x-4 px-2 items-center text-slate-200">
            <li class="grow">
                <Link href="/recipes"><i class="fa-solid fa-cat text-2xl cursor-pointer ml-2 hover:text-slate-500"></i>
                </Link>
                <span v-if="$page.props.user.username" class="ml-8">Welcome back, <span
                    class="text-amber-200 font-bold">{{ $page.props.user.username }}</span></span></li>
            <li v-if="$page.props.user.username">
                <select v-model="categoryChosen" name="categories" id="categories"
                        class="bg-cyan-500 rounded px-2 cursor-pointer" @change="filterByCategory(categoryChosen)">
                    <option
                        v-for="(category, key) in categoryOptions"
                        :key="key"
                        :value="category.value"
                        :disabled="category.disabled"
                    >
                        {{ category.name }}
                    </option>
                </select>
            </li>
            <li v-if="!$page.props.user.username">
                <Link href="register" class="text-amber-300 hover:text-white">Register</Link>
            </li>
            <li v-else>
                <Link class="hover:text-slate-500" href="/logout" method="post">Logout</Link>
            </li>
            <li v-if="!$page.props.user.username">
                <Link href="login" class="text-white hover:text-slate-500">Login</Link>
            </li>

        </ul>
    </nav>

    <div style="max-width: 800px; margin: auto;">
        <div v-if="$page.props.flash.success" v-text="$page.props.flash.success" class="text-green-500"></div>
        <div v-if="$page.props.flash.error" v-text="$page.props.flash.error" class="text-red-500"></div>
        <div v-if="errors">
            <p v-for="error in errors" :key="error" v-text="error" class="text-red-500"></p>
        </div>
        <slot/>
    </div>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3';
import {Inertia} from '@inertiajs/inertia';

export default {
    data() {
        return {
            categoryChosen: '',
            categoryOptions: [
                {
                    name: 'Filter by Search',
                    value: '',
                    disabled: true
                },
                {
                    name: 'Likes',
                    value: 'likes'
                },
                {
                    name: 'American',
                    value: 2
                },
                {
                    name: 'Italian',
                    value: 1,
                },
                {
                    name: 'Peruvian',
                    value: 4
                },
                {
                    name: 'Mexican',
                    value: 3
                },
                {
                    name: 'Thai',
                    value: 5
                },
                {
                    name: 'Chinese',
                    value: 6
                },
                {
                    name: 'BBQ',
                    value: 7
                },
                {
                    name: 'Indian',
                    value: 8
                },

            ]
        }
    },
    components: {
        Link
    },
    props: {
        errors: Object
    },
    methods: {
        filterByCategory(category) {
            if (category === 'likes') {
                Inertia.get('/recipes/category/likes', {
                    category: category
                });
            }
            Inertia.get(`/recipes/category/${category}`, {
                category: category
            });
        }
    }
}
</script>

<style>

</style>
