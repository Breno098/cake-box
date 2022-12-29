  <!-- <q-splitter v-model="splitterModel"> -->
                        <!-- <template v-slot:before> -->
                            <!-- <q-carousel
                                v-if="recipe.images.length > 0"
                                animated
                                v-model="slides[indexR]"
                                arrows
                                infinite
                                autoplay
                                height="350px"
                                class="app-br-bl-16 app-br-tl-16"
                            >
                                <q-carousel-slide
                                    v-for="image, index in recipe.images"
                                    :name="index"
                                    class="column no-wrap q-pa-none"
                                >
                                    <q-img
                                        class="rounded-borders fit"
                                        :src="image.link"
                                    >
                                        <div class="transparent">
                                            <q-icon
                                                name="star"
                                                :color="recipe.rating >= star ? 'orange' : 'grey-4'"
                                                v-for="star in [1, 2, 3, 4, 5]"
                                            />
                                        </div>
                                    </q-img>
                                </q-carousel-slide>
                            </q-carousel> -->

<!--
const styleImage = computed(() => ({
    // width: verifiedWidth()
    height: $q.screen.lt.sm ? '200px' : '400px'
}))

const slide = ref(0);

const verifiedWidth = () => {
    if(props.post.images.length === 1){
        return '100%';
    }

    if ($q.screen.lt.sm) {
        return $q.screen.height / 3 + 'px';
    }

    if(props.post.images.length === 2){
        return $q.screen.height + 'px';
    }

    return '400px';
}

<q-scroll-area style="height: 230px; ">
    <div class="row no-wrap q-pa-none">
        <div
            v-for="image in post.images"
            v-bind:style="styleImage"
        >
            <q-img
                class="rounded-borders"
                :src="image.link"
                style="height: 230px;"
            />
        </div>
    </div>
</q-scroll-area> -->
