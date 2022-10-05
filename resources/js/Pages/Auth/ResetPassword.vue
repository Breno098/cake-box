<script setup>
import GuestLayout from '@/Layouts/Admin/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: 'Senha@098',
    password_confirmation: 'Senha@098',
});

const submit = () => {
    form.post(route('admin.auth.password.reset'), {
        // onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Redefinir a senha"/>

        <form class="w-50" @submit.prevent="submit">
            <div class="form-floating mb-3">
                <input
                    type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    v-model="form.email"
                    required
                    autofocus
                />
                <label for="email">
                    E-mail
                </label>

                <div class="form-text text-danger" v-show="form.errors.email">
                    {{ form.errors.email }}
                </div>
            </div>

            <div class="form-floating mb-3">
                <input
                    type="password"
                    class="form-control"
                    id="password"
                    name="password"
                    v-model="form.password"
                    required
                    autofocus
                />
                <label for="password">
                    Nova Senha
                </label>

                <div class="form-text text-danger" v-show="form.errors.password">
                    {{ form.errors.password }}
                </div>
            </div>

            <div class="form-floating mb-3">
                <input
                    type="password"
                    class="form-control"
                    id="password_confirmation"
                    name="password_confirmation"
                    v-model="form.password_confirmation"
                    required
                    autofocus
                />
                <label for="password_confirmation">
                    Confirme a Senha
                </label>

                <div class="form-text text-danger" v-show="form.errors.password_confirmation">
                    {{ form.errors.password_confirmation }}
                </div>
            </div>

            <button
                class="w-100 btn btn-dark mt-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                type="submit"
            >
                Redefinir
            </button>
        </form>
    </GuestLayout>
</template>
