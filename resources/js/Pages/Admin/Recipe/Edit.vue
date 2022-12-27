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
        ingredients: Array,
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
        ingredients: props.recipe.ingredients,
        directions: props.recipe.directions,
        wallpaper: null,
        image_1: null,
        image_2: null,
        image_3: null,
        image_4: null,
    });

    const defaultImg = '/img/no-image.jpg';

    const wallpaperRef = ref('wallpaperRef')
    const wallpaperSrc = ref(props.recipe.wallpaper ?? defaultImg)
    const wallpaperChange = (event) => {
        form.wallpaper = event.target.files[0];
        wallpaperSrc.value = URL.createObjectURL(event.target.files[0]);
    }

    const image1Ref = ref('image1Ref')
    const image1Src = ref(props.recipe.image_1 ?? defaultImg)
    const image1Change = (event) => {
        form.image_1 = event.target.files[0];
        image1Src.value = URL.createObjectURL(event.target.files[0]);
    }

    const image2Ref = ref('image2Ref')
    const image2Src = ref(props.recipe.image_2 ?? defaultImg)
    const image2Change = (event) => {
        form.image_2 = event.target.files[0];
        image2Src.value = URL.createObjectURL(event.target.files[0]);
    }

    const image3Ref = ref('image3Ref')
    const image3Src = ref(props.recipe.image_3 ?? defaultImg)
    const image3Change = (event) => {
        form.image_3 = event.target.files[0];
        image3Src.value = URL.createObjectURL(event.target.files[0]);
    }

    const image4Ref = ref('image4Ref')
    const image4Src = ref(props.recipe.image_4 ?? defaultImg)
    const image4Change = (event) => {
        form.image_4 = event.target.files[0];
        image4Src.value = URL.createObjectURL(event.target.files[0]);
    }

    const submit = () => {
        form
            .transform((data) => ({...data, _method: 'put' }))
            .post(route("admin.recipe.update", form.id), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Receita atualizado com sucesso',
                        position: 'top',
                    })
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
            let ingredient = props.ingredients.filter((ing) => ing.id == modalIngredient.value.id).shift();

            form.ingredients.push({
                id: modalIngredient.value.id,
                name: ingredient.name,
                quantity: modalIngredient.value.quantity,
                unit_measure: modalIngredient.value.unit_measure,
            });

            modalIngredient.value = { ...modalIngredient.value.initData };
            modalIngredient.value.show = false;
        },
        delete: (id) => {
            modalIngredient.value.id = id;
            modalIngredient.value.showConfirmDelete = true;
        },
        confirmDelete: () => {
            form.ingredients = form.ingredients.filter((ing) => ing.id != modalIngredient.value.id);
            modalIngredient.value.showConfirmDelete = false;
            modalIngredient.value.id = null;
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
                description: modalDirection.value.description,
                order: form.directions.length + 1,
            });

            modalDirection.value = { ...modalDirection.value.initData };
            modalDirection.value.show = false;
        },
        delete: (order) => {
            modalDirection.value.order = order;
            modalDirection.value.showConfirmDelete = true;
        },
        confirmDelete: () => {
            form.directions = form.directions.filter((dir) => dir.order != modalDirection.value.order);

            var order = 1;
            form.directions.map(dir => {
                dir.order = order++;
                return dir;
            })

            modalDirection.value.showConfirmDelete = false;
            modalDirection.value.order = null;
        },
    });

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
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Receita | Editar" />

        <div class="row q-mb-lg">
            <div class="col-6 flex justify-start items-center">
                <q-icon name="menu_book" size="md"/>
                <div class="text-h5 q-ml-sm"> Receita | Editar </div>
            </div>

            <div class="col-6 flex justify-end items-center">
                <q-btn
                    color="red"
                    label="Excluir"
                    icon="close"
                    no-caps
                    @click="destroy"
                    :disabled="form.processing"
                    class="q-mr-md"
                    outline
                />

                <q-btn
                    color="green"
                    label="Salvar"
                    icon="check"
                    no-caps
                    @click="submit"
                    :disabled="form.processing"
                />
            </div>
        </div>

        <q-tabs
            v-model="tab"
            class="text-primary"
            inline-label
        >
            <q-tab name="recipe" icon="menu_book" label="Receita" />
            <q-tab name="ingredients" icon="egg" label="Ingredientes" />
            <q-tab name="directions" icon="format_list_numbered" label="Intruções" />
            <q-tab name="images" icon="image" label="Imagens" />
        </q-tabs>

        <q-tab-panels
            v-model="tab"
            animated
            transition-prev="jump-up"
            transition-next="jump-up"
        >
            <q-tab-panel name="recipe">
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
            </q-tab-panel>

            <q-tab-panel name="ingredients">
                <div class="flex justify-between">
                    <div class="row items-center">
                        <q-icon name="egg" size="sm"/>
                        <div class="text-h6 q-ml-sm"> Ingredientes </div>
                    </div>

                    <q-btn
                        color="primary"
                        icon="add"
                        @click="modalIngredient.show = true"
                        size="sm"
                        label="Adicionar ingrendiente"
                        no-caps
                    />
                </div>

                <q-table
                    flat
                    hide-bottom
                    :rows="form.ingredients"
                    :columns="columnsIngredientsTable"
                    class="q-mt-lg"
                    :pagination.sync="{
                        rowsPerPage: form.ingredients.length
                    }"
                    v-if="form.ingredients.length > 0"
                >
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
                                        outlined
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

                <div
                    v-if="form.ingredients.length == 0"
                    class="column flex-center q-py-lg"
                >
                    <q-icon name="add_circle_outline" size="md" class="text-h6 q-py-lg"/>

                    <div class="text-h6 q-py-lg">
                        Não há ingredientes para essa receita. Clique no botão ao lado e adicione os ingredientes.
                    </div>
                </div>

                <q-dialog v-model="modalIngredient.show" >
                    <q-card style="min-width: 600px">
                        <q-card-section>
                            <div class="text-h6"> Ingrediente </div>
                        </q-card-section>

                        <q-card-section class="q-pt-none">
                            <div class="row">
                                <div class="col-5">
                                    <q-select
                                        v-model="modalIngredient.id"
                                        label="Ingrediente"
                                        transition-show="flip-up"
                                        transition-hide="flip-down"
                                        outlined
                                        :options="ingredientForSelect"
                                        emit-value
                                        map-options
                                    />
                                </div>

                                <div class="col-3">
                                    <q-input
                                        outlined
                                        v-model="modalIngredient.quantity"
                                        label="Quantidade"
                                        type="number"
                                    />
                                </div>

                                <div class="col-4">
                                    <q-select
                                        v-model="modalIngredient.unit_measure"
                                        label="Ingrediente"
                                        transition-show="flip-up"
                                        transition-hide="flip-down"
                                        outlined
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
            </q-tab-panel>

            <q-tab-panel name="directions">
                 <div class="flex justify-between">
                    <div class="row items-center">
                        <q-icon name="format_list_numbered" size="sm"/>
                        <div class="text-h6 q-ml-sm"> Instruções </div>
                    </div>

                    <q-btn
                        color="primary"
                        icon="add"
                        @click="modalDirection.show = true"
                        size="sm"
                        label="Adicionar instrução"
                        no-caps
                    />
                </div>

                <q-table
                    flat
                    hide-bottom
                    :rows="form.directions"
                    :columns="columnsDirectionsTable"
                    :pagination.sync="{
                        rowsPerPage: form.directions.length
                    }"
                    v-if="form.directions.length > 0"
                >
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

                <div
                    v-if="form.directions.length == 0"
                    class="column flex-center q-py-lg"
                >
                    <q-icon name="add_circle_outline" size="md" class="text-h6 q-py-lg"/>

                    <div class="text-h6 q-py-lg">
                        Não há intruções para essa receita. Clique no botão ao lado e adicione o passo a passo.
                    </div>
                </div>

                <q-dialog v-model="modalDirection.show" >
                    <q-card style="min-width: 800px">
                        <q-card-section>
                            <div class="text-h6"> Instrução </div>
                        </q-card-section>

                        <q-card-section class="q-pt-none">
                            <q-input
                                outlined
                                v-model="modalDirection.description"
                                label="Instrução"
                                type="textarea"
                            />
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
            </q-tab-panel>

            <q-tab-panel name="images">
                <div class="row q-col-gutter-lg">
                    <div class="col-12 text-center">
                        <q-img
                            :src="wallpaperSrc"
                            style="max-height: 600px"
                            class="relative-position"
                        >
                            <q-btn
                                round
                                color="primary"
                                icon="attach_file"
                                class="absolute all-pointer-events"
                                style="top: 8px; left: 8px"
                                @click="wallpaperRef.click()"
                            />

                            <div class="absolute-bottom text-center column flex-center">
                                Imagem principal
                            </div>

                            <!-- <q-btn
                                round
                                color="red"
                                icon="delete"
                                class="absolute all-pointer-events"
                                style="top: 60px; left: 15px"
                                size="sm"
                                @click="wallpaperSrc = defaultImg"
                            /> -->
                        </q-img>

                        <input
                            type="file"
                            ref="wallpaperRef"
                            style="display: none"
                            @input="wallpaperChange"
                        />
                    </div>

                    <div class="col-6 text-center">
                        <q-img
                            :src="image1Src"
                            style="max-width: 800px; max-height: 400px"
                            class="relative-position"
                        >
                            <q-btn
                                round
                                color="primary"
                                icon="attach_file"
                                class="absolute all-pointer-events"
                                style="top: 8px; left: 8px"
                                @click="image1Ref.click()"
                            />
                        </q-img>

                        <input
                            type="file"
                            ref="image1Ref"
                            style="display: none"
                            @input="image1Change"
                        />
                    </div>

                    <div class="col-6 text-center">
                        <q-img
                            :src="image2Src"
                            style="max-width: 800px; max-height: 400px"
                            class="relative-position"
                        >
                            <q-btn
                                round
                                color="primary"
                                icon="attach_file"
                                class="absolute all-pointer-events"
                                style="top: 8px; left: 8px"
                                @click="image2Ref.click()"
                            />
                        </q-img>

                        <input
                            type="file"
                            ref="image2Ref"
                            style="display: none"
                            @input="image2Change"
                        />
                    </div>

                    <div class="col-6 text-center">
                        <q-img
                            :src="image3Src"
                            style="max-width: 800px; max-height: 400px"
                            class="relative-position"
                        >
                            <q-btn
                                round
                                color="primary"
                                icon="attach_file"
                                class="absolute all-pointer-events"
                                style="top: 8px; left: 8px"
                                @click="image3Ref.click()"
                            />
                        </q-img>

                        <input
                            type="file"
                            ref="image3Ref"
                            style="display: none"
                            @input="image3Change"
                        />
                    </div>

                    <div class="col-6 text-center">
                        <q-img
                            :src="image4Src"
                            style="max-width: 800px; max-height: 400px"
                            class="relative-position"
                        >
                            <q-btn
                                round
                                color="primary"
                                icon="attach_file"
                                class="absolute all-pointer-events"
                                style="top: 8px; left: 8px"
                                @click="image4Ref.click()"
                            />
                        </q-img>

                        <input
                            type="file"
                            ref="image4Ref"
                            style="display: none"
                            @input="image4Change"
                        />
                    </div>
                </div>
            </q-tab-panel>
        </q-tab-panels>
    </AuthenticatedLayout>
</template>
