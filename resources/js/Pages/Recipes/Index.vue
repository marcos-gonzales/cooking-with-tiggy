<template>
    <div>
        <div class="flex justify-between items-center mt-1">
            <h1 class="text-center font-bold text-2xl underline text-amber-200">
                Recipes
            </h1>
            <input
                class="border rounded pl-1"
                v-model="search"
                type="text"
                name="search"
                placeholder="search..."
                @keyup="searchRecipe"
            />
            <Link href="/recipes/create" class="text-sm text-sky-300 underline"
            >create a new recipe
            </Link>
        </div>

        <div
            class="border border-2 border-sky-200 p-2 my-4 rounded"
            v-for="recipe in recipes.data"
            :key="recipe.id"
        >
            <div class="grid grid-cols-2">

                <div>
                    <p class="mx-2">
                        <i class="fa-solid fa-hourglass-start"></i
                        >{{ recipe.estimated_time }} minutes
                        <span class="font-bold text-sky-300 pr-2 text-xl">
                            {{ recipe.name }}
                            <i
                                v-if="recipe.name.includes('burger', 'Burger')"
                                class="fa-solid fa-burger pl-2"
                            ></i>
                            <span @click="recipeCategoryIndex(recipe.category)"
                                  class="ml-2 text-amber-200 text-base cursor-pointer z-10 hover:underline">{{
                                    recipe.category.name
                                }}</span>
                        </span>
                    </p>
                </div>
                <div class="justify-self-end space-x-2">
                    <span class="text-black underline">{{
                            moment(recipe.created_at)
                        }}</span>
                    <img
                        @click="personIndex($event, recipe.user)"
                        :src="recipe.user.file_path.startsWith('/home') ? recie.user.file_path.replace() : ''"
                        class="inline object-cover w-12 h-12 mr-2 rounded-full cursor-pointer"
                    />
                </div>
            </div>
            <div class="grid grid-cols-3 gap-x-1.5">
                <div class="col-span-2">
                    <img @click="show(recipe.id)"
                         :src="recipe.file_path"
                         style="height: 350px;"
                         class="cursor-pointer object-cover"/>
                </div>
                <div class="col-span-1">
                    <p class="my-4">{{
                            recipe.steps.length > 1000 ? recipe.steps.substring(0, recipe.steps.length - 1000) : recipe.steps
                        }}</p>
                </div>
            </div>

            <div class="flex">
                <i class="fa-solid fa-message text-blue-300 text-2xl absolute -mt-12" v-if="recipe.comments.length > 0">{{
                        recipe.comments.length
                    }}</i>
                <Ingredients :recipe="recipe"/>
                <span @click="destroy(recipe.id)" class="cursor-pointer text-lg text-red-300"
                      v-if="$page.props.user.username === recipe.user.name || $page.props.auth.admin === 1"><i
                    class="fa-solid fa-trash-can"></i></span>
            </div>

            <Rating :recipe="recipe"/>

        </div>

        <div v-if="recipes.links.length">
            <div class="flex flex-wrap mt-8">
                <template v-for="(link, key) in recipes.links" :key="key">
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
    </div>
</template>

<script>
import {ref} from 'vue';
import {Inertia} from '@inertiajs/inertia';
import {Link} from "@inertiajs/inertia-vue3";
import moment from "moment";
import Rating from '../../Shared/Rating';
import Ingredients from '../../Shared/Ingredients';

export default {
    data() {
        return {
            search: ref(),
        }
    },
    props: {
        recipes: Object,
    },
    components: {
        Link,
        Rating,
        Ingredients
    },
    methods: {
        moment: function (date) {
            return moment(date).fromNow();
        },
        show(id) {
            Inertia.get('/recipes/show', {
                id: id
            })
        },
        personIndex(event, user) {
            event.stopPropagation();
            Inertia.get(`/recipes/${user.id}/index`)
        },
        searchRecipe() {
            Inertia.get('/recipes', {
                search: this.search
            }, {preserveState: true})
        },
        recipeCategoryIndex(category) {
            Inertia.get(`/recipes/category/${category.id}`)
        },
        destroy(id) {
            Inertia.delete(`/recipes/${id}`, {
                id: id
            })
        },
    },
    computed: {}
};
</script>

<style></style>

