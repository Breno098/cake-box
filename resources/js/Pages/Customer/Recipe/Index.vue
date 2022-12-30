<script setup>
    import AuthenticatedLayout from '@/Layouts/Customer/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { ref, computed } from 'vue';
    import CardRecipe from '@/Components/Customer/Recipe/Card.vue'

    const props = defineProps({
        recipes: Object,
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

    const removeFilter = (filterName) => {
        requestData.filters[filterName] = null;
        submit();
    }

    const submit = () => {
        requestData.get(route('customer.recipe.index'), {
            onSuccess: () => showFilters.value = false,
        });
    }

    const countAppliedFilters = computed(() => Object.values(props.query.filters).filter(fil => fil).length);

    const showFilters = ref(false)
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <div class="text-weight-bold text-orange text-overline app-fs-16">
            <q-icon name="menu_book" class="app-fs-20 q-mr-sm q-mb-xs"/>
            RECEITAS
        </div>

        <div class="row">
            <q-chip
                removable
                outline
                color="primary"
                v-if="query.filters.title"
                @remove="removeFilter('title')"
                square
            >
                Título contém '{{ query.filters.title }}'
            </q-chip>

            <q-space/>

            <q-btn
                dense
                flat
                color="primary"
                icon="filter_list"
                size="sm"
            >
                <q-tooltip
                    anchor="center left"
                    self="center right"
                    v-if="!showFilters"
                >
                    Filtros
                </q-tooltip>

                <q-badge
                    color="orange"
                    floating
                    rounded
                    :label="countAppliedFilters"
                    v-if="countAppliedFilters"
                />

                <q-menu
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

                    <div class="q-pt-md">
                        <q-btn
                            color="primary"
                            no-caps
                            @click="submit"
                            icon="search"
                            label="Procurar"
                            size="sm"
                        />
                    </div>
                </q-menu>
            </q-btn>
        </div>

        <div v-for="recipe in recipes.data">
            <CardRecipe
                :recipe="recipe"
                class="q-my-md"
            />
        </div>

        <div class="row justify-center">
            <q-pagination
                v-model="requestData.page"
                :max="recipes.meta.last_page"
                @update:model-value="submit"
                direction-links
                color="orange"
                icon-prev="keyboard_double_arrow_left"
                icon-next="keyboard_double_arrow_right"
            />
        </div>
    </AuthenticatedLayout>
</template>
