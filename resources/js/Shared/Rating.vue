<template>
    <div class="border-t grid justify-items-center" :class="recipe.comments.length > 0 ? 'grid-cols-3' : 'grid-cols-2'">
        <i v-if="recipe.comments.length > 0" @click="show(recipe.id)" class="fa-solid fa-message text-blue-300 text-2xl cursor-pointer"
                   >{{recipe.comments.length}}</i>
        <div class="text-sky-300 text-3xl">
            {{ recipe.ratings.reduce((acc, currVal) => acc + currVal.up_vote, 0) }}
            <i @click="thumbsUp(recipe.id, $page.props.user.email)"
               class="fa-solid fa-thumbs-up cursor-pointer"></i>
        </div>
        <div class="text-red-300 text-3xl">
            {{ recipe.ratings.reduce((acc, currVal) => acc + currVal.down_vote, 0) }}
            <i @click="thumbsDown(recipe.id, $page.props.user.email)"
               class="fa-solid fa-thumbs-down cursor-pointer"></i>
        </div>
    </div>
</template>
<script>
import {Inertia} from "@inertiajs/inertia";

export default {
    data() {
        return {}
    },
    props: {
        recipe: Object
    },
    methods: {
        thumbsUp(recipeId, email) {
            Inertia.post(`/recipes/${recipeId}/vote`, {
                recipe_id: recipeId,
                up_vote: true,
                email: email
            }, {preserveScroll: true});
        },
        thumbsDown(recipeId, email) {
            Inertia.post(`/recipes/${recipeId}/vote`, {
                recipe_id: recipeId,
                down_vote: true,
                email: email
            }, {preserveScroll: true});
        },
        show(id) {
            Inertia.get('/recipes/show', {
                id: id
            })
        },
    }
}
</script>
