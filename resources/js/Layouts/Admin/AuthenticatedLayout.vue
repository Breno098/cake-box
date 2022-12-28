<script setup>
    import { Link, useForm } from '@inertiajs/inertia-vue3';
    import { ref } from 'vue'
    import { Inertia } from '@inertiajs/inertia';

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

    const goRoute = (routeName) => {
        Inertia.get(route(routeName));
    }

    const menuItems = [{
        items: [{
            route: 'admin.home',
            active: 'admin.home*',
            label: 'Dashboard',
            icon: 'show_chart'
        }]
    }, {
        label: 'RECEITAS',
        items: [{
            route: 'admin.recipe.index',
            active: 'admin.recipe*',
            label: 'Receitas',
            icon: 'menu_book'
        }, {
            route: 'admin.ingredient.index',
            active: 'admin.ingredient*',
            label: 'Ingredientes',
            icon: 'egg'
        }]
    }];
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
                            <div class="column items-center q-pa-lg q-px-xl">
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
                <q-list
                    padding
                    v-for="(menuItem, index) in menuItems"
                    :key="index"
                >
                    <q-item-label header overline class="q-pl-xl">
                        {{ menuItem.label }}
                    </q-item-label>

                    <div
                        v-for="(item, i) in menuItem.items"
                        :key="`menu-item-${i}`"
                    >
                        <q-item
                            v-ripple
                            :active="route().current(item.active)"
                            active-class="bg-blue-2"
                            class="cursor-pointer q-px-lg"
                            @click="goRoute(item.route)"
                            clickable
                        >
                            <q-item-section avatar>
                                <q-icon
                                    :name="item.icon"
                                    :class="route().current(item.active) ? 'text-primary' : 'text-black'"
                                    class="material-icons-outlined"
                                />
                            </q-item-section>

                            <q-item-section
                                :class="route().current(item.active) ? 'text-primary' : 'text-black'"
                            >
                                {{ item.label }}
                            </q-item-section>
                        </q-item>

                        <q-separator/>
                    </div>
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
            <q-page  class="bg-grey-2 q-pa-lg">
                <slot />
            </q-page>
        </q-page-container>
    </q-layout>
</template>
