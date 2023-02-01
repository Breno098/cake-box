<script setup>
    import { ref, computed } from 'vue'
    import { useQuasar } from 'quasar'

    const $q = useQuasar()

    const props = defineProps({
        recipe: Object
    });

    const defaultImg = '/img/no-image.jpg';

    const liked = ref(false)
    const saved = ref(false)

    const textIsHundredOrMoreCharacters = computed(() => props.recipe.description ? props.recipe.description.length >= 100 : 0)

    const descriptionComputed = computed(() => {
        if (!props.recipe.description) {
            return props.recipe.description;
        }

        if (textIsHundredOrMoreCharacters.value) {
            return props.recipe.description.substring(0, 100) + '...'
        }

        return props.recipe.description;
    })
</script>

<template>
    <q-card class="rounded-borders" style="min-height: 250px">
        <q-card-section class="row q-pa-none">
            <div class="col-12 col-md-4">
                <q-img
                    :src="recipe.wallpaper ?? defaultImg"
                    style="min-height: 250px"
                />
            </div>

            <div class="col-12 col-md-8 column q-pa-md app-br-br-16 app-br-tr-16">
                <div class="text-weight-bold text-orange app-fs-18 flex items-center">
                    <q-icon name="menu_book" class="q-mr-sm"/>
                    {{ recipe.title }}
                </div>

                <div class="q-mt-sm q-mb-xs">
                    {{ descriptionComputed }}

                    <span
                        class="cursor-pointer text-blue-10"
                        v-if="textIsHundredOrMoreCharacters"
                    >
                        ver receita
                    </span>
                </div>

                <q-space/>

                <div class="text-right q-pt-xs">
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
