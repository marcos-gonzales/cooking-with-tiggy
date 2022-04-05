<template>
    <span class="text-black grow"
    ><i class="fa-solid fa-bacon"></i
    ><i class="fa-solid fa-carrot"></i
    ><i class="fa-solid fa-pepper-hot"></i> needed:
                    <span class="text-xs text-slate-400">{{
                            recipe.ingredients
                        }}</span></span
    >
</template>
<script>
export default {
    props: {
        recipe: Object
    }
}
</script>
