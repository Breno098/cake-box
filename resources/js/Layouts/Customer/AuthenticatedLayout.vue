<script setup>
    import { Link, useForm } from '@inertiajs/inertia-vue3';
    import { ref, computed } from 'vue'
    import { useQuasar } from 'quasar'
    import { Inertia } from '@inertiajs/inertia';

    const $q = useQuasar()

    const logout = () => {
        useForm().post(route('customer.auth.logout'));
    }

    const style = computed(() => ({
      height: $q.screen.height + 'px'
    }))

    const tab = ref('home')

    const tabRoute =  computed(() => {
        return route().current('*recipe*') ? 'recipes' : 'home'
    })

    const goFeedTab = () => {
        Inertia.get(route('customer.home'))
    }

    const goRecipeTab = () => {
        Inertia.get(route('customer.recipe.index'))
    }
</script>

<template>
    <q-layout view="lHh Lpr lFf">
        <!-- <q-header bordered class="bg-brown-8 text-white">
            <q-toolbar>
                <div class="q-pr-lg text-h5" v-if="$q.screen.gt.xs">
                    {{ $page.props.title }}
                </div>

                <q-space />

                <q-btn round dense flat icon="notifications">
                    <q-badge color="red" text-color="white" floating>
                        2
                    </q-badge>
                    <q-tooltip>Notificações</q-tooltip>
                </q-btn>

                <q-btn flat round>
                    <q-avatar size="26px">
                        <img src="https://cdn.quasar.dev/img/avatar2.jpg">
                    </q-avatar>

                    <q-tooltip>Perfil</q-tooltip>

                    <q-menu>
                        <div class="row no-wrap q-pa-md">
                            <div class="column">
                                <div class="text-h6 q-mb-md">Configurações</div>
                                <q-toggle v-model="mobileData" label="Use Mobile Data" />
                                <q-toggle v-model="bluetooth" label="Bluetooth" />
                            </div>

                            <q-separator vertical inset class="q-mx-lg" />

                            <div class="column items-center q-pa-lg q-px-xl">
                                <q-avatar size="72px">
                                    <img src="https://cdn.quasar.dev/img/avatar2.jpg">
                                </q-avatar>

                                <div class="text-subtitle1 q-mt-md q-mb-md text-center">
                                    {{ $page.props.auth.user.name.split(' ').shift() }}
                                </div>

                                <q-btn
                                    color="brown-8"
                                    push
                                    size="sm"
                                    v-close-popup
                                    @click="logout"
                                    label="Sair"
                                />
                            </div>
                        </div>
                    </q-menu>
                </q-btn>
            </q-toolbar>
        </q-header> -->

        <div class="position-relative bg-grey-4">
            <q-page-container class="WAL__layout">
                <q-page padding>
                    <slot />
                </q-page>
            </q-page-container>
        </div>

        <q-footer class="bg-grey-4">
            <q-tabs
                v-model="tabRoute"
                class="fit"
            >
                <q-tab
                    name="home"
                    icon="home"
                    class="text-primary"
                    @click="goFeedTab"
                >
                    <q-tooltip>Home</q-tooltip>
                </q-tab>

                <q-tab
                    name="recipes"
                    icon="menu_book"
                    class="text-primary"
                    @click="goRecipeTab"
                >
                    <q-tooltip>Receitas</q-tooltip>
                </q-tab>

                <q-tab
                    name="people"
                    icon="contact_mail"
                    class="text-primary"
                >
                    <q-tooltip>Profissionais</q-tooltip>
                </q-tab>

                <q-tab
                    name="store"
                    icon="local_grocery_store"
                    class="text-primary"
                >
                    <q-tooltip>Loja</q-tooltip>
                </q-tab>

                <q-tab
                    name="perfil"
                    icon="account_circle"
                    class="text-black"
                >
                    <q-tooltip>Perfil</q-tooltip>
                </q-tab>
            </q-tabs>
        </q-footer>
    </q-layout>
</template>

<style lang="sass">
.WAL
  width: 100%
  height: 100%
  padding-top: 20px
  padding-bottom: 20px

  &__layout
    margin: 0 auto
    z-index: 4000
    height: 100%
    width: 90%
    max-width: 1100px
</style>
