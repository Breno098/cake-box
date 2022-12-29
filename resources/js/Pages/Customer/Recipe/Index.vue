<script setup>
    import AuthenticatedLayout from '@/Layouts/Customer/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import { ref, computed } from 'vue';
    import CardRecipe from '@/Components/Customer/Feed/CardRecipe.vue'

    const props = defineProps({
        recipes: Object
    });
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <div class="text-weight-bold text-orange text-overline app-fs-16">
            <q-icon name="menu_book" class="app-fs-20 q-mr-sm q-mb-xs"/>
            RECEITAS
        </div>

        <div v-for="recipe in recipes.data">
            <CardRecipe
                :recipe="recipe"
                class="q-my-md"
            />
        </div>
    </AuthenticatedLayout>
</template>
