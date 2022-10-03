<script setup>
    import { ref } from 'vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import moment from 'moment';

    const props = defineProps({
        recipe: Object,
    });

    const color = (difficulty) => {
        switch (difficulty) {
            case 1: return 'green';
            case 2: return 'green';
            case 3: return 'blue';
            case 4: return 'orange';
            case 5: return 'red';
            default: return 'black';
        }
    }

    const difficulties = [{
        label: 'Muito fácil',
        value: 1
    }, {
        label: 'Fácil',
        value: 2
    }, {
        label: 'Médio',
        value: 3
    }, {
        label: 'Difícil',
        value: 4
    }, {
        label: 'Muito difícil',
        value: 5
    }];
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Receita" />

        <div class="row">
            <div class="col-12 col-md-6 q-mb-md q-px-sm">
                <q-input
                    filled
                    v-model="recipe.title"
                    label="Título"
                />
            </div>

            <div class="col-12 col-md-6 q-mb-md q-px-sm">
                <q-select
                    label="Dificuldade"
                    transition-show="flip-up"
                    transition-hide="flip-down"
                    filled
                    v-model="recipe.difficulty"
                    :options="difficulties"
                    emit-value
                    map-options
                />
            </div>

            <div class="col-12 q-mb-md q-px-sm">
                <q-input
                    filled
                    v-model="recipe.description"
                    label="Descrição"
                    type="textarea"
                />
            </div>

            <div class="col-12 q-mb-md q-px-sm">
                <q-input
                    filled
                    v-model="recipe.info"
                    label="Informação"
                    type="textarea"
                />
            </div>
        </div>



        <pre>
            {{ recipe }}
        </pre>
    </AuthenticatedLayout>
</template>


