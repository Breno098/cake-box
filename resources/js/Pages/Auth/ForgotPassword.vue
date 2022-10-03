<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    status: String,
});

const form = useForm({
    email: 'breno@email.com',
});

const submit = () => {
    form.post(route('admin.auth.forgot-password-send-link'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Esqueci minha senha"/>

        <div class="text-center mb-4">
            Esqueceu sua senha? Sem problemas. <br/> Basta nos informar seu endereço de e-mail e nós lhe enviaremos um link de
            redefinição de senha que permitirá que você escolha uma nova.
        </div>

        <div v-if="status" class="text-center mb-3 text-success">
            {{ status }}
        </div>

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

            <button
                class="w-100 btn btn-dark mt-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                type="submit"
            >
                Enviar
            </button>

            <p class="mt-5 mb-3 text-muted text-center">
                {{ (new Date()).getFullYear() }}
            </p>
        </form>
    </GuestLayout>
</template>
