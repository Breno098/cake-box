<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: 'breno@email.com',
    password: 'passwords',
    remember: false
});

const submit = () => {
    form.post(route('login'), {
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

        <form
            class="w-50"
            @submit.prevent="submit"
        >

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
                href="#"
                v-if="canResetPassword"
            >
                Esqueceu a senha? Clique aqui
            </a>

            <button
                class="w-100 btn btn-lg btn-primary mt-3"
                type="submit"
            >
                Entrar
            </button>

            <p class="mt-5 mb-3 text-muted">
                <!-- © {{ now()->format('Y') }} -->
            </p>

            <!-- <div class="card">
                <div class="card-header">
                    Featured
                    <fa icon="home"/>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div> -->

            <!-- <div>
                <InputLabel for="email" value="Email" />
                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Forgot your password?
                </Link>

                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div> -->
        </form>
    </GuestLayout>
</template>
