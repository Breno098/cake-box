<script setup>
    import { Link, useForm } from '@inertiajs/inertia-vue3';
    import { ref } from 'vue'

    const leftDrawerOpen = ref(true)
    const miniState = ref(false)

    const toggleLeftDrawer = () => {
        leftDrawerOpen.value = !leftDrawerOpen.value
    }

    const drawerClick = (e) => {
        if (miniState.value) {
          miniState.value = false
          e.stopPropagation()
        }
    }

    const logout = () => {
        useForm().post(route('admin.auth.logout'));
    }
</script>

<template>
    <q-layout view="hHh lpR lFf">
        <q-header bordered class="bg-primary text-white">
            <q-toolbar>
                <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

                <q-toolbar-title>
                    {{ $page.props.title }}
                </q-toolbar-title>

                <q-btn icon="account_circle" flat >
                    <q-menu>
                        <div class="row no-wrap q-pa-md">
                            <!-- <div class="column"> -->
                                <!-- <div class="text-h6 q-mb-md">Settings</div> -->
                                <!-- <q-toggle v-model="mobileData" label="Use Mobile Data" />
                                <q-toggle v-model="bluetooth" label="Bluetooth" /> -->
                            <!-- </div> -->

                            <!-- <q-separator vertical inset class="q-mx-lg" /> -->

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
            </q-toolbar>
        </q-header>

        <q-drawer
            v-model="leftDrawerOpen"
            :mini="!leftDrawerOpen || miniState"
            @click.capture="drawerClick"
            :width="250"
            :breakpoint="500"
            bordered
            class="bg-grey-3"
        >
            <q-scroll-area class="fit">
                <q-list padding>
                    <q-item
                        clickable
                        v-ripple
                        :active="route().current('admin.home')"
                    >
                        <q-item-section avatar>
                            <q-icon name="home" />
                        </q-item-section>

                        <q-item-section>
                            <Link
                                :href="route('admin.home')"
                                :class="route().current('admin.home') ? 'text-primary' : 'text-dark'"
                                style="text-decoration: none"
                            >
                                Home
                            </Link>
                        </q-item-section>
                    </q-item>

                    <q-item
                        clickable
                        v-ripple
                        :active="route().current('admin.recipe.*')"
                    >
                        <q-item-section avatar>
                            <q-icon name="menu_book" />
                        </q-item-section>

                        <q-item-section>
                            <Link
                                :href="route('admin.recipe.index')"
                                style="text-decoration: none"
                                :class="route().current('admin.recipe.*') ? 'text-primary' : 'text-dark'"
                            >
                                Receitas
                            </Link>
                        </q-item-section>
                    </q-item>

                    <q-item
                        clickable
                        v-ripple
                        :active="route().current('ingredient*')"
                    >
                        <q-item-section avatar>
                            <q-icon name="egg" />
                        </q-item-section>

                        <q-item-section>
                            <Link
                                :href="route('admin.ingredient.index')"
                                style="text-decoration: none"
                                :class="route().current('admin.ingredient.*') ? 'text-primary' : 'text-dark'"
                            >
                                Ingredientes
                            </Link>

                        </q-item-section>
                    </q-item>
                </q-list>
            </q-scroll-area>

            <div class="absolute" style="top: 15px; right: -17px">
                <q-btn
                    dense
                    round
                    unelevated
                    color="primary"
                    :icon="miniState ? 'chevron_right' : 'chevron_left' "
                    @click="miniState = true"
                />
            </div>
        </q-drawer>

        <q-page-container>
            <q-page padding>
                <slot />
            </q-page>
        </q-page-container>

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
