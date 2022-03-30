<template>
    <div
        class="border border-2 border-sky-200 p-2 my-4 rounded"
    >
        <div class="grid grid-cols-2 mb-2">

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
                    :src="'http://localhost:8000/' + recipe.user.file_path.replace('/Users/marcosgonzales/Desktop/projects/inertia/public/', '')"
                    class="inline object-cover w-12 h-12 mr-2 rounded-full cursor-pointer"
                />
            </div>
        </div>
        <div class="grid grid-cols-1">
            <div>
                <img
                    :src="'http://localhost:8000/' + recipe.file_path.replace('/Users/marcosgonzales/Desktop/projects/inertia/public/', '')"
                    :alt="recipe.name"
                    class="cursor-pointer object-cover"/>
            </div>
            <div class="col-span-1">
                <p class="my-4">{{ recipe.steps }}</p>
            </div>
        </div>

        <div class="flex">
            <Ingredients :recipe="recipe"/>
            >
        </div>
        <Rating :recipe="recipe"/>
    </div>

    <h4 class="my-6 text-center"><i class="fa-solid fa-users"></i> See what others are saying <i
        class="fa-solid fa-people-robbery"></i></h4>

    <div class="border bg-amber-100">
        <form class="flex flex-col mx-auto p-4 h-52">
            <div class="flex flex-col p-2">
                <label for="name" id="name" class="text-center pb-2">Have something to say??</label>
                <input
                    class="border rounded px-1"
                    v-model="comment"
                    type="text"
                    name="comment"
                    placeholder="don't be shy.."
                />
            </div>

            <button
                @click="submit($event, $page.props.user.email, recipe.id)"
                class="border bg-blue-300 my-8 rounded mx-auto hover:bg-amber-200 text-white p-2 text-mlg"
                style="width: 50% !important"
            >
                Post Comment
            </button>
        </form>

    </div>
    <div v-for="comment in recipe.comments" class="border grid grid-cols-5 my-2">
        <img
            :src="'http://localhost:8000/' + comment.file_path.replace('/Users/marcosgonzales/Desktop/projects/inertia/public/', '')"
            :alt="comment.user_id" class="inline object-cover w-12 h-12 mr-2 rounded-full cursor-pointer">
        <p class="col-span-3">{{ comment.user_input }}</p>
        <small class="justify-self-end">{{ moment(comment.created_at) }}</small>
    </div>

</template>
<script>
import {ref} from "vue";
import {Link} from "@inertiajs/inertia-vue3";
import moment from "moment";
import {Inertia} from "@inertiajs/inertia";
import Rating from '../../Shared/Rating';
import Ingredients from "../../Shared/Ingredients";

export default {
    data() {
        return {
            search: ref(),
            comment: '',
        }
    },
    props: {
        recipe: Object,
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
            Inertia.get(`/recipes/category/${category.id}`, {
                category: category.id
            })
        },
        submit(event, authUser, recipeId) {
            event.preventDefault();
            Inertia.post(`/recipes/${recipeId}/comment`, {
                email: authUser,
                comment: this.comment
            });
        },
    },
}
</script>
