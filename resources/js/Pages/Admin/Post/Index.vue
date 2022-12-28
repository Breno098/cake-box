<script setup>
    import { ref, computed } from 'vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Inertia } from '@inertiajs/inertia';
    import { useQuasar } from 'quasar';
    import DialogConfirm from '@/Components/DialogConfirm.vue';

    const $q = useQuasar()

    const props = defineProps({
        posts: Object,
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
        requestData.get(route('admin.post.index'), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => showFilters.value = false,
        });
    }

    function create() {
        Inertia.get(route('admin.post.create'));
    }

    function edit(id) {
        Inertia.get(route('admin.post.edit', id));
    }

    function destroy(id) {
        $q.dialog({
            component: DialogConfirm,
            componentProps: {
                title: 'Excluir postagem?',
                message: 'Tem certeza que deseja excluir esse postagem?',
            },
        }).onOk(() => {
            Inertia.delete(route('admin.post.destroy', id), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Postagem excluída com sucesso',
                        position: 'top',
                    })
                }
            })
        });
    }

    const countAppliedFilters = computed(() => Object.values(props.query.filters).filter(fil => fil).length);

    const showFilters = ref(false)
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Postagens" />

        <div class="row q-mb-lg">
            <div class="col-6 flex justify-start items-center">
                <q-icon name="web" size="md"/>
                <div class="text-h5 q-ml-sm"> Postagens </div>
            </div>

            <div class="col-6 flex justify-end items-center">
                <q-btn
                    color="primary"
                    label="Nova postagem"
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
                                label="Título da postagem"
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

        <q-card>
            <q-markup-table>
                <thead>
                    <tr>
                        <th class="text-left cursor-pointer" >
                            Postagem
                        </th>
                        <th class="text-left">
                            Criado por
                        </th>
                        <th class="text-center">
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="post, index in posts.data" :key="`post-${index}`">
                        <td class="text-left">
                            {{ post.title }}
                        </td>
                        <td class="text-left">
                            {{ post.creator.name }}
                        </td>
                        <td class="text-center">
                            <q-btn icon="more_vert" flat>
                                <q-menu>
                                    <q-list>
                                        <q-item
                                            clickable
                                            @click="edit(post.id)"
                                            class="text-blue flex flex-center"
                                        >
                                            <q-icon name="edit" size="xs"/>
                                            <div class="q-ml-sm"> Editar </div>
                                        </q-item>

                                        <q-separator/>

                                        <q-item
                                            clickable
                                            @click="destroy(post.id)"
                                            class="text-red flex flex-center"
                                        >
                                            <q-icon name="close" size="xs"/>
                                            <div class="q-ml-sm"> Excluir </div>
                                        </q-item>
                                    </q-list>
                                </q-menu>
                            </q-btn>
                        </td>
                    </tr>
                </tbody>
            </q-markup-table>

            <div class="row justify-end">
                <div class="row items-center text-grey">
                    Resultado por página

                    <q-select
                        :options="[5, 10, 15]"
                        v-model="requestData.rowsPerPage"
                        borderless
                        class="q-ml-md"
                        @update:model-value="submit"
                    />
                </div>

                <q-pagination
                    v-model="requestData.page"
                    :max="posts.meta.last_page"
                    @update:model-value="submit"
                    direction-links
                    boundary-links
                    color="grey"
                    input
                    icon-first="keyboard_double_arrow_left"
                    icon-last="keyboard_double_arrow_right"
                />
            </div>
        </q-card>
    </AuthenticatedLayout>
</template>
