<script setup>
    import { Link, useForm } from '@inertiajs/inertia-vue3';
    import { ref, computed } from 'vue'
    import { useQuasar } from 'quasar'

    const $q = useQuasar()

    const logout = () => {
        useForm().post(route('customer.auth.logout'));
    }

    const style = computed(() => ({
      height: $q.screen.height + 'px'
    }))
</script>

<template>
    <q-layout view="lHh Lpr lFf">
        <q-header bordered class="bg-brown-8 text-white">
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
                                <!-- <q-toggle v-model="mobileData" label="Use Mobile Data" />
                                <q-toggle v-model="bluetooth" label="Bluetooth" /> -->
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

        </q-header>

        <div class="position-relative bg-grey-4" :style="style">
            <q-page-container class="WAL__layout">
                <q-page padding>
                    <slot />
                </q-page>
            </q-page-container>
        </div>

        <!-- <q-footer bordered class="bg-primary text-white">
            <q-toolbar>
                <q-toolbar-title>
                    <q-avatar>
                        <q-btn icon="account_circle" flat >
                            <q-menu>
                                <div class="row no-wrap q-pa-md">
                                    <div class="column items-center q-pa-lg q-px-xl">
                                        <q-avatar size="72px">
                                            <img src="https://cdn.quasar.dev/img/avatar2.jpg">
                                        </q-avatar>

                                        <div class="text-subtitle1 q-mt-md q-mb-md text-center">
                                            {{ $page.props.auth.user.name.split(' ').shift() }}
                                        </div>

                                        <q-btn
                                            color="primary"
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
                    </q-avatar>
                </q-toolbar-title>
            </q-toolbar>
        </q-footer> -->
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
    max-width: 1200px


</style>
