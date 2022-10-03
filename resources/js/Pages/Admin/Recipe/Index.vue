<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/inertia-vue3';

    defineProps({
        recipes: Object,
    });
</script>

<template>
    <AuthenticatedLayout>
      <Head title="Receitas" />

      <div class="container mb-3">
            <table class="table table-hover mt-3">
                <tr>
                    <th scope="col">Nome</th>
                    <th style="width: 12%"></th>
                </tr>
                <tbody>
                    <tr v-for="recipe in recipes.data" :key="recipe.id">
                        <td>{{ recipe.title }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-dark me-2">
                                <fa icon="edit"/>
                            </button>

                            <button type="button" class="btn btn-sm btn-danger">
                                <fa icon="trash"/>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
      </div>

      <!-- {{ recipes }} -->
    </AuthenticatedLayout>
</template>

<!-- <script>
    export default {
      props: {
        recipes: Object,
      },
    }
</script> -->


