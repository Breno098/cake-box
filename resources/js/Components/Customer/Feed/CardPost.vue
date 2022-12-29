<script setup>
    import { ref, computed } from 'vue'
    import { useQuasar } from 'quasar'

    const $q = useQuasar()

    const props = defineProps({
        post: Object
    });

    const styleImage = computed(() => ({
        'max-height': fullscreen.value ? '100%' : $q.screen.lt.sm ? '240px' : '250px'
    }))

    const slide = ref(0);

    const fullscreen = ref(false)

    const liked = ref(false)
    const saved = ref(false)

    const classesRounded = computed(() => $q.screen.lt.sm ? 'app-br-tr-16 app-br-tl-16' : 'app-br-bl-16 app-br-tl-16')
</script>

<template>
    <q-card class="app-br-16">
        <q-card-section class="row full-height q-pa-none">
            <div class="col-12 col-md-5">
                <q-carousel
                    v-if="post.images.length > 0"
                    animated
                    v-model="slide"
                    arrows
                    infinite
                    autoplay
                    :class="classesRounded"
                    v-model:fullscreen="fullscreen"
                >
                    <q-carousel-slide
                        v-for="image, index in post.images"
                        :name="index"
                        class="q-pa-none"
                        :img-src="image.link"
                    />

                    <template v-slot:control>
                        <q-carousel-control
                            position="bottom-right"
                            :offset="[10, 10]"
                        >
                            <q-btn
                                dense
                                color="white"
                                size="sm"
                                text-color="orange"
                                :icon="fullscreen ? 'fullscreen_exit' : 'fullscreen'"
                                @click="fullscreen = !fullscreen"
                            />
                        </q-carousel-control>
                    </template>
                </q-carousel>
            </div>

            <div class="col-12 col-md-7 column q-pa-md app-br-br-16 app-br-tr-16">
                <div class="text-weight-bold text-orange text-overline app-fs-9">
                    POSTAGEM
                </div>

                <div class="text-h5 text-weight-bold text-primary">
                    {{ post.title }}
                </div>

                <div class="q-mt-sm q-mb-xs">
                    {{ post.description }}
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
    <!-- <q-card class="app-br-16" >
        <q-card-section class="q-pa-none">
            <q-carousel
                v-if="post.images.length > 0"
                animated
                v-model="slide"
                arrows
                infinite
                autoplay
                class="app-br-tr-16 app-br-tl-16"
                :style="styleImage"
                thumbnails
                v-model:fullscreen="fullscreen"
            >
                <q-carousel-slide
                    v-for="image, index in post.images"
                    :name="index"
                    class="q-pa-none"
                    :img-src="image.link"
                />

                <template v-slot:control>
                    <q-carousel-control
                        position="bottom-right"
                        :offset="[10, 10]"
                    >
                        <q-btn
                            dense
                            color="white"
                            text-color="orange"
                            :icon="fullscreen ? 'fullscreen_exit' : 'fullscreen'"
                            @click="fullscreen = !fullscreen"
                        />
                    </q-carousel-control>
                </template>
            </q-carousel>
        </q-card-section>

        <q-card-section class="q-pt-sm">
            <div class="text-weight-bold text-orange text-overline app-fs-9">
                POSTAGEM
            </div>

            <div class="text-h5 text-weight-bold text-primary">
                {{ post.title }}
            </div>

            <div class="q-mt-sm q-mb-xs">
                {{  post.description }}
            </div>

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
        </q-card-section>
    </q-card> -->
</template>
