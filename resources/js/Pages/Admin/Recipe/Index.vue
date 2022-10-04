<script setup>
    import { ref } from 'vue';
    import { Head, useForm, Link } from '@inertiajs/inertia-vue3';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Inertia } from '@inertiajs/inertia';
    import { useQuasar } from 'quasar'

    const $q = useQuasar()

    const defaultImg = 'https://www.defensoria.to.def.br/no_image.jpg';

    const props = defineProps({
        recipes: Object,
    });

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

    const paginate = (page) => {
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

    const modalDelete = ref({
        show: false,
        deleteId: null,
        delete: (id) => {
            modalDelete.value.deleteId = id;
            modalDelete.value.show = true;
        },
        confirmDelete: () => {
            Inertia.delete(route('admin.recipe.destroy', modalDelete.value.deleteId), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Produto deletado com sucesso',
                        position: 'top',
                    })

                    modalDelete.value.show = false;
                }
            })
        }
    })
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Receitas" />

        <div class="row items-center q-pb-sm q-px-sm">
            <q-icon name="menu_book" size="sm"/>
            <div class="text-h6 q-ml-sm"> Receitas </div>
        </div>

         <div class="row">
            <div
                class="col-12 col-md-3 q-mb-md q-px-sm"
                v-for="recipe in recipes.data"
                :key="recipe.id"
            >
                <q-card >
                    <q-img
                        :src="recipe.wallpaper ?? defaultImg"
                        height="140px"
                    >
                        <q-icon
                            name="star"
                            :color="recipe.rating >= star ? 'orange' : 'grey'"
                            v-for="star in [1, 2, 3, 4, 5]"
                            :key="star"
                        />

                        <div class="absolute-bottom text-center column flex-center">
                            {{ recipe.title }}
                        </div>
                    </q-img>

                    <q-separator />

                    <q-card-section class="flex justify-around">
                        <q-btn
                            unelevated
                            rounded
                            color="orange"
                            :label="`Cozinhar: ${recipe.time_to_cook}`"
                            icon-right="schedule"
                            size="sm"
                        />

                        <q-btn
                            unelevated
                            rounded
                            color="orange"
                            :label="`Preparo: ${recipe.time_to_prepare}`"
                            icon-right="schedule"
                            size="sm"
                        />

                        <!-- <q-icon name="schedule" class="q-mr-sm" size="xs"/>
                        {{ recipe.time_to_cook }} -->

                        <!-- <q-icon name="schedule" class="q-mr-sm" size="xs"/>
                        {{ recipe.time_to_prepare }} -->
                    </q-card-section>

                    <q-card-section >
                        <!-- <q-card-actions class="justify-around"> -->
                            <Link
                                :href="route('admin.recipe.edit', recipe.id)"
                                style="text-decoration: none"
                            >
                                <q-btn
                                    round
                                    color="primary"
                                    icon="edit"
                                    size="sm"
                                    class="q-mr-sm"
                                />
                            </Link>

                            <q-btn flat round color="red" icon="delete" />
                        <!-- </q-card-actions> -->
                    </q-card-section>
                </q-card>
            </div>
        </div>
<!--
        <q-table
            :rows="recipes.data"
            :columns="columns"
            row-key="id"
            :pagination.sync="{
                rowsPerPage: 10
            }"
            hide-bottom
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
                        {{ props.row.time_to_cook }}
                    </q-td>
                    <q-td key="time_to_prepare" :props="props">
                        <q-icon name="schedule" class="q-mr-sm" size="sm"/>
                        {{ props.row.time_to_prepare }}
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
                                class="q-mr-sm"
                            />
                        </Link>

                        <q-btn
                            round
                            color="red"
                            icon="delete"
                            size="sm"
                            @click="modalDelete.delete(props.row.id)"
                        />
                    </q-td>
                </q-tr>
            </template>
        </q-table> -->

        <div class="q-pa-lg" v-show="recipes.meta.last_page > 1">
            <q-pagination
                v-model="recipes.meta.current_page"
                :max="recipes.meta.last_page"
                :max-pages="10"
                @update:model-value="paginate"
            />
        </div>

        <q-dialog v-model="modalDelete.show">
            <q-card>
                <q-card-section class="text-center">
                    <div class="text-h6"> Excluir receita? </div>
                </q-card-section>

                <q-card-section>
                    Ao confirmar você irá deletar a receita. Tem certeza disso?
                </q-card-section>

                <q-card-actions align="right">
                    <q-btn flat label="Cancelar" color="green" v-close-popup />
                    <q-btn flat label="Confirmar" color="red" @click="modalDelete.confirmDelete" />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </AuthenticatedLayout>
</template>


