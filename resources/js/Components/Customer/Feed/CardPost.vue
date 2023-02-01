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
    <q-card class="rounded-borders">
        <!-- <q-card-section>
            <div class="text-weight-bold text-orange text-overline app-fs129">
                <q-icon name="web" class="app-fs-15 q-mr-sm"/>
                POST
            </div>
        </q-card-section> -->

        <q-card-section class="q-pa-none">
                <q-carousel
                    v-if="post.images.length > 0"
                    animated
                    v-model="slide"
                    infinite
                    autoplay
                    class="fit"
                    ref="carousel"
                >
                    <q-carousel-slide
                        v-for="image, index in post.images"
                        :name="index"
                        class="q-pa-none"
                    >
                        <q-img
                            :src="image.link"
                            fit="contain"
                        />
                    </q-carousel-slide>
                </q-carousel>
        </q-card-section>

        <q-card-section>
            <div class="text-weight-bold text-orange app-fs-18 flex items-center">
                <q-icon name="web" class="q-mr-sm"/>
                {{ post.title }}
            </div>

            <div class="q-mt-sm q-mb-xs app-fs-15">
                {{ descriptionComputed }}

                <span
                    @click="seeMoreText = !seeMoreText"
                    class="cursor-pointer text-blue-10"
                    v-if="textIsHundredOrMoreCharacters"
                    v-text="seeMoreText ? 'mostrar menos' : 'mostrar mais'"
                >
                </span>
            </div>
        </q-card-section>

        <q-card-actions>
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
        </q-card-actions>
    </q-card>
</template>
