<template>
    <div class="border-t flex justify-evenly">
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
    }
}
</script>
