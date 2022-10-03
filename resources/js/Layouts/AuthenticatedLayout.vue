<script setup>
    import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div style="background: rgba(242, 243, 245, 0.1)" class="vh-100">
        <nav class="navbar navbar-expand-lg navbar-light my-color">
            <div class="container">
                <Link :href="route('admin.dashboard')" class="navbar-brand">
                    LOGO
                </Link>

                <button
                    class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent"
                    aria-expanded="false"
                    ria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">
                                Exemplo
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" :href="route('admin.recipe.index')">
                                Receitas
                            </a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Perfil
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        {{ $page.props.auth.user.name }}
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <Link
                                        :href="route('admin.auth.logout')"
                                        class="dropdown-item"
                                        method="post"
                                        as="button"
                                    >
                                       Sair
                                    </Link>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <header class="container py-2 px-2" v-if="$slots.header">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header"/>
            </div>
        </header>

        <main >
            <slot />
        </main>
    </div>
</template>
