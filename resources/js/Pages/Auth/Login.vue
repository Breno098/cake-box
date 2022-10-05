<script setup>
import GuestLayout from '@/Layouts/Admin/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: 'breno@email.com',
    password: 'password',
    remember: false
});

const submit = () => {
    form.post(route('admin.auth.login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Entrar" />

        <div v-if="status" class="text-center">
            {{ status }}
        </div>

        <form class="w-50" @submit.prevent="submit">

            <h1 class="mb-3 fw-normal text-center">
                Login <fa icon="right-to-bracket"/>
            </h1>

            <div class="form-floating mb-3">
                <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    v-model="form.email"
                    required
                />
                <label for="email">
                    E-mail
                </label>

                <div class="form-text text-danger" v-show="form.errors.email">
                    {{ form.errors.email }}
                </div>
            </div>

            <div class="form-floating">
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    v-model="form.password"
                    required
                />
                <label for="password">
                    Senha
                </label>

                <div class="form-text text-danger" v-show="form.errors.password">
                    {{ form.errors.password }}
                </div>
            </div>

            <div class="form-check">
                <input
                    class="form-check-input"
                    type="checkbox"
                    v-model="form.remember"
                    id="remember"
                >
                <label class="form-check-label" for="remember">
                    Lembrar
                </label>
            </div>

            <a
                class="btn text-primary mt-2"
                :href="route('admin.auth.forgot-password-form')"
                v-if="canResetPassword"
            >
                Esqueceu a senha? Clique aqui
            </a>

            <button
                class="w-100 btn btn-dark mt-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                type="submit"
            >
                Entrar
            </button>

            <p class="mt-5 mb-3 text-muted text-center">
                {{ (new Date()).getFullYear() }}
            </p>
        </form>
    </GuestLayout>
</template>
