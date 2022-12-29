<script setup>
    import AuthenticatedLayout from '@/Layouts/Customer/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import { ref, computed } from 'vue';
    import CardRecipe from '@/Components/Customer/Feed/CardRecipe.vue'
    import CardPost from '@/Components/Customer/Feed/CardPost.vue'

    const props = defineProps({
        recipes: Array,
        posts: Array
    });

    const defaultImg = '/img/no-image.jpg';
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <div v-for="post in posts">
            <CardPost
                :post="post"
                class="q-my-md"
            />
        </div>

        <div v-for="recipe in recipes">
            <CardRecipe
                :recipe="recipe"
                class="q-my-md"
            />
        </div>
    </AuthenticatedLayout>
</template>
