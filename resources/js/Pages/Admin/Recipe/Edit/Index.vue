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
    });

    const form = useForm({
        id: props.recipe.id,
        title: props.recipe.title,
        description: props.recipe.description,
        info: props.recipe.info,
        difficulty: props.recipe.difficulty,
        time_to_cook: props.recipe.time_to_cook,
        time_to_prepare: props.recipe.time_to_prepare,
        rating: props.recipe.rating,
        yield_quantity: props.recipe.yield_quantity,
        yield_unit_measure: props.recipe.yield_unit_measure,
    });

    const submit = (afterRoute = null) => {
        form.put(route("admin.recipe.update", form.id), {
            onSuccess: () => {
                if (afterRoute) {
                    Inertia.get(route(afterRoute, form.id))
                } else {
                    $q.notify({
                        type: 'positive',
                        message: 'Receita atualizado com sucesso',
                        position: 'top',
                    })
                }
            },
        })
    };

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

    const tab = ref('recipe');

    function destroy() {
        $q.dialog({
            component: DialogConfirm,
            componentProps: {
                title: 'Excluir receita',
                message: 'Tem certeza que deseja excluir esse receita?',
            },
        }).onOk(() => {
            Inertia.delete(route('admin.recipe.destroy', form.id), {
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

    const goIngredientsTab = () => {
        goToTab(route('admin.recipe.ingredient.index', form.id));
    }

    const goDirectionsTab = () => {
        goToTab(route('admin.recipe.direction.index', form.id));
    }

    const goToTab = (_route) => {
        tab.value = 'recipe'

        if (form.isDirty) {
            $q.dialog({
                component: DialogConfirm,
                componentProps: {
                    title: 'Dados não salvos',
                    html: true,
                    message: `Alguns dados foram alterados e não foram salvos. <br/> Deseja descartar alterações?`,
                },
            }).onOk(() => {
                Inertia.get(_route)
            })
        } else {
            Inertia.get(_route)
        }
    }
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Receita | Editar" />

        <div class="row q-mb-lg">
            <div class="col-6 flex justify-start items-center">
                <q-icon name="menu_book" size="md"/>
                <div class="text-h5 q-ml-sm"> {{ recipe.title }} | Editar </div>
            </div>

            <div class="col-6 flex justify-end items-center">
                <q-btn
                    color="green"
                    label="Salvar"
                    icon="check"
                    no-caps
                    @click="submit()"
                    :disabled="form.processing"
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
                    @click="goDirectionsTab"
                />
            </q-tabs>

            <q-card-section>
                <div class="flex justify-between q-mb-md">
                    <div class="row items-center">
                        <q-icon name="menu_book" size="sm"/>
                        <div class="text-h6 q-ml-sm"> Informações </div>
                    </div>
                </div>

                <div class="row q-col-gutter-lg">
                    <div class="col-12 col-md-6">
                        <q-input
                            outlined
                            v-model="form.title"
                            label="Título"
                            :bottom-slots="Boolean(errors.title)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ errors.title }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12 col-md-6">
                        <q-select
                            label="Dificuldade"
                            transition-show="flip-up"
                            transition-hide="flip-down"
                            outlined
                            v-model="form.difficulty"
                            :options="difficulties"
                            emit-value
                            map-options
                            :bottom-slots="Boolean(errors.difficulty)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ errors.difficulty }} </div>
                            </template>
                        </q-select>
                    </div>

                    <div class="col-12">
                        <q-input
                            outlined
                            v-model="form.description"
                            label="Descrição"
                            type="textarea"
                        />
                    </div>

                    <div class="col-12">
                        <q-input
                            outlined
                            v-model="form.info"
                            label="Informação"
                            type="textarea"
                        />
                    </div>

                    <div class="col-12 col-md-6">
                        <q-input
                            outlined
                            v-model="form.time_to_cook"
                            label="Tempo para cozinhar"
                            mask="time"
                            :bottom-slots="Boolean(errors.time_to_cook)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ errors.time_to_cook }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12 col-md-6">
                        <q-input
                            outlined
                            v-model="form.time_to_prepare"
                            label="Tempo de preparo"
                            mask="time"
                            :bottom-slots="Boolean(errors.time_to_prepare)"
                        >
                            <template v-slot:hint>
                                <div class="text-red"> {{ errors.time_to_prepare }} </div>
                            </template>
                        </q-input>
                    </div>

                    <div class="col-12 col-md-6">
                        <q-input
                            outlined
                            v-model="form.yield_quantity"
                            label="Rendimento"
                            type="number"
                        />
                    </div>

                    <div class="col-12 col-md-6">
                        <q-select
                            label="Medida de rendimento"
                            transition-show="flip-up"
                            transition-hide="flip-down"
                            outlined
                            v-model="form.yield_unit_measure"
                            :options="unitMeasures"
                            emit-value
                            map-options
                        />
                    </div>
                </div>
            </q-card-section>
        </q-card>
    </AuthenticatedLayout>
</template>
