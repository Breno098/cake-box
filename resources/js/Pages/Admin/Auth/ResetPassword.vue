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

        <div class="column">
            <div class="row">
                <q-card bordered class="shadow-1" style="width: 50vw">
                    <q-card-section class="text-center text-green" v-show="status">
                        {{ status }}
                    </q-card-section>

                    <q-card-section>
                        <q-form class="q-gutter-md">
                            <q-input
                                filled
                                v-model="form.password"
                                type="password"
                                label="Nova Senha"
                                :bottom-slots="Boolean(form.errors.password)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ form.errors.password }} </div>
                                </template>
                            </q-input>

                            <q-input
                                filled
                                v-model="form.password_confirmation"
                                type="password"
                                label="Confirme a Senha"
                                :bottom-slots="Boolean(form.errors.password_confirmation)"
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ form.errors.password_confirmation }} </div>
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
                                <div class="q-mr-sm"> Redefinir </div>
                                <q-icon name="lock_reset" size="sm"/>
                            </div>

                            <template v-slot:loading>
                                <div class="q-mr-sm"> Redefinindo... </div>
                                <q-spinner-ios class="on-left" size="sm"/>
                            </template>
                        </q-btn>
                    </q-card-actions>

                    <q-card-section class="text-center q-pb-none">
                        <p class="text-grey-6"> {{ (new Date()).getFullYear() }}</p>
                    </q-card-section>
                </q-card>
            </div>
        </div>
    </GuestLayout>
</template>
