<script setup>
    import AuthenticatedLayout from '@/Layouts/Customer/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import { ref, computed } from 'vue';
    import CardRecipe from '@/Components/Customer/Feed/CardRecipe.vue'
    import CardPost from '@/Components/Customer/Feed/CardPost.vue'

    const props = defineProps({
        feed: Array
    });
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <div v-for="f in feed" class="q-px-xl">
            <CardPost
                :post="f"
                class="q-my-md"
                v-if="f.type_feed == 'post'"
            />

            <CardRecipe
                :recipe="f"
                class="q-my-md"
                v-if="f.type_feed == 'recipe'"
            />
        </div>
    </AuthenticatedLayout>
</template>
