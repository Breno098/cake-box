<script setup>
import GuestLayout from '@/Layouts/Admin/GuestLayout.vue';
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
                <q-card bordered class="shadow-1" style="width: 50vw">
                    <q-card-section class="text-center">
                        <p class="text-h5">
                            <!-- {{ $page.props.title }} <br/>  -->
                            Login
                        </p>
                    </q-card-section>

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

                    <q-card-section class="q-pa-none" v-show="canResetPassword">
                        <Link
                            :href="route('admin.auth.forgot-password-form')"
                            style="text-decoration: none"
                            class="flex flex-center"
                        >
                            <div class="text-grey q-mr-sm">
                                Esqueceu a senha?
                            </div>
                            <div class="text-primary">
                                Clique aqui
                            </div>
                        </Link>
                    </q-card-section>

                    <q-card-section class="text-center" v-show="canRegister">
                        <p class="text-grey-6">Not reigistered? Created an Account</p>
                    </q-card-section>

                    <q-card-section class="text-center q-pb-none">
                        <p class="text-grey-6"> {{ (new Date()).getFullYear() }}</p>
                    </q-card-section>
                </q-card>
            </div>
        </div>
    </GuestLayout>
</template>
