<script setup>
    import { ref, computed } from 'vue'
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { useQuasar } from 'quasar'

    const $q = useQuasar()

    const props = defineProps({
        recipe: Object,
        ingredients: Array
    });

    const form = useForm({
        id: props.recipe.data.id,
        title: props.recipe.data.title,
        description: props.recipe.data.description,
        info: props.recipe.data.info,
        difficulty: props.recipe.data.difficulty,
        time_to_cook: props.recipe.data.time_to_cook,
        time_to_prepare: props.recipe.data.time_to_prepare,
        rating: props.recipe.data.rating,
        yield_quantity: props.recipe.data.yield_quantity,
        yield_unit_measure: props.recipe.data.yield_unit_measure,
        ingredients: props.recipe.data.ingredients,
        directions: props.recipe.data.directions,
    });

    const submit = () => {
        form.put(route("admin.recipe.update", form.id),{
            onSuccess: () => {
                $q.notify({
                    type: 'positive',
                    message: 'Produto atualizado com sucesso',
                    position: 'top',
                })
            },
        })
    };

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

    const unitMeasures = [
        'Fatia', 'Pedaço', 'Gramas'
    ];

    const columnsIngredientsTable = [{
        name: 'name',
        field: 'name',
        align: 'left',
        label: 'Ingrediente'
    }, {
        name: 'quantity',
        field: 'quantity',
        align: 'left',
        label: 'Quantidade'
    }, {
        name: 'unit_measure',
        field: 'unit_measure',
        align: 'left',
        label: 'Medida'
    }, {
        name: 'actios',
        field: 'actios',
        align: 'left',
    }];

    const ingredientForSelect = computed(() => props.ingredients
        .filter((ing) => !form.ingredients.some(item => item.id === ing.id))
        .map((ing) => ({
            label: ing.name,
            value: ing.id
        }))
    );

    const unitIngrientMeasures = [
        'Unidade', 'Grama', 'Quilo', 'Mililitro', 'Litro', 'Colher'
    ];

    const modalIngredient = ref({
        show: false,
        showConfirmDelete: false,
        data: {
            id: null,
            quantity: 1,
            unit_measure: 'Unidade'
        },
        initData: {
            id: null,
            quantity: 1,
            unit_measure: 'Unidade'
        },
        add: () => {
            let ingredient = props.ingredients.filter((ing) => ing.id == modalIngredient.value.data.id).shift();

            form.ingredients.push({
                id: modalIngredient.value.data.id,
                name: ingredient.name,
                quantity: modalIngredient.value.data.quantity,
                unit_measure: modalIngredient.value.data.unit_measure,
            });

            modalIngredient.value.data = { ...modalIngredient.value.initData };
            modalIngredient.value.show = false;
        },
        delete: (id) => {
            modalIngredient.value.data.id = id;
            modalIngredient.value.showConfirmDelete = true;
        },
        confirmDelete: () => {
            form.ingredients = form.ingredients.filter((ing) => ing.id != modalIngredient.value.data.id);
            modalIngredient.value.showConfirmDelete = false;
            modalIngredient.value.data.id = null;
        },
    });

    const columnsDirectionsTable = [{
        name: 'order',
        field: 'order',
        align: 'left',
        label: 'Ordem'
    }, {
        name: 'description',
        field: 'description',
        align: 'left',
        label: 'Passo'
    }, {
        name: 'actios',
        field: 'actios',
        align: 'left',
    }];

    const modalDirection = ref({
        show: false,
        showConfirmDelete: false,
        data: {
            description: '',
            order: null
        },
        initData: {
            description: '',
            order: null
        },
        add: () => {
            form.directions.push({
                description: modalDirection.value.data.description,
                order: form.directions.length + 1,
            });

            modalDirection.value.data = { ...modalDirection.value.initData };
            modalDirection.value.show = false;
        },
        delete: (order) => {
            modalDirection.value.data.order = order;
            modalDirection.value.showConfirmDelete = true;
        },
        confirmDelete: () => {
            form.directions = form.directions.filter((dir) => dir.order != modalDirection.value.data.order);

            var order = 1;
            form.directions.map(dir => {
                dir.order = order++;
                return dir;
            })

            modalDirection.value.showConfirmDelete = false;
            modalDirection.value.data.order = null;
        },
    });
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Receita" />

        <form @submit.prevent="submit">
            <div class="row">
                <div class="row col-6 q-mb-md items-center q-px-sm">
                    <q-icon name="menu_book" size="sm"/>
                    <div class="text-h6 q-ml-sm"> Receita | Editar </div>
                </div>

                <div class="col-6 q-mb-md q-px-sm row justify-end">
                    <q-btn
                        color="primary"
                        label="Salvar"
                        type="submit"
                        icon="save"
                        :disabled="form.processing"
                        :class="{ 'opacity-25': form.processing }"
                    />
                </div>

                <div class="col-12 col-md-6 q-mb-md q-px-sm">
                    <q-input
                        filled
                        v-model="form.title"
                        label="Título"
                        :bottom-slots="Boolean(form.errors.title)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ form.errors.title }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-6 q-mb-md q-px-sm">
                    <q-select
                        label="Dificuldade"
                        transition-show="flip-up"
                        transition-hide="flip-down"
                        filled
                        v-model="form.difficulty"
                        :options="difficulties"
                        emit-value
                        map-options
                        :bottom-slots="Boolean(form.errors.difficulty)"
                    >
                        <template v-slot:option="scope">
                            <q-item v-bind="scope.itemProps">
                                <q-item-section avatar>
                                    <q-badge rounded :color="color(scope.opt.value)" />
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label>{{ scope.opt.label }}</q-item-label>
                                </q-item-section>
                            </q-item>
                        </template>
                        <template v-slot:hint>
                            <div class="text-red"> {{ form.errors.difficulty }} </div>
                        </template>
                    </q-select>
                </div>

                <div class="col-12 q-mb-md q-px-sm">
                    <q-input
                        filled
                        v-model="form.description"
                        label="Descrição"
                        type="textarea"
                    />
                </div>

                <div class="col-12 q-mb-md q-px-sm">
                    <q-input
                        filled
                        v-model="form.info"
                        label="Informação"
                        type="textarea"
                    />
                </div>

                <div class="col-12 col-md-6 q-mb-md q-px-sm">
                    <q-input
                        filled
                        v-model="form.time_to_cook"
                        label="Tempo para cozinhar"
                        mask="time"
                        :bottom-slots="Boolean(form.errors.time_to_cook)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ form.errors.time_to_cook }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-6 q-mb-md q-px-sm">
                    <q-input
                        filled
                        v-model="form.time_to_prepare"
                        label="Tempo de preparo"
                        mask="time"
                        :bottom-slots="Boolean(form.errors.time_to_prepare)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ form.errors.time_to_prepare }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-6 q-mb-md q-px-sm">
                    <q-input
                        filled
                        v-model="form.yield_quantity"
                        label="Rendimento"
                        type="number"
                    />
                </div>

                <div class="col-12 col-md-6 q-mb-md q-px-sm">
                    <q-select
                        label="Medida de rendimento"
                        transition-show="flip-up"
                        transition-hide="flip-down"
                        filled
                        v-model="form.yield_unit_measure"
                        :options="unitMeasures"
                        emit-value
                        map-options
                    />
                </div>
            </div>

            <q-table
                title="Ingredientes"
                flat
                hide-bottom
                :rows="form.ingredients"
                :columns="columnsIngredientsTable"
                class="q-mt-lg"
            >
                <template v-slot:top-right>
                    <q-btn
                        color="primary"
                        icon="add"
                        @click="modalIngredient.show = true"
                        round
                        size="sm"
                    />
                </template>

                <template v-slot:body="props">
                    <q-tr :props="props">
                        <q-td key="name" :props="props">
                            {{ props.row.name }}
                        </q-td>
                        <q-td key="quantity" :props="props">
                            {{ props.row.quantity }}
                            <q-popup-edit v-model="props.row.quantity" title="Atualizar quantidade" buttons v-slot="scope">
                                <q-input type="number" v-model="scope.value" dense autofocus />
                            </q-popup-edit>
                        </q-td>
                        <q-td key="unit_measure" :props="props">
                            {{ props.row.unit_measure }}
                            <q-popup-edit v-model="props.row.unit_measure" title="Atualizar quantidade" buttons v-slot="scope">
                                <q-select
                                    v-model="scope.value"
                                    label="Ingrediente"
                                    filled
                                    :options="unitIngrientMeasures"
                                />
                            </q-popup-edit>
                        </q-td>
                        <q-td key="unit_measure" :props="props">
                            <q-btn
                                round
                                color="red"
                                icon="close"
                                size="sm"
                                class="q-mr-sm"
                                @click="modalIngredient.delete(props.row.id)"
                            />
                        </q-td>
                    </q-tr>
                </template>
            </q-table>

            <q-dialog v-model="modalIngredient.show" >
                <q-card style="min-width: 600px">
                    <q-card-section>
                        <div class="text-h6"> Ingrediente </div>
                    </q-card-section>

                    <q-card-section class="q-pt-none">
                        <div class="row">
                            <div class="col-5 q-mb-md q-px-sm">
                                <q-select
                                    v-model="modalIngredient.data.id"
                                    label="Ingrediente"
                                    transition-show="flip-up"
                                    transition-hide="flip-down"
                                    filled
                                    :options="ingredientForSelect"
                                    emit-value
                                    map-options
                                />
                            </div>

                            <div class="col-3 q-mb-md q-px-sm">
                                <q-input
                                    filled
                                    v-model="modalIngredient.data.quantity"
                                    label="Quantidade"
                                    type="number"
                                />
                            </div>

                            <div class="col-4 q-mb-md q-px-sm">
                                <q-select
                                    v-model="modalIngredient.data.unit_measure"
                                    label="Ingrediente"
                                    transition-show="flip-up"
                                    transition-hide="flip-down"
                                    filled
                                    :options="unitIngrientMeasures"
                                    emit-value
                                    map-options
                                />
                            </div>
                        </div>
                    </q-card-section>

                    <q-card-actions align="right" class="text-primary">
                        <q-btn flat label="Cancelar" @click="modalIngredient.show = false"/>
                        <q-btn flat label="Adicionar" @click="modalIngredient.add" />
                    </q-card-actions>
                </q-card>
            </q-dialog>

            <q-dialog v-model="modalIngredient.showConfirmDelete">
                <q-card>
                    <q-card-section class="text-center">
                        <div class="text-h6"> Excluir ingrediente? </div>
                    </q-card-section>

                    <q-card-section class="text-center">
                        Ao confirmar você irá tirar o ingrediente da receita. <br/>
                        Tem certeza disso?
                    </q-card-section>

                    <q-card-actions align="right">
                        <q-btn flat label="Cancelar" color="green" v-close-popup />
                        <q-btn flat label="Confirmar" color="red" @click="modalIngredient.confirmDelete" />
                    </q-card-actions>
                </q-card>
            </q-dialog>

            <q-table
                title="Instruções"
                flat
                hide-bottom
                :rows="form.directions"
                :columns="columnsDirectionsTable"
                class="q-mt-lg"
            >
                <template v-slot:top-right>
                    <q-btn
                        color="primary"
                        icon="add"
                        @click="modalDirection.show = true"
                        round
                        size="sm"
                    />
                </template>

                <template v-slot:body="props">
                    <q-tr :props="props">
                        <q-td key="order" :props="props">
                            {{ props.row.order }}
                        </q-td>
                        <q-td key="description" :props="props">
                            <div v-html="props.row.description"></div>

                            <q-popup-edit v-model="props.row.description" title="Passo" buttons v-slot="scope">
                                <q-editor v-model="scope.value"/>
                            </q-popup-edit>
                        </q-td>
                        <q-td key="actios" :props="props">
                            <q-btn
                                round
                                color="red"
                                icon="close"
                                size="sm"
                                class="q-mr-sm"
                                @click="modalDirection.delete(props.row.order)"
                            />
                        </q-td>
                    </q-tr>
                </template>
            </q-table>

            <q-dialog v-model="modalDirection.show" >
                <q-card style="min-width: 800px">
                    <q-card-section>
                        <div class="text-h6"> Instrução </div>
                    </q-card-section>

                    <q-card-section class="q-pt-none">
                        <div class="row">
                            <div class="col-12 q-mb-md q-px-sm">
                                <q-editor v-model="modalDirection.data.description"/>
                            </div>
                        </div>
                    </q-card-section>

                    <q-card-actions align="right" class="text-primary">
                        <q-btn flat label="Cancelar" @click="modalDirection.show = false"/>
                        <q-btn flat label="Adicionar" @click="modalDirection.add" />
                    </q-card-actions>
                </q-card>
            </q-dialog>

            <q-dialog v-model="modalDirection.showConfirmDelete">
                <q-card>
                    <q-card-section class="text-center">
                        <div class="text-h6"> Excluir instrução? </div>
                    </q-card-section>

                    <q-card-section class="text-center">
                        Ao confirmar você irá apagar a intrução da receita. <br/>
                        Tem certeza disso?
                    </q-card-section>

                    <q-card-actions align="right">
                        <q-btn flat label="Cancelar" color="green" v-close-popup />
                        <q-btn flat label="Confirmar" color="red" @click="modalDirection.confirmDelete" />
                    </q-card-actions>
                </q-card>
            </q-dialog>
        </form>
    </AuthenticatedLayout>
</template>
