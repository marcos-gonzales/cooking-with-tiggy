<template>
    <div
        class="border rounded bg-slate-100 max-w-xl mx-auto mt-4"
    >
        <h1 class="text-center text-xl mt-2">Create a Recipe</h1>
        <form class="flex flex-col mx-auto p-4" @submit.prevent="submit">
            <div class="flex flex-col p-2">
                <label for="name">Name</label>
                <input
                    class="border rounded px-1"
                    v-model="name"
                    type="text"
                    name="name"
                    placeholder="your recipe name"
                />
            </div>
            <!-- <div v-if="errors.name" class="text-red-500" v-text="errors.name"></div> -->

            <div class="grid grid-cols-2 gap-x-8 my-4">
                <select
                    v-model="category_id"
                    name="category_id"
                    @change="updateCategory"
                >
                    <option value="" disabled>Please Select a category</option>
                    <option
                        v-for="(option, key) in categories"
                        :value="option.id"
                        :key="key"
                    >
                        {{ option.name }}
                    </option>
                </select>

                <select v-model="estimatedTime" name="estimated_time">
                    <option
                        v-for="(option, key) in estimatedOptions"
                        :value="option.value"
                        :key="key"
                        :disabled="option.disabled"
                    >
                        {{ option.name }}
                    </option>
                </select>
            </div>

            <div class="flex flex-col p-2">
                <label for="name">Ingredients</label>
                <input
                    class="border rounded px-1"
                    v-model="ingredients"
                    type="text"
                    name="ingredients"
                    placeholder="ingredients needs for this dish"
                />
            </div>

            <div class="flex flex-col p-2">
                <label for="name">Steps</label>
                <textarea
                    class="border rounded px-1"
                    v-model="steps"
                    name="steps"
                    placeholder="Steps.. How do you create this dish"
                />
            </div>

            <div class="flex flex-col p-2">
                <input type="file" name="file_path" @change="fileUpload"/>
            </div>

            <button
                class="border bg-blue-300 my-8 rounded mx-auto hover:bg-amber-200 text-white p-2 text-mlg"
                style="width: 50% !important"
            >
                Create Recipe
            </button>
            <Link href="/recipes" class="text-blue-300 text-right">back</Link>
        </form>

    </div>
</template>

<script>
import {Inertia} from "@inertiajs/inertia";
import {Link} from '@inertiajs/inertia-vue3';

export default {
    data() {
        return {
            name: "",
            ingredients: "",
            steps: "",
            estimatedTime: "",
            category_id: "",
            file_path: null,

            estimatedOptions: [
                {
                    name: "Please Choose a Estimated time",
                    value: "",
                    disabled: true
                },
                {
                    name: "5 Minutes",
                    value: 5,
                },
                {
                    name: "10 Minutes",
                    value: 10,
                },
                {
                    name: "15 Minutes",
                    value: 15,
                },
                {
                    name: "20 Minutes",
                    value: 20,
                },
                {
                    name: "25 Minutes",
                    value: 25,
                },
                {
                    name: "30 Minutes",
                    value: 30,
                },
                {
                    name: "45 Minutes",
                    value: 45,
                },
                {
                    name: "1 hour",
                    value: 60,
                },
            ],
        };
    },
    methods: {
        submit() {
            Inertia.post("/recipes", {
                name: this.name,
                ingredients: this.ingredients,
                steps: this.steps,
                estimated_time: this.estimatedTime,
                category_id: this.category_id,
                user_id: this.user_id,
                file_path: this.file_path,
            });
        },
        updateCategory(event) {
            this.categoryId = event.target.value;
        },
        fileUpload(event) {
            this.file_path = event.target.files[0];
        },
    },
    props: {
        categories: Object,
        user_id: Number,
    },
    components: {
        Link
    }
};
</script>

<style></style>
