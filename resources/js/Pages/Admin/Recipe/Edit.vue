<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'
    import { Inertia } from '@inertiajs/inertia';
    import DialogConfirm from '@/Components/DialogConfirm.vue';
    import { ref, computed } from 'vue'
    import { useDropzone } from "vue3-dropzone";

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
        images: props.recipe.images,
        wallpaper: props.recipe.wallpaper,
    });

    const dropZoneWallpaper = useDropzone({
        onDrop: (acceptFiles, rejectReasons) => {
            form.wallpaper = acceptFiles[0];

            if (rejectReasons.length > 0) {
                $q.notify({
                    message: 'Insira apenas uma imagem',
                    position: 'center',
                })
            }
        },
        accept: ['image/*'],
        maxFiles: 1
    });

    const wallpaperSrc = computed(() => {
        if (! form.wallpaper)
            return '';

        return (typeof form.wallpaper === 'object') ? URL.createObjectURL(form.wallpaper) : form.wallpaper;
    });

    const removeWallpaper = () => {
        form.wallpaper = null;
    }

    const getRootPropsWallpaper = dropZoneWallpaper.getRootProps;
    const getInputPropsWallpaper = dropZoneWallpaper.getInputProps;

    const dropZoneImages = useDropzone({
        onDrop: (acceptFiles, rejectReasons) => {
            for (var x = 0; x < acceptFiles.length; x++) {
                form.images.push({
                    id: null,
                    name: acceptFiles[x].name,
                    size: acceptFiles[x].size,
                    link: URL.createObjectURL(acceptFiles[x]),
                    uploadedFile: acceptFiles[x],
                });
            }
        },
        accept: ['image/*']
    });

    const getRootPropsImages = dropZoneImages.getRootProps;
    const getInputPropsImages = dropZoneImages.getInputProps;

    const removeImage = (position) => {
        form.images = [
            ...form.images.slice(0, position),
            ...form.images.slice(position + 1)
        ];
    }

    const submit = () => {
        form
            .transform((data) => ({...data, _method: 'put' }))
            .post(route("admin.recipe.update", form.id), {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    form.images = props.recipe.images;

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

    const goIndex = () => {
        goToTab(route('admin.recipe.index'));
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
                    <div class="col-12" v-if="wallpaperSrc">
                        <q-img
                            :src="wallpaperSrc"
                            style="height: 400px"
                            class="rounded-borders"
                        >
                            <div class="absolute-bottom text-subtitle2 flex flex-center">
                                <div class="flex cursor-pointer" v-bind="getRootPropsWallpaper()">
                                    <input v-bind="getInputPropsWallpaper()"/>
                                    <q-icon name="edit" size="sm" class="q-mr-md"/>
                                    Alterar capa
                                </div>

                                <q-space/>

                                <q-btn flat icon="close" @click="removeWallpaper">
                                    <q-tooltip> Remover capa </q-tooltip>
                                </q-btn>
                            </div>
                        </q-img>
                    </div>

                    <div class="col-12" v-else>
                        <div
                            v-bind="getRootPropsWallpaper()"
                            class="column flex-center q-py-md text-grey-8 app-border-dashed-blue rounded-borders"
                        >
                            <input v-bind="getInputPropsWallpaper()"/>
                            <q-icon name="image" size="md"/>
                            <div class="q-mt-sm">Clique aqui ou arraste a imagem de capa</div>
                        </div>
                    </div>

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

                    <div class="col-12">
                        <div
                            v-bind="getRootPropsImages()"
                            class="column flex-center q-py-md text-grey-8 app-border-dashed-blue rounded-borders"
                        >
                            <input v-bind="getInputPropsImages()"/>
                            <q-icon name="collections" size="md"/>
                            <div class="q-mt-sm">Clique aqui ou arraste imagens para receita</div>
                        </div>
                    </div>

                    <div class="col-12 row q-col-gutter-lg">
                        <div class="col-12 col-md-3" v-for="(image, index) in form.images" :key="`image-${index}}}`">
                            <q-img :src="image.link" style="height: 240px" class="rounded-borders">
                                <div class="absolute-bottom text-subtitle2 flex flex-center">
                                    <q-icon name="collections" size="sm" class="q-mr-md"/>

                                    <div class="column">
                                        <span class="text-caption">
                                            {{ image.name.length > 25 ? image.name.slice(0, 25) + '...' : image.name }}
                                        </span>

                                        <span class="text-caption"> ({{ image.size ?? 0 }} kb) </span>
                                    </div>

                                    <q-space/>

                                    <q-btn flat icon="close" @click="removeImage(index)">
                                        <q-tooltip> Remover imagem </q-tooltip>
                                    </q-btn>
                                </div>
                            </q-img>
                        </div>
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

                    <div class="col-12 flex justify-end">
                        <q-btn
                            color="green"
                            label="Salvar"
                            icon="check"
                            no-caps
                            @click="submit()"
                            :disabled="form.processing"
                        />
                    </div>
                </div>
            </q-card-section>
        </q-card>
    </AuthenticatedLayout>
</template>
