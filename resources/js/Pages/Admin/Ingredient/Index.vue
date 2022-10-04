<script setup>
    import { ref } from 'vue';
    import { Head, useForm, Link } from '@inertiajs/inertia-vue3';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Inertia } from '@inertiajs/inertia';
    import { useQuasar } from 'quasar'

    const $q = useQuasar()

    const props = defineProps({
        ingredients: Object,
    });

    const columns = [{
        name: 'name',
        align: 'left',
        label: 'Nome',
        field: 'name',
    }, {
        name: 'actions',
        align: 'center',
    }];

    const filters = useForm({
    });

    const paginate = (page) => {
        filters.get(route('admin.ingredient.index', { page }));
    }

    const modalDelete = ref({
        show: false,
        deleteId: null,
        delete: (id) => {
            modalDelete.value.deleteId = id;
            modalDelete.value.show = true;
        },
        confirmDelete: () => {
            Inertia.delete(route('admin.ingredient.destroy', modalDelete.value.deleteId), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Ingrediente deletado com sucesso',
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
        <Head title="Ingredientes" />

        <div class="row items-center q-pb-sm q-px-sm">
            <q-icon name="egg" size="sm"/>
            <div class="text-h6 q-ml-sm"> Ingredientes </div>
        </div>

        <!-- <div class="row">
            <div
                class="col-3 q-mb-md q-px-sm"
                v-for="ingredient in ingredients.data"
                :key="ingredient.id"
            >
                <q-card >
                    <q-img
                        class="col"
                        src="https://cdn.quasar.dev/img/parallax2.jpg"
                    >
                        <div class="absolute-bottom text-subtitle2 text-center">
                            {{ ingredient.name }}
                        </div>
                    </q-img>

                    <q-separator />

                    <q-card-section >
                        <q-card-actions  class="justify-around">
                            <q-btn flat round color="primary" icon="edit" />
                            <q-btn flat round color="red" icon="delete" />
                        </q-card-actions>
                    </q-card-section>
                </q-card>
            </div>
        </div> -->

        <q-table
            :rows="ingredients.data"
            :columns="columns"
            row-key="id"
            :pagination.sync="{
                rowsPerPage: 10
            }"
            hide-bottom
        >
            <template v-slot:body="props">
                <q-tr :props="props">
                    <q-td key="name" :props="props">
                        {{ props.row.name }}
                    </q-td>
                    <q-td key="actions" :props="props">
                        <Link
                            :href="route('admin.ingredient.edit', props.row.id)"
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
        </q-table>

        <div class="q-pa-lg" v-show="ingredients.meta.last_page > 1">
            <q-pagination
                v-model="ingredients.meta.current_page"
                :max="ingredients.meta.last_page"
                :max-pages="10"
                @update:model-value="paginate"
            />
        </div>

        <q-dialog v-model="modalDelete.show">
            <q-card>
                <q-card-section class="text-center">
                    <div class="text-h6"> Excluir ingrediente? </div>
                </q-card-section>

                <q-card-section class="text-center">
                    Ao confirmar você irá deletar o ingrediente de todas as receitas. <br/>
                    Tem certeza disso?
                </q-card-section>

                <q-card-actions align="right">
                    <q-btn flat label="Cancelar" color="green" v-close-popup />
                    <q-btn flat label="Confirmar" color="red" @click="modalDelete.confirmDelete" />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </AuthenticatedLayout>
</template>
