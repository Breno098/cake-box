<script setup>
    import AuthenticatedLayout from '@/Layouts/Customer/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/inertia-vue3';

    const props = defineProps({
        recipes: Array
    });

    const defaultImg = '/img/no-image.jpg';

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
</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <div class="row">
            <div
                class="col-12 col-md-3 q-mb-md q-px-sm"
                v-for="recipe in recipes.data"
                :key="recipe.id"
            >
                <q-card>
                    <q-img
                        :src="recipe.wallpaper ?? defaultImg"
                        height="200px"
                    >
                        <div class="absolute-bottom text-center column flex-center">
                            {{ recipe.title }}
                        </div>
                    </q-img>

                    <q-card-section class="flex flex-center">
                        <q-icon
                            name="star"
                            :color="recipe.rating >= star ? 'orange' : 'grey-4'"
                            v-for="star in [1, 2, 3, 4, 5]"
                            :key="star"
                            size="sm"
                        />
                    </q-card-section>

                    <q-card-section class="flex row justify-around">
                        <div
                            class="text-brown-8 flex column flex-center"
                        >
                            <q-icon
                                name="local_fire_department"
                                color="orange"
                                size="sm"
                            />
                            <div class="q-mt-sm">
                                {{ recipe.time_to_cook }}
                            </div>
                        </div>

                        <div
                            class="text-brown-8 flex column flex-center"
                        >
                            <q-icon
                                name="schedule"
                                color="brown-8"
                                size="sm"
                            />
                            <div class="q-mt-sm">
                                {{ recipe.time_to_prepare }}
                            </div>
                        </div>

                        <q-btn
                            unelevated
                            rounded
                            :color="color(recipe.difficulty)"
                            :label="difficulties(recipe.difficulty)"
                            size="sm"
                            outline
                        />
                    </q-card-section>
                </q-card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
