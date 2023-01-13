<script setup>
    import AuthenticatedLayout from '@/Layouts/Customer/AuthenticatedLayout.vue';
    import { ref, computed } from 'vue'

    const props = defineProps({
        post: Object
    });

    const slide = ref(0);
</script>

<template>
    <AuthenticatedLayout>
        <div class="row">
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
                            class="fit"
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
        </div>
        {{ post }}
    </AuthenticatedLayout>
</template>
