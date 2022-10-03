<script setup>
    import { ref } from 'vue'
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

    const props = defineProps({
        recipe: Object,
        ingredients: Array
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

    const unitMeasures = [
        'Fatia', 'Pedaço', 'Gramas'
    ];

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
        ingredients: props.recipe.data.ingredients
    });

    const submit = () => {
        form.put(route("admin.recipe.update", form.id));
    };

    const modalIngredient = ref({
        show: false,
        data: {
            id: null,
            quantity: 1,
            unit_measure: 'un.'
        },
        addIngredient: () => {
            let ingredient = props.ingredients.filter((ing) => ing.value == modalIngredient.value.data.id).shift();

            form.ingredients.push({
                id: modalIngredient.value.data.id,
                name: ingredient.label,
                quantity: modalIngredient.value.data.quantity,
                unit_measure: modalIngredient.value.data.unit_measure,
            });
        }
    });
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Receita" />

        <form @submit.prevent="submit">
            <div class="row">
                <div class="col-12 col-md-6 q-mb-md q-px-sm">
                    <q-input
                        filled
                        v-model="form.title"
                        label="Título"
                    />
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
                        :rules="['time']"
                    />
                </div>

                <div class="col-12 col-md-6 q-mb-md q-px-sm">
                    <q-input
                        filled
                        v-model="form.time_to_prepare"
                        label="Tempo de preparo"
                        mask="time"
                        :rules="['time']"
                    />
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

                <div class="col-12 col-md-6 q-mb-md q-px-sm">
                    <q-btn
                        color="black"
                        label="Salvar"
                        type="submit"
                        :disabled="form.processing"
                        :class="{ 'opacity-25': form.processing }"
                    />
                </div>
            </div>

            <q-table
                title="Ingredientes"
                flat
                hide-header
                hide-bottom
                :rows="form.ingredients"
                :columns="[{
                    name: 'name',
                    field: 'name',
                    align: 'left',
                }, {
                    name: 'quantity',
                    field: 'quantity',
                    align: 'left',
                }, {
                    name: 'unit_measure',
                    field: 'unit_measure',
                    align: 'left',
                }]"
            />
        </form>

        <q-btn
            label="Adicionar Ingrediente"
            color="primary"
            @click="modalIngredient.show = true"
        />

        <pre>
            <!-- {{ modalIngredient }} -->
            <!-- {{ ingredients }} -->
            {{ recipe }}
        </pre>

        <q-dialog v-model="modalIngredient.show" persistent>
            <q-card style="min-width: 550px">
                <q-card-section>
                    <div class="text-h6">
                        Ingrediente
                    </div>
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
                                :options="ingredients"
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
                                :options="['un.', 'grama']"
                                emit-value
                                map-options
                            />
                        </div>
                    </div>
                </q-card-section>

                <q-card-actions align="right" class="text-primary">
                    <q-btn flat label="Cancel" @click="modalIngredient.show = false"/>
                    <q-btn flat label="Add address" @click="modalIngredient.addIngredient" />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </AuthenticatedLayout>
</template>


