<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'
    import { Inertia } from '@inertiajs/inertia';
    import DialogConfirm from '@/Components/DialogConfirm.vue';
    import { ref, computed } from 'vue'

    const $q = useQuasar()

    const props = defineProps({
        recipe: Object,
        errors: Object,
        directions: Object,
    });

    function destroy() {
        $q.dialog({
            component: DialogConfirm,
            componentProps: {
                title: 'Excluir receita',
                message: 'Tem certeza que deseja excluir esse receita?',
            },
        }).onOk(() => {
            Inertia.delete(route('admin.recipe.destroy', props.recipe.id), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Receita excluído com sucesso',
                        position: 'top',
                    })
                }
            })
        });
    }

    const modalStoreShow = ref(false);

    const formStore = useForm({
        description: null
    });

    const storeDirection = () => {
        formStore.post(route("admin.recipe.direction.store", {
            recipe: props.recipe.id,
        }), {
            onSuccess: () => {
                modalStoreShow.value = false;

                $q.notify({
                    type: 'positive',
                    message: 'Instrução adicionado com sucesso',
                    position: 'top',
                })
            },
        })
    };

    const modalUpdateShow = ref(false);

    const formUpdate = useForm({
        direction_id: null,
        description: null,
    });

    const modalUpdateShowAction = (direction) => {
        formUpdate.direction_id = direction.id;
        formUpdate.description = direction.description;
        modalUpdateShow.value = true;
    }

    const updateDirection = () => {
        formUpdate.put(route("admin.recipe.direction.update", {
            recipe: props.recipe.id,
            direction: formUpdate.direction_id
        }), {
            onSuccess: () => {
                modalUpdateShow.value = false;
                formUpdate.direction_id = null;

                $q.notify({
                    type: 'positive',
                    message: 'Instrução atualizada com sucesso',
                    position: 'top',
                })
            },
        })
    };

    function destroyDirection(directionId) {
        $q.dialog({
            component: DialogConfirm,
            componentProps: {
                title: 'Retirar instrução?',
                message: 'Tem certeza que deseja excluir essa instrução?',
            },
        }).onOk(() => {
            Inertia.delete(route('admin.recipe.direction.destroy', {
                recipe: props.recipe.id,
                direction: directionId
            }), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Instrução desvinculado com sucesso',
                        position: 'top',
                    })
                }
            })
        });
    }

    const tab = ref('directions');

    const goMainTab = () => {
        Inertia.get(route('admin.recipe.edit', props.recipe.id))
    }

    const goIngredientsTab = () => {
        Inertia.get(route('admin.recipe.ingredient.index', props.recipe.id))
    }

    const goIndex = () => {
        Inertia.get(route('admin.recipe.index'))
    }
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Receita | Instruções" />

        <div class="row q-mb-lg">
            <div class="col-6 flex justify-start items-center">
                <q-icon name="menu_book" size="md"/>
                <div class="text-h5 q-ml-sm"> {{ recipe.title }} | Instruções </div>
            </div>

            <div class="col-6 flex justify-end items-center">
                <q-btn
                    color="primary"
                    label="Voltar para listagem"
                    icon="chevron_left"
                    no-caps
                    @click="goIndex"
                    class="q-mr-md"
                />

                <q-btn
                    color="red"
                    label="Excluir receita"
                    icon="close"
                    no-caps
                    @click="destroy"
                    outline
                />
            </div>
        </div>

        <q-card>
            <q-tabs
                v-model="tab"
                class="text-primary"
                inline-label
                no-caps
                align="left"
            >
                <q-tab
                    icon="menu_book"
                    label="Receita"
                    name="recipe"
                    @click="goMainTab"
                />
                <q-tab
                    icon="egg"
                    label="Ingredientes"
                    name="ingredients"
                    @click="goIngredientsTab"
                />
                <q-tab
                    icon="format_list_numbered"
                    label="Intruções"
                    name="directions"
                />
            </q-tabs>

            <q-card-section>
                <div class="flex justify-between q-mb-md">
                    <div class="row items-center">
                        <q-icon name="format_list_numbered" size="sm"/>
                        <div class="text-h6 q-ml-sm"> Instruções </div>
                    </div>

                    <q-btn
                        color="primary"
                        icon="add"
                        @click="modalStoreShow = true"
                        size="sm"
                        label="Adicionar instrução"
                        no-caps
                    />
                </div>

                <q-markup-table v-if="directions.length > 0" flat>
                    <thead>
                        <tr>
                            <th class="text-left">
                                Descrição
                            </th>
                            <th class="text-left">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="direction, index in directions"
                            :key="`direction-${index}`"
                        >
                            <td class="text-left">
                                {{ direction.description }}
                            </td>
                            <td class="text-right">
                                <q-btn
                                    color="primary"
                                    icon="edit"
                                    size="sm"
                                    @click="modalUpdateShowAction(direction)"
                                    class="q-mr-sm"
                                />
                                <q-btn
                                    color="red"
                                    icon="close"
                                    size="sm"
                                    class="q-mr-sm"
                                    @click="destroyDirection(direction.id)"
                                />
                            </td>
                        </tr>
                    </tbody>
                </q-markup-table>

                <div
                    v-else
                    class="column flex-center q-py-lg"
                >
                    <q-icon name="add_circle_outline" size="md" class="text-h6 q-py-lg"/>

                    <div class="text-h6 q-py-lg">
                        Não há intruções para essa receita. Clique no botão ao lado e adicione o passo a passo.
                    </div>
                </div>

                <q-dialog v-model="modalStoreShow" >
                    <q-card
                        class="q-dialog-plugin"
                        style="width: 600px; border-radius: 10px;"
                    >
                        <q-card-section class="text-h5 text-center q-mb-md">
                            Adicionar instrução
                        </q-card-section>

                        <q-card-section>
                            <div class="row q-col-gutter-lg">
                                <div class="col-12">
                                    <q-input
                                        outlined
                                        v-model="formStore.description"
                                        label="Instrução"
                                        type="textarea"
                                    />
                                </div>
                            </div>
                        </q-card-section>

                        <q-card-actions align="center">
                            <q-btn
                                color="red"
                                no-caps
                                label="Cancelar"
                                @click="modalStoreShow = false"
                                icon="close"
                            />

                            <q-btn
                                color="green"
                                no-caps
                                label="Adicionar"
                                @click="storeDirection"
                                icon="check"
                            />
                        </q-card-actions>
                    </q-card>
                </q-dialog>

                <q-dialog v-model="modalUpdateShow" >
                    <q-card
                        class="q-dialog-plugin q-pa-md"
                        style="width: 550px; border-radius: 10px;"
                    >
                        <q-card-section class="text-h5 text-center q-mb-md">
                            Atualizar instrução
                        </q-card-section>

                        <q-card-section>
                            <div class="row q-col-gutter-lg">
                                <div class="col-12">
                                    <q-input
                                        outlined
                                        v-model="formUpdate.description"
                                        label="Instrução"
                                        type="textarea"
                                    />
                                </div>
                            </div>
                        </q-card-section>

                        <q-card-actions align="center">
                            <q-btn
                                color="red"
                                no-caps
                                label="Cancelar"
                                @click="modalUpdateShow = false"
                                icon="close"
                            />

                            <q-btn
                                color="green"
                                no-caps
                                label="Atualizar"
                                @click="updateDirection"
                                icon="check"
                            />
                        </q-card-actions>
                    </q-card>
                </q-dialog>
            </q-card-section>
        </q-card>
    </AuthenticatedLayout>
</template>
