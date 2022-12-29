<script setup>
    import { ref, computed } from 'vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Inertia } from '@inertiajs/inertia';
    import { useQuasar } from 'quasar';
    import DialogConfirm from '@/Components/DialogConfirm.vue';

    const $q = useQuasar()

    const defaultImg = '/img/no-image.jpg';

    const props = defineProps({
        recipes: Object,
        errors: Object,
        query: Object,
    });

    const requestData = useForm({
        orderBy: props.query.orderBy,
        sort: props.query.sort,
        page: props.query.page,
        rowsPerPage: props.query.rowsPerPage,
        filters: {
            title: props.query.filters.title,
        },
    });

    const sortBy = (field) => {
        if (requestData.orderBy === field) {
            requestData.sort = requestData.sort == 'desc' ? 'asc' : 'desc';
        } else {
            requestData.sort == 'asc';
        }

        requestData.orderBy = field;
        requestData.page = 1;

        submit();
    }

    const removeFilter = (filterName) => {
        requestData.filters[filterName] = null;
        submit();
    }

    const submit = () => {
        requestData.get(route('admin.recipe.index'), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => showFilters.value = false,
        });
    }

    function create() {
        Inertia.get(route('admin.recipe.create'));
    }

    function edit(id) {
        Inertia.get(route('admin.recipe.edit', id));
    }

    function destroy(id) {
        $q.dialog({
            component: DialogConfirm,
            componentProps: {
                title: 'Excluir receita',
                message: 'Tem certeza que deseja excluir esse receita?',
            },
        }).onOk(() => {
            Inertia.delete(route('admin.recipe.destroy', id), {
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

    const countAppliedFilters = computed(() => Object.values(props.query.filters).filter(fil => fil).length);

    const showFilters = ref(false)

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

    const difficulties = (difficulty) => {
        switch (difficulty) {
            case 1: return 'Muito fácil';
            case 2: return 'Fácil';
            case 3: return 'Médio';
            case 4: return 'Difícil';
            case 5: return 'Muito difícil';
            default: return '--';
        }
    }

    const slides = ref(props.recipes.data.map((r, i) => i));
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Receitas" />

        <div class="row q-mb-lg">
            <div class="col-6 flex justify-start items-center">
                <q-icon name="menu_book" size="md"/>
                <div class="text-h5 q-ml-sm"> Receitas </div>
            </div>

            <div class="col-6 flex justify-end items-center">
                <q-btn
                    color="primary"
                    label="Nova receita"
                    icon="add"
                    no-caps
                    @click="create"
                />
            </div>
        </div>

        <div class="row q-mb-lg">
            <q-chip
                removable
                outline
                color="primary"
                v-if="query.filters.title"
                @remove="removeFilter('title')"
                square
            >
                Título = {{ query.filters.title }}
            </q-chip>

            <q-space/>

            <q-btn
                dense
                flat
                color="primary"
                icon="filter_alt"
            >
                <q-badge
                    color="orange"
                    floating
                    rounded
                    :label="countAppliedFilters"
                    v-if="countAppliedFilters"
                />

                <q-menu
                    style="min-width: 500px"
                    max-width='500px'
                    class="bg-white q-pa-md"
                    v-model="showFilters"
                >
                    <div class="row q-col-gutter-sm">
                        <div class="col-12">
                            <q-input
                                outlined
                                v-model="requestData.filters.title"
                                label="Nome da receita"
                            />
                        </div>
                    </div>

                    <div class="q-pt-lg">
                        <q-btn
                            color="primary"
                            no-caps
                            @click="submit"
                            icon="search"
                            label="Procurar"
                        />
                    </div>
                </q-menu>
            </q-btn>
        </div>

        <div class="row">
            <div
                class="col-12 col-md-3 q-mb-md q-px-sm"
                v-for="recipe, indexR in recipes.data"
                :key="recipe.id"
            >
                <q-card>
                    <q-img
                        :src="recipe.wallpaper ?? defaultImg"
                        height="180px"
                    />

                    <q-card-section class="flex items-center justify-between q-px-lg q-py-none bg-orange-3">
                        <div class="text-h6">
                            {{ recipe.title }}
                        </div>

                        <q-btn icon="more_vert" flat>
                            <q-menu>
                                <q-list>
                                    <q-item
                                        clickable
                                        @click="edit(recipe.id)"
                                        class="text-blue flex flex-center"
                                    >
                                        <q-icon name="edit" size="xs"/>
                                        <div class="q-ml-sm"> Editar </div>
                                    </q-item>

                                    <q-separator/>

                                    <q-item
                                        clickable
                                        @click="destroy(recipe.id)"
                                        class="text-red flex flex-center"
                                    >
                                        <q-icon name="close" size="xs"/>
                                        <div class="q-ml-sm"> Excluir </div>
                                    </q-item>
                                </q-list>
                            </q-menu>
                        </q-btn>
                    </q-card-section>

                    <q-card-section class="row q-col-gutter-sm">
                        <div class="col-4">
                            <q-chip
                                square
                                icon="leaderboard"
                                :color="color(recipe.difficulty)"
                                :label="difficulties(recipe.difficulty)"
                                class="full-width"
                                text-color="white"
                            >
                                <q-tooltip> Dificuldade </q-tooltip>
                            </q-chip>
                        </div>
                        <div class="col-4">
                            <q-chip
                                outline
                                color="orange"
                                square
                                icon="microwave"
                                :label="recipe.time_to_cook ?? '--:--:--'"
                                class="full-width"
                            >
                                <q-tooltip> Tempo para cozinhar </q-tooltip>
                            </q-chip>
                        </div>
                        <div class="col-4">
                            <q-chip
                                outline
                                color="orange"
                                square
                                icon="check"
                                :label="recipe.time_to_prepare ?? '--:--:--'"
                                class="full-width"
                            >
                                <q-tooltip> Tempo de preparo </q-tooltip>
                            </q-chip>
                        </div>
                    </q-card-section>
                </q-card>
            </div>
        </div>

        <div class="row justify-end">
            <div class="row items-center text-grey">
                Resultado por página

                <q-select
                    :options="[4, 8, 12]"
                    v-model="requestData.rowsPerPage"
                    borderless
                    class="q-ml-md"
                    @update:model-value="submit"
                />
            </div>

            <q-pagination
                v-model="requestData.page"
                :max="recipes.meta.last_page"
                @update:model-value="submit"
                direction-links
                boundary-links
                color="grey"
                input
                icon-first="keyboard_double_arrow_left"
                icon-last="keyboard_double_arrow_right"
            />
        </div>
    </AuthenticatedLayout>
</template>


