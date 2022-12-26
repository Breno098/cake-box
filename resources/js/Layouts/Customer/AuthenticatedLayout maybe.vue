<template>
    <q-layout view="hHh LpR fFf" class="bg-grey-3">
      <q-header class="bg-brown-8 text-white" reveal height-hint="60">
        <q-toolbar class="GPLAY__toolbar">
          <q-btn
            v-if="$q.platform.is.mobile || !leftDrawerOpen"
            flat
            dense
            round
            @click="toggleLeftDrawer"
            aria-label="Menu"
            icon="menu"
            class="q-mr-sm"
          />

          <div class="q-pr-lg text-h5" v-if="$q.screen.gt.xs">
            {{ $page.props.title }}
          </div>

          <q-space />

          <div class="q-pl-md q-gutter-sm row no-wrap items-center">
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
          </div>
        </q-toolbar>
      </q-header>

      <q-drawer
        v-model="leftDrawerOpen"
        show-if-above
        class="bg-grey-3 text-grey-7"
        :width="200"
      >
        <q-list>
          <q-item clickable class="GPLAY__drawer-link bg-brown-8 text-grey-3">
            <q-item-section avatar class="text-grey-1">
              <q-icon name="home" />
            </q-item-section>
            <q-item-section class="text-grey-3">
              <q-item-label>Inicio</q-item-label>
            </q-item-section>
          </q-item>

          <q-item clickable class="GPLAY__drawer-link GPLAY__drawer-link--recipes">
            <q-item-section avatar class="music-icon bg-orange-7 text-grey-1 text-center">
                <q-icon name="menu_book" />
            </q-item-section>
            <q-item-section class="music-text">
              <q-item-label>Receitas</q-item-label>
            </q-item-section>
          </q-item>
<!--
          <q-item clickable class="GPLAY__drawer-link GPLAY__drawer-link--apps">
            <q-item-section avatar class="bg-green-7 text-grey-1 text-center">
              <q-icon name="menu_book" />
            </q-item-section>
            <q-item-section class="apps-text">
              <q-item-label>Receitas</q-item-label>
            </q-item-section>
          </q-item> -->

          <q-item clickable class="GPLAY__drawer-link GPLAY__drawer-link--posts">
            <q-item-section avatar class="movies-icon bg-red-7 text-grey-1 text-center">
              <q-icon name="local_movies" />
            </q-item-section>
            <q-item-section class="movies-text">
              <q-item-label>Postagens</q-item-label>
            </q-item-section>
          </q-item>


          <q-item clickable class="GPLAY__drawer-link GPLAY__drawer-link--books">
            <q-item-section avatar class="books-icon bg-blue-7 text-grey-1 text-center">
              <q-icon name="book" />
            </q-item-section>
            <q-item-section class="books-text">
              <q-item-label>Books</q-item-label>
            </q-item-section>
          </q-item>

          <q-item clickable class="GPLAY__drawer-link GPLAY__drawer-link--devices">
            <q-item-section avatar class="devices-icon bg-blue-grey-7 text-grey-1 text-center">
              <q-icon name="devices" />
            </q-item-section>
            <q-item-section class="devices-text">
              <q-item-label>Devices</q-item-label>
            </q-item-section>
          </q-item>

          <q-separator class="q-mb-md" />

          <q-item v-for="link in links1" :key="link.text" v-ripple dense clickable class="GPLAY__drawer-item">
            <q-item-section class="text-grey-8">
              <q-item-label>{{ link.text }}</q-item-label>
            </q-item-section>
          </q-item>
        </q-list>
      </q-drawer>

        <q-page-container>
            <q-page padding>
                <slot />
            </q-page>
        </q-page-container>
    </q-layout>
  </template>

  <script>
  import { ref } from 'vue'
  import { Link, useForm } from '@inertiajs/inertia-vue3';

  export default {
    name: 'GooglePlayLayout',

    setup () {
        const leftDrawerOpen = ref(false)
        const search = ref('')
        const storage = ref(0.26)
        const logout = () => {
            useForm().post(route('customer.auth.logout'));
        }

        function toggleLeftDrawer () {
            leftDrawerOpen.value = !leftDrawerOpen.value
        }

        return {
            leftDrawerOpen,
            search,
            storage,
            logout,

            links1: [
            { text: 'Account' },
            { text: 'Payment methods' },
            { text: 'My subscriptions' },
            { text: 'Redeem' },
            { text: 'Buy gift card' },
            { text: 'My wishlist' },
            { text: 'My Play activity' },
            { text: 'Parent guide' }
            ],

            toggleLeftDrawer
        }
    }
  }
  </script>

  <style lang="sass">
  .GPLAY

    &__toolbar
      height: 60px

    &__logo
      width: 183px
      height: 39px

    &__drawer-link

      .q-item__section--avatar
        margin: -8px 0 -8px -16px
        padding: 8px 0 8px 16px

      .q-item__section--main
        margin: -8px -16px -8px 16px
        padding: 8px 16px 8px 2px
        font-size: 18px
        font-weight: 300

      &--apps, &--posts, &--recipes, &--books, &--devices
        background: #f5f5f5!important
        &:hover
          color: #eee !important

      &--apps:hover
        background: #43a047!important

      &--posts:hover
        background: #e53935!important

      &--recipes:hover
        background: #fb8c00!important

      &--books:hover
        background: #1e88e5!important

      &--devices:hover
        background: #546e7a!important

    &__drawer-item
      padding: 6px 12px 6px 23px

    &__sticky
      min-height: 49px
      border-bottom: 1px solid rgba(0,0,0,0.12)

    &__sticky-help
      border: 1px solid #ccc
      padding-left: 8px
      padding-right: 8px

    &__sticky-settings
      padding-left: 17px
      padding-right: 17px
      border: 1px solid #ccc
  </style>
