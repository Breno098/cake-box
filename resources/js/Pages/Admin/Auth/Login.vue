<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import BInput from '@/Components/BInput.vue';
import BCheckbox from '@/Components/BCheckbox.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    canResetPassword: Boolean,
    canRegister: Boolean,
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

        <div class="column">
            <div class="row">
                <div class="text-h5 q-ml-sm text-white q-mx-auto q-my-md">
                    {{ $page.props.title }} | Login
                </div>
            </div>
            <div class="row">
                <q-card square bordered class="q-pa-lg shadow-1" style="width: 50vw">
                    <q-card-section>
                        <q-form class="q-gutter-md">
                            <q-input
                                filled
                                v-model="form.email"
                                type="email"
                                label="E-mail"
                                :bottom-slots="Boolean(form.errors.email)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ form.errors.email }} </div>
                                </template>
                            </q-input>

                            <q-input
                                filled
                                v-model="form.password"
                                type="password"
                                label="Senha"
                                :bottom-slots="Boolean(form.errors.password)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ form.errors.password }} </div>
                                </template>
                            </q-input>
                        </q-form>
                    </q-card-section>

                    <q-card-actions class="q-px-md">
                        <q-btn
                            unelevated
                            color="primary"
                            size="lg"
                            class="full-width"
                            label="Entrar"
                            @click="submit"
                        />
                    </q-card-actions>

                    <q-card-section class="text-center q-pa-none" v-show="canResetPassword">
                        <Link
                            :href="route('admin.auth.forgot-password-form')"
                            style="text-decoration: none"
                            class="text-grey-6"
                        >
                            Esqueceu a senha? Clique aqui
                        </Link>
                    </q-card-section>

                    <q-card-section class="text-center q-pa-none" v-show="canRegister">
                        <p class="text-grey-6">Not reigistered? Created an Account</p>
                    </q-card-section>
                </q-card>
            </div>
        </div>

        <!-- <div v-if="status" class="text-center">
            {{ status }}
        </div>

        <q-card >
            <q-img
                class="col"
                src="https://cdn.quasar.dev/img/parallax2.jpg"
            >
                <div class="absolute-bottom text-subtitle2 text-center">

                </div>
            </q-img>

            <q-separator />

            <q-card-section >
                <q-card-actions  class="justify-around">
                    <q-btn flat round color="primary" icon="edit" />
                    <q-btn flat round color="red" icon="delete" />
                </q-card-actions>
            </q-card-section>
        </q-card> -->

        <!-- <form class="w-50" @submit.prevent="submit">
            <h1 class="mb-3 fw-normal text-center">
                Login <fa icon="right-to-bracket"/>
            </h1>

            <BInput
                :errorMessage="form.errors.email"
                labelText="E-mail"
                v-model="form.email"
                type="email"
                class="mb-3"
                required
            />

            <BInput
                :errorMessage="form.errors.password"
                labelText="Senha"
                v-model="form.password"
                required
                type="password"
                class="mb-3"
            />

            <BCheckbox
                labelText="Me lembre"
                v-model="form.remember"
            />

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
        </form> -->
    </GuestLayout>
</template>
