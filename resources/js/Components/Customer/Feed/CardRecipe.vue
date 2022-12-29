<script setup>
    import { ref, computed } from 'vue'

    const props = defineProps({
        recipe: Object
    });

    const defaultImg = '/img/no-image.jpg';

    const liked = ref(false)
    const saved = ref(false)
</script>

<template>
    <q-card class="app-br-16" style="min-height: 250px">
        <q-card-section class="row full-height q-pa-none">
            <div class="col-12 col-md-4">
                <q-img
                    :src="recipe.wallpaper ?? defaultImg"
                    class="app-br-bl-16 app-br-tl-16"
                    style="min-height: 250px"
                />
            </div>

            <div class="col-12 col-md-8 column q-pa-md app-br-br-16 app-br-tr-16">
                <div class="text-weight-bold text-orange text-overline app-fs-9">
                    RECEITAS
                </div>

                <div class="text-h5 text-weight-bold text-primary">
                    {{ recipe.title }}
                </div>

                <div class="q-mt-sm q-mb-xs">
                    {{ recipe.description.length > 250 ? recipe.description.slice(0, 250) + '...' : recipe.description }}
                </div>

                <q-space/>

                <div class="text-right q-pt-md">
                    <q-btn
                        flat
                        round
                        color="red"
                        :icon="liked ? 'favorite' : 'favorite_border'"
                        @click="liked = !liked"
                    >
                        <q-tooltip> Curtir </q-tooltip>
                    </q-btn>
                    <q-btn
                        flat
                        round
                        color="primary"
                        :icon="saved ? 'bookmark' : 'bookmark_border'"
                        @click="saved = !saved"
                    >
                        <q-tooltip> Salvar </q-tooltip>
                    </q-btn>
                </div>
            </div>
        </q-card-section>
    </q-card>
</template>
