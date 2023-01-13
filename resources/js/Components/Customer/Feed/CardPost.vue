<script setup>
    import { ref, computed } from 'vue'
    import { useQuasar } from 'quasar'
    import { useForm } from '@inertiajs/inertia-vue3';

    const $q = useQuasar()

    const props = defineProps({
        post: Object
    });

    const slide = ref(0);

    const liked = ref(props.post.liked)
    const saved = ref(props.post.saved)

    const toogleLike = () => {
        useForm().post(route('customer.post.toogle-like', props.post.id), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => liked.value = !liked.value,
        })
    }

    const toogleSave = () => {
        useForm().post(route('customer.post.toogle-save', props.post.id), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => saved.value = !saved.value,
        })
    }

    const show = () => {
        useForm().get(route('customer.post.show', props.post.id))
    }

    const classesRounded = computed(() => $q.screen.lt.sm ? 'app-br-tr-16 app-br-tl-16' : 'app-br-bl-16 app-br-tl-16')

    const seeMoreText = ref(false)

    const textIsHundredOrMoreCharacters = computed(() => props.post.description ? props.post.description.length >= 100 : 0)

    const descriptionComputed = computed(() => {
        if (!props.post.description || seeMoreText.value) {
            return props.post.description;
        }

        if (textIsHundredOrMoreCharacters.value) {
            return props.post.description.substring(0, 100) + '...'
        }

        return props.post.description;
    })
</script>

<template>
    <q-card class="app-br-16 cursor-pointer" @click="show">
        <q-card-section class="row full-height q-pa-none">
            <div class="col-12 col-md-5">
                <q-carousel
                    v-if="post.images.length > 0"
                    animated
                    v-model="slide"
                    infinite
                    autoplay
                    :class="classesRounded"
                    class="fit"
                    ref="carousel"
                >
                    <q-carousel-slide
                        v-for="image, index in post.images"
                        :name="index"
                        class="q-pa-none"
                    >
                        <q-img
                            class="rounded-borders fit"
                            :src="image.link"
                            fit="contain"
                        />
                    </q-carousel-slide>

                    <template v-slot:control v-if="post.images.length > 1">
                        <q-carousel-control
                            position="bottom"
                            :offset="[8, 8]"
                            class="row"
                        >
                            <q-btn
                                dense
                                color="primary"
                                text-color="white"
                                icon="arrow_left"
                                @click="$refs.carousel.previous()"
                                size="sm"
                                class="dimmed"
                            />
                            <q-space/>
                            <q-btn
                                dense
                                color="primary"
                                text-color="white"
                                icon="arrow_right"
                                @click="$refs.carousel.next()"
                                size="sm"
                                class="dimmed"
                            />
                        </q-carousel-control>
                    </template>
                </q-carousel>
            </div>

            <div class="col-12 col-md-7 column q-pa-md app-br-br-16 app-br-tr-16">
                <div class="text-weight-bold text-orange text-overline app-fs-9">
                    <q-icon name="web" class="app-fs-15 q-mr-sm"/>
                    POSTAGEM
                </div>

                <div class="text-h5 text-weight-bold text-primary">
                    {{ post.title }}
                </div>

                <div class="q-mt-sm q-mb-xs">
                    {{ descriptionComputed }}

                    <span
                        @click="seeMoreText = !seeMoreText"
                        class="cursor-pointer text-blue-10"
                        v-if="textIsHundredOrMoreCharacters"
                        v-text="seeMoreText ? 'mostrar menos' : 'mostrar mais'"
                    >
                    </span>
                </div>

                <q-space/>

                <div class="text-right q-pt-xs">
                    <q-btn
                        flat
                        round
                        color="red"
                        :icon="liked ? 'favorite' : 'favorite_border'"
                        @click="toogleLike"
                    >
                        <q-tooltip> Curtir </q-tooltip>
                    </q-btn>
                    <q-btn
                        flat
                        round
                        color="primary"
                        :icon="saved ? 'bookmark' : 'bookmark_border'"
                        @click="toogleSave"
                    >
                        <q-tooltip> Salvar </q-tooltip>
                    </q-btn>
                </div>
            </div>
        </q-card-section>
    </q-card>
</template>
