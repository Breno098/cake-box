<script setup>
    import { ref } from 'vue';
    import { Head, useForm, Link } from '@inertiajs/inertia-vue3';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Inertia } from '@inertiajs/inertia';
    import { useQuasar } from 'quasar'

    const $q = useQuasar()

    const defaultImg = '/img/no-image.jpg';

    const props = defineProps({
        recipes: Object,
    });

    const filters = useForm({
    });

    const search = (page) => {
        filters.get(route('admin.recipe.index', { page }));
    }

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

    const modalDelete = ref({
        show: false,
        deleteId: null,
        delete: (id) => {
            modalDelete.value.deleteId = id;
            modalDelete.value.show = true;
        },
        confirmDelete: () => {
            Inertia.delete(route('admin.recipe.destroy', modalDelete.value.deleteId), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Produto deletado com sucesso',
                        position: 'top',
                    })

                    modalDelete.value.show = false;
                }
            })
        }
    })
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Receitas" />

        <div class="row">
            <div class="flex col-6 q-mb-md items-center q-px-sm">
                <q-icon name="menu_book" size="sm"/>
                <div class="text-h6 q-ml-sm"> Receitas </div>
            </div>

             <div class="col-6 q-mb-md q-px-sm row justify-end">
                <Link
                    :href="route('admin.recipe.create')"
                    style="text-decoration: none"
                >
                    <q-btn
                        color="primary"
                        label="Adicionar"
                        icon="add"
                        rounded
                    />
                </Link>
            </div>
        </div>

        <div class="row">
            <div
                class="col-12 col-md-3 q-mb-md q-px-sm"
                v-for="recipe in recipes.data"
                :key="recipe.id"
            >
                <q-card>
                    <q-img
                        :src="recipe.wallpaper ?? defaultImg"
                        height="160px"
                    >
                        <q-icon
                            name="star"
                            :color="recipe.rating >= star ? 'orange' : 'grey-4'"
                            v-for="star in [1, 2, 3, 4, 5]"
                            :key="star"
                        />

                        <div class="absolute-bottom text-center column flex-center">
                            {{ recipe.title }}
                        </div>
                    </q-img>

                    <q-card-section class="flex column q-gutter-sm">
                        <q-btn
                            unelevated
                            rounded
                            color="orange"
                            :label="`Cozinhar: ${recipe.time_to_cook}`"
                            icon-right="schedule"
                            size="sm"
                        />

                        <q-btn
                            unelevated
                            rounded
                            color="orange"
                            :label="`Preparo: ${recipe.time_to_prepare}`"
                            icon-right="schedule"
                            size="sm"
                        />

                        <q-btn
                            unelevated
                            rounded
                            :color="color(recipe.difficulty)"
                            :label="difficulties(recipe.difficulty)"
                            size="sm"
                            outline
                        />
                    </q-card-section>

                    <q-separator />

                    <q-card-section class="flex justify-around">
                        <Link
                            :href="route('admin.recipe.edit', recipe.id)"
                            style="text-decoration: none"
                        >
                            <q-btn
                                round
                                color="primary"
                                icon="edit"
                                size="sm"
                            />
                        </Link>

                        <q-btn
                            round
                            color="red"
                            icon="delete"
                            size="sm"
                            @click="modalDelete.delete(recipe.id)"
                        />
                    </q-card-section>
                </q-card>
            </div>
        </div>

        <div class="q-pa-lg" v-show="recipes.meta.last_page > 1">
            <q-pagination
                v-model="recipes.meta.current_page"
                :max="recipes.meta.last_page"
                :max-pages="10"
                @update:model-value="search"
            />
        </div>

        <q-dialog v-model="modalDelete.show">
            <q-card>
                <q-card-section class="text-center">
                    <div class="text-h6"> Excluir receita? </div>
                </q-card-section>

                <q-card-section>
                    Ao confirmar você irá deletar a receita. Tem certeza disso?
                </q-card-section>

                <q-card-actions align="right">
                    <q-btn flat label="Cancelar" color="green" v-close-popup />
                    <q-btn flat label="Confirmar" color="red" @click="modalDelete.confirmDelete" />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </AuthenticatedLayout>
</template>


