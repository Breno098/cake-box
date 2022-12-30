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

    const classesRounded = computed(() => $q.screen.lt.sm ? 'app-br-tr-16 app-br-tl-16' : 'app-br-bl-16 app-br-tl-16')

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

    const color = (difficulty) => {
        switch (difficulty) {
            case 1: return 'text-green';
            case 2: return 'text-green';
            case 3: return 'text-blue';
            case 4: return 'text-orange';
            case 5: return 'text-red';
            default: return 'text-black';
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
    <q-card class="app-br-16" style="min-height: 150px">
        <q-card-section class="row full-height q-pa-none">
            <div class="col-12 col-md-4">
                <q-img
                    :src="recipe.wallpaper ?? defaultImg"
                    :class="classesRounded"
                    style="min-height: 150px"
                />
            </div>

            <div class="col-12 col-md-8 column q-pa-md app-br-br-16 app-br-tr-16">
                <div class="text-weight-bold text-orange text-overline app-fs-9">
                    <q-icon name="menu_book" class="app-fs-15 q-mr-sm q-mb-xs"/>
                    RECEITAS
                </div>

                <div class="text-h5 text-weight-bold text-primary">
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

                <div class="text-center">
                        <q-separator/>

                        <div class="app-fs-12 row items-center justify-between q-py-xs text-weight-bold">
                            Dificuldade:

                            <div :class="color(recipe.difficulty)">
                                {{ difficulties(recipe.difficulty) }}
                            </div>
                        </div>

                        <q-separator/>

                        <div class="app-fs-12 row items-center justify-between q-py-xs">
                            Tempo para cozinhar

                            <div class="text-orange">
                                {{ recipe.time_to_cook ?? '--:--:--' }}
                            </div>
                        </div>

                        <q-separator/>

                        <div class="app-fs-12 row items-center justify-between q-py-xs">
                            Tempo de preparo

                            <div class="text-orange">
                                {{ recipe.time_to_prepare ?? '--:--:--' }}
                            </div>
                        </div>
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
