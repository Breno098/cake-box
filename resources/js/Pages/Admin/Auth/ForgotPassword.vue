<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm, Link } from '@inertiajs/inertia-vue3';

defineProps({
    status: String,
});

const form = useForm({
    email: null,
});

const submit = () => {
    form.post(route('admin.auth.forgot-password-send-link'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Esqueci minha senha"/>

        <div class="column">
            <div class="row">
                <q-card bordered class="shadow-1" style="width: 50vw">
                    <q-card-section class="text-center text-green" v-show="status">
                        {{ status }}
                    </q-card-section>

                    <q-card-section class="text-center">
                        Esqueceu sua senha? Sem problemas. <br/>
                        Basta nos informar seu endereço de e-mail e nós lhe enviaremos um link de
                        redefinição de senha que permitirá que você escolha uma nova.
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
                        </q-form>
                    </q-card-section>

                    <q-card-actions class="q-px-md">
                        <q-btn
                            unelevated
                            color="primary"
                            size="lg"
                            class="full-width"
                            @click="submit"
                            :disabled="form.processing"
                            :loading="form.processing"
                        >
                            <div class="flex flex-center">
                                <div class="q-mr-sm"> Enviar </div>
                                <q-icon name="forward_to_inbox" size="sm"/>
                            </div>

                            <template v-slot:loading>
                                <div class="q-mr-sm"> Enviando... </div>
                                <q-spinner-ios class="on-left" size="sm"/>
                            </template>
                        </q-btn>
                    </q-card-actions>

                    <q-card-section class="q-pa-none">
                        <Link
                            :href="route('admin.auth.sign-in')"
                            style="text-decoration: none"
                            class="flex flex-center text-primary"
                        >
                                Ir para o login
                        </Link>
                    </q-card-section>

                    <q-card-section class="text-center q-pb-none">
                        <p class="text-grey-6"> {{ (new Date()).getFullYear() }}</p>
                    </q-card-section>
                </q-card>
            </div>
        </div>
    </GuestLayout>
</template>
