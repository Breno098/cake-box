<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'
    import { Inertia } from '@inertiajs/inertia';
    import DialogConfirm from '@/Components/DialogConfirm.vue';
    import { ref } from 'vue'

    const $q = useQuasar()

    const props = defineProps({
        recipe: Object,
        errors: Object,
        ingredients: Object,
        optionsIngredients: Array,
    });

    const optionsIngredients = ref(props.optionsIngredients);

    const filterIngredients = (val, update, abort) => {
        update(() => optionsIngredients.value = props.optionsIngredients.filter(s => s.name.toLowerCase().indexOf(val.toLowerCase()) > -1))
    }

    const unitIngrientMeasures = [
        'Unidade', 'Grama', 'Quilo', 'Mililitro', 'Litro', 'Colher'
    ];

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

    const modalAttachShow = ref(false);

    const formAttach = useForm({
        ingredient_id: null,
        quantity: 1,
        unit_measure: 'Grama',
    });

    const attachIngredient = () => {
        formAttach.post(route("admin.recipe.ingredient.attach", {
            recipe: props.recipe.id,
            ingredient: formAttach.ingredient_id
        }), {
            onSuccess: () => {
                modalAttachShow.value = false;
                formAttach.ingredient_id = null;

                $q.notify({
                    type: 'positive',
                    message: 'Ingrediente adicionado com sucesso',
                    position: 'top',
                })
            },
        })
    };

    const modalUpdateShow = ref(false);

    const formUpdate = useForm({
        ingredient_id: null,
        ingredient_name: null,
        quantity: 1,
        unit_measure: 'Grama',
    });

    const modalUpdateShowAction = (ingredient) => {
        formUpdate.ingredient_id = ingredient.id;
        formUpdate.ingredient_name = ingredient.name;
        formUpdate.quantity = ingredient.quantity;
        formUpdate.unit_measure = ingredient.unit_measure;

        modalUpdateShow.value = true;
    }

    const updateIngredient = () => {
        formUpdate.put(route("admin.recipe.ingredient.update", {
            recipe: props.recipe.id,
            ingredient: formUpdate.ingredient_id
        }), {
            onSuccess: () => {
                modalUpdateShow.value = false;
                formUpdate.ingredient_id = null;

                $q.notify({
                    type: 'positive',
                    message: 'Ingrediente atualizado com sucesso',
                    position: 'top',
                })
            },
        })
    };

    function detachIngredient(ingredientId) {
        $q.dialog({
            component: DialogConfirm,
            componentProps: {
                title: 'Retirar ingrediente?',
                message: 'Tem certeza que deseja excluir esse receita?',
            },
        }).onOk(() => {
            Inertia.delete(route('admin.recipe.ingredient.detach', {
                recipe: props.recipe.id,
                ingredient: ingredientId
            }), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Ingrediente desvinculado com sucesso',
                        position: 'top',
                    })
                }
            })
        });
    }

    const tab = ref('ingredients');

    const goMainTab = () => {
        Inertia.get(route('admin.recipe.edit', props.recipe.id))
    }

    const goDirectionsTab = () => {
        Inertia.get(route('admin.recipe.direction.index', props.recipe.id))
    }

    const goIndex = () => {
        Inertia.get(route('admin.recipe.index'))
    }
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Receita | Ingredientes" />

        <div class="row q-mb-lg">
            <div class="col-6 flex justify-start items-center">
                <q-icon name="menu_book" size="md"/>
                <div class="text-h5 q-ml-sm"> {{ recipe.title }} | Ingredientes </div>
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
                />
                <q-tab
                    icon="format_list_numbered"
                    label="Intruções"
                    name="directions"
                    @click="goDirectionsTab"
                />
            </q-tabs>

            <q-card-section>
                <div class="flex justify-between q-mb-md">
                    <div class="row items-center">
                        <q-icon name="egg" size="sm"/>
                        <div class="text-h6 q-ml-sm"> Ingredientes </div>
                    </div>

                    <q-btn
                        color="primary"
                        icon="add"
                        @click="modalAttachShow = true"
                        size="sm"
                        label="Adicionar ingrediente"
                        no-caps
                    />
                </div>

                <q-markup-table v-if="ingredients.length > 0" flat>
                    <thead>
                        <tr>
                            <th class="text-left">
                                Ingrediente
                            </th>
                            <th class="text-left">
                                Quantidade
                            </th>
                            <th class="text-left">
                                Medida
                            </th>
                            <th class="text-left">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="ingredient, index in ingredients"
                            :key="`ingredient-${index}`"
                        >
                            <td class="text-left">
                                {{ ingredient.name }}
                            </td>
                            <td class="text-left">
                                {{ ingredient.quantity }}
                            </td>
                            <td class="text-left">
                                {{ ingredient.unit_measure }}
                            </td>
                            <td class="text-right">
                                <q-btn
                                    color="primary"
                                    icon="edit"
                                    size="sm"
                                    @click="modalUpdateShowAction(ingredient)"
                                    class="q-mr-sm"
                                />
                                <q-btn
                                    color="red"
                                    icon="close"
                                    size="sm"
                                    class="q-mr-sm"
                                    @click="detachIngredient(ingredient.id)"
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
                        Não há ingredientes para essa receita. Clique no botão ao lado e adicione os ingredientes.
                    </div>
                </div>

                <q-dialog v-model="modalAttachShow" >
                    <q-card
                        class="q-dialog-plugin q-pa-md"
                        style="width: 550px; border-radius: 10px;"
                    >
                        <q-card-section class="text-h5 text-center q-mb-md">
                            Adicionar ingrediente
                        </q-card-section>

                        <q-card-section>
                            <div class="row q-col-gutter-lg">
                                <div class="col-6">
                                    <q-select
                                        v-model="formAttach.ingredient_id"
                                        label="Ingrediente"
                                        outlined
                                        :options="optionsIngredients"
                                        emit-value
                                        map-options
                                        use-input
                                        option-value="id"
                                        option-label="name"
                                        @filter="filterIngredients"
                                    />
                                </div>

                                <div class="col-3">
                                    <q-input
                                        outlined
                                        v-model="formAttach.quantity"
                                        label="Quantidade"
                                        type="number"
                                    />
                                </div>

                                <div class="col-3">
                                    <q-select
                                        v-model="formAttach.unit_measure"
                                        label="Medida"
                                        outlined
                                        :options="unitIngrientMeasures"
                                    />
                                </div>
                            </div>
                        </q-card-section>

                        <q-card-actions align="center">
                            <q-btn
                                color="red"
                                no-caps
                                label="Cancelar"
                                @click="modalAttachShow = false"
                                icon="close"
                            />

                            <q-btn
                                color="green"
                                no-caps
                                label="Adicionar"
                                @click="attachIngredient"
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
                            Atualizar ingrediente
                        </q-card-section>

                        <q-card-section>
                            <div class="row q-col-gutter-lg">
                                <div class="col-5">
                                    <q-input
                                        outlined
                                        v-model="formUpdate.ingredient_name"
                                        label="Ingrediente"
                                        readonly
                                    />
                                </div>

                                <div class="col-3">
                                    <q-input
                                        outlined
                                        v-model="formUpdate.quantity"
                                        label="Quantidade"
                                        type="number"
                                    />
                                </div>

                                <div class="col-4">
                                    <q-select
                                        v-model="formUpdate.unit_measure"
                                        label="Medida"
                                        outlined
                                        :options="unitIngrientMeasures"
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
                                @click="updateIngredient"
                                icon="check"
                            />
                        </q-card-actions>
                    </q-card>
                </q-dialog>
            </q-card-section>
        </q-card>
    </AuthenticatedLayout>
</template>
