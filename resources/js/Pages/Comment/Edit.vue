<template>
    {{ comment }}
    <div class="border bg-amber-100">
        <form class="flex flex-col mx-auto p-4 h-52">
            <div class="flex flex-col p-2">
                <label for="name" id="name" class="text-center pb-2">Have something to say??</label>
                <input
                    class="border rounded px-1"
                    v-model="comment.user_input"
                    type="text"
                    name="comment"
                    placeholder="don't be shy.."
                />
            </div>

            <button
                @click="submit($event, $page.props.user.email, comment.recipe_id, comment.id)"
                class="border bg-blue-300 my-8 rounded mx-auto hover:bg-amber-200 text-white p-2 text-mlg"
                style="width: 50% !important"
            >
                Update Comment
            </button>
        </form>
    </div>
</template>
<script>
import {Inertia} from "@inertiajs/inertia";

export default {
    data() {
        return {
            'comment': this.comment.user_input,
            'commentId': this.comment.id
        }
    },
    props: {
        comment: Object
    },
    methods: {
        submit(event, authUser, recipeId, commentId) {
            event.preventDefault();

            Inertia.post(`/recipes/${recipeId}/update-comment/${commentId}`, {
                email: authUser,
                comment: this.comment.user_input,
            });
        },
    }
}
</script>
