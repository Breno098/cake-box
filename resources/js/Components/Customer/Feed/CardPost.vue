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

    const wantComment = ref(false)

    const seeMoreText = ref(false)

    const textIsHundredOrMoreCharacters = computed(() => props.post.description ? props.post.description.length >= 200 : 0)

    const descriptionComputed = computed(() => {
        if (!props.post.description || seeMoreText.value) {
            return props.post.description;
        }

        if (textIsHundredOrMoreCharacters.value) {
            return props.post.description.substring(0, 200) + '...'
        }

        return props.post.description;
    })

    const show = () => {
        useForm().get(route('customer.post.show', props.post.id))
    }

    const requestComment = useForm({
        content: null
    });

    const sendComment = () => {
        // requestComment.content = null;

        props.post.comments.push({
            creator: 'me',
            content: requestComment.content,
            created_at: '01/02/2023',
        })
    }
</script>

<template>
    <q-card class="rounded-borders">
        <q-card-section class="q-pa-none cursor-pointer" @click="show">
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
                    class="cursor-pointer text-primary"
                    v-if="textIsHundredOrMoreCharacters"
                    v-text="seeMoreText ? 'mostrar menos' : 'mostrar mais'"
                >
                </span>
            </div>

            <div class="q-mt-sm q-mb-xs app-fs-15 text-primary">
                {{ post.tags }}
            </div>
        </q-card-section>

        <q-card-actions>
            <q-space/>

            <div class="text-right q-pt-xs">
                <q-btn
                    flat
                    color="red"
                    :icon="liked ? 'favorite' : 'favorite_border'"
                    @click="toogleLike"
                    no-caps
                    label="Curtir"
                >
                    <q-tooltip> Curtir </q-tooltip>
                </q-btn>
                <q-btn
                    flat
                    color="primary"
                    :icon="saved ? 'bookmark' : 'bookmark_border'"
                    @click="toogleSave"
                    no-caps
                    label="Salvar"
                >
                    <q-tooltip> Salvar </q-tooltip>
                </q-btn>
                <q-btn
                    flat
                    color="grey-8"
                    icon="comment"
                    @click="wantComment = true"
                    no-caps
                    label="Comentar"
                >
                    <q-tooltip> Comentar </q-tooltip>
                </q-btn>
            </div>
        </q-card-actions>

        <q-card-section v-if="wantComment">
            <q-input
                outlined
                label="Adicione um comentário"
                dense
                color="grey-8"
                v-model="requestComment.content"
            />

            <q-btn
                class="q-mt-sm"
                color="grey-8"
                icon="send"
                @click="sendComment"
                no-caps
                label="Enviar"
                size="sm"
                v-if="requestComment.content"
            >
                <q-tooltip> Enviar comentário </q-tooltip>
            </q-btn>
        </q-card-section>

        <q-card-section v-if="wantComment" class="q-pl-xl">
            <q-chat-message
                :name="comment.creator"
                :text="[comment.content]"
                :stamp="comment.created_at"
                bg-color="grey-4"
                v-for="comment in post.comments"
                size="11"
            />
        </q-card-section>
    </q-card>
</template>
