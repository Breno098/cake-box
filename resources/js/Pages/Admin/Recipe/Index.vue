<script setup>
    import { ref } from 'vue';
    import { Head, useForm, Link } from '@inertiajs/inertia-vue3';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import moment from 'moment';

    const props = defineProps({
        recipes: Object,
    });

    const current = ref(1)

    const columns = [{
        name: 'title',
        align: 'left',
        label: 'Titulo',
        field: 'title',
    }, {
        name: 'rating',
        align: 'left',
        label: 'Avaliação',
        field: 'rating',
    }, {
        name: 'time_to_prepare',
        align: 'center',
        label: 'Tempo para preparo',
        field: 'time_to_prepare',
    }, {
        name: 'time_to_cook',
        align: 'center',
        label: 'Tempo para cozinhar',
        field: 'time_to_cook',
    }, {
        name: 'difficulty',
        align: 'center',
        label: 'Dificuldade',
        field: 'difficulty',
    }, {
        name: 'actions',
        align: 'center',
    }];

    const filters = useForm({
    });

    const teste = (page) => {
        filters.get(route('admin.recipe.index', { page }));
    }

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
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Receitas" />

        <q-table
            title="Receitas"
            :rows="recipes.data"
            :columns="columns"
            row-key="id"
            :pagination.sync="{
                rowsPerPage: 10
            }"
        >
            <template v-slot:body="props">
                <q-tr :props="props">
                    <q-td key="title" :props="props">
                        {{ props.row.title }}
                    </q-td>
                    <q-td key="rating" :props="props">
                        <q-rating
                            v-model="props.row.rating"
                            size="2em"
                            :max="5"
                            color="orange"
                            readonly
                        />
                    </q-td>
                    <q-td key="time_to_cook" :props="props">
                        <q-icon name="schedule" class="q-mr-sm" size="sm"/>
                        {{ moment(props.row.time_to_cook * 1000).format("hh:mm:ss") }}
                    </q-td>
                    <q-td key="time_to_prepare" :props="props">
                        <q-icon name="schedule" class="q-mr-sm" size="sm"/>
                        {{ moment(props.row.time_to_prepare * 1000).format("hh:mm:ss") }}
                    </q-td>
                    <q-td key="difficulty" :props="props">
                        <q-badge rounded :color="color(props.row.difficulty)" />
                    </q-td>
                    <q-td key="actions" :props="props">
                        <Link
                            :href="route('admin.recipe.edit', props.row.id)"
                            style="text-decoration: none"
                        >
                            <q-btn
                                round
                                color="primary"
                                icon="edit"
                                size="sm"
                            />
                        </Link>
                    </q-td>
                </q-tr>
            </template>
        </q-table>

        <div class="q-pa-lg flex flex-center">
            <q-pagination
                v-model="recipes.meta.current_page"
                :max="recipes.meta.last_page"
                :max-pages="10"
                @update:model-value="teste"
            />
        </div>
    </AuthenticatedLayout>
</template>


