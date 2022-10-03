<script setup>
    import { Link, Head } from '@inertiajs/inertia-vue3';
    import { ref } from 'vue'

    const leftDrawerOpen = ref(true)
    const miniState = ref(false)
    const rightDrawerOpen = ref(false)

    const toggleLeftDrawer = () => {
        leftDrawerOpen.value = !leftDrawerOpen.value
    }

    const toggleRightDrawer = () => {
        rightDrawerOpen.value = !rightDrawerOpen.value
    }

    const drawerClick = (e) => {
        if (miniState.value) {
          miniState.value = false
          e.stopPropagation()
        }
    }
</script>

<template>
    <Head title="Home"/>

    <q-layout view="hHh lpR lFf">
        <q-header bordered class="bg-primary text-white">
            <q-toolbar>
                <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

                <q-toolbar-title>
                    {{ $page.props.title }}
                </q-toolbar-title>

                <q-btn dense flat round icon="menu" @click="toggleRightDrawer" />
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
                        :active="route().current('ingrdient*')"
                    >
                        <q-item-section avatar>
                            <q-icon name="egg" />
                        </q-item-section>

                        <q-item-section>
                            Ingredientes
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

        <q-drawer v-model="rightDrawerOpen" side="right" overlay bordered>
        <!-- drawer content -->
        </q-drawer>

        <q-page-container>
            <slot />
        </q-page-container>

        <!-- <q-footer bordered class="bg-grey-8 text-white">
        <q-toolbar>
            <q-toolbar-title>
            <q-avatar>
                <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg">
            </q-avatar>
            <div>Title</div>
            </q-toolbar-title>
        </q-toolbar>
        </q-footer> -->

    </q-layout>
</template>
