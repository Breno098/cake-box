<script setup>
    import { ref } from 'vue';
    import { Head, useForm, Link } from '@inertiajs/inertia-vue3';
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Inertia } from '@inertiajs/inertia';
    import { useQuasar } from 'quasar'

    const $q = useQuasar()

    defineProps({
        ingredients: Object,
    });

    const columns = [{
        name: 'name',
        align: 'left',
        label: 'Nome',
        field: 'name',
    }, {
        name: 'kcal',
        align: 'center',
        label: 'Calorias',
        field: 'kcal',
    }, {
        name: 'fat',
        align: 'center',
        label: 'Gorduras',
        field: 'fat',
    }, {
        name: 'saturates',
        align: 'center',
        label: 'Saturação',
        field: 'saturates',
    }, {
        name: 'carbs',
        align: 'center',
        label: 'Carboidratos',
        field: 'carbs',
    }, {
        name: 'sugars',
        align: 'center',
        label: 'Açucar',
        field: 'sugars',
    }, {
        name: 'fibre',
        align: 'center',
        label: 'Fibras',
        field: 'fibre',
    }, {
        name: 'protein',
        align: 'center',
        label: 'Proteínas',
        field: 'protein',
    }, {
        name: 'salt',
        align: 'left',
        label: 'Sal',
        field: 'salt',
    },{
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

        <div class="row">
            <div class="flex col-6 q-mb-md items-center q-px-sm">
                <q-icon name="egg" size="sm"/>
                <div class="text-h6 q-ml-sm"> Ingredientes </div>
            </div>

             <div class="col-6 q-mb-md q-px-sm row justify-end">
                <Link
                    :href="route('admin.ingredient.create')"
                    style="text-decoration: none"
                >
                    <q-btn
                        color="primary"
                        label="Adicionar"
                        icon="add"
                        rounded
                    />
                </Link>
            </div>
        </div>

        <q-table
            :rows="ingredients.data"
            :columns="columns"
            row-key="id"
            :pagination.sync="{
                rowsPerPage: 10
            }"
            hide-bottom
            flat
        >
            <template v-slot:body="props">
                <q-tr :props="props">
                    <q-td key="name" :props="props">
                        {{ props.row.name }}
                    </q-td>
                    <q-td key="kcal" :props="props">
                        {{ props.row.kcal ?? '--' }}
                    </q-td>
                    <q-td key="fat" :props="props">
                        {{ props.row.fat ?? '--' }}
                    </q-td>
                    <q-td key="saturates" :props="props">
                        {{ props.row.saturates ?? '--' }}
                    </q-td>
                    <q-td key="carbs" :props="props">
                        {{ props.row.carbs ?? '--' }}
                    </q-td>
                    <q-td key="sugars" :props="props">
                        {{ props.row.sugars ?? '--' }}
                    </q-td>
                    <q-td key="fibre" :props="props">
                        {{ props.row.fibre ?? '--' }}
                    </q-td>
                    <q-td key="protein" :props="props">
                        {{ props.row.protein ?? '--' }}
                    </q-td>
                    <q-td key="salt" :props="props">
                        {{ props.row.salt ?? '--' }}
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
