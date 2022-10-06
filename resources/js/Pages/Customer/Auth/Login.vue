<script setup>
import { ref } from 'vue'
import GuestLayout from '@/Layouts/Customer/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    canResetPassword: Boolean,
    canRegister: Boolean,
    status: String,
});

const seePass = ref(false);

const form = useForm({
    email: 'breno@email.com',
    password: 'password',
    remember: false
});

const submit = () => {
    form.post(route('customer.auth.login'), {
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
                        <p class="text-h4">
                            {{ $page.props.title }}
                        </p>
                    </q-card-section>

                    <q-card-section>
                        <q-form class="q-gutter-md">
                            <q-input
                                v-model="form.email"
                                type="email"
                                label="E-mail"
                                :bottom-slots="Boolean(form.errors.email)"
                                color="brown-8"
                                bg-color="brown-1"
                                rounded
                                outlined
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ form.errors.email }} </div>
                                </template>
                                <template v-slot:prepend>
                                    <q-icon name="email" class="material-icons-outlined"/>
                                </template>
                            </q-input>

                            <q-input
                                v-model="form.password"
                                :type="seePass ? 'text' : 'password'"
                                label="Senha"
                                :bottom-slots="Boolean(form.errors.password)"
                                color="brown-8"
                                bg-color="brown-1"
                                rounded
                                outlined
                            >
                                <template v-slot:hint>
                                    <div class="text-red"> {{ form.errors.password }} </div>
                                </template>
                                <template v-slot:prepend>
                                    <q-icon name="lock_open"/>
                                </template>
                                <template v-slot:append>
                                    <q-icon
                                        :name="seePass ? 'visibility' : 'visibility_off'"
                                        class="cursor-pointer"
                                        @click="seePass = !seePass"
                                    />
                                </template>
                            </q-input>
                        </q-form>
                    </q-card-section>

                    <q-card-actions class="q-px-md">
                        <q-btn
                            unelevated
                            color="brown-8"
                            size="lg"
                            class="full-width"
                            label="Entrar"
                            @click="submit"
                            rounded
                        />
                    </q-card-actions>

                    <q-card-section class="q-pa-none" v-show="canResetPassword">
                        <Link
                            :href="route('customer.auth.forgot-password-form')"
                            style="text-decoration: none"
                            class="flex flex-center"
                        >
                            <div class="text-grey q-mr-sm">
                                Esqueceu a senha?
                            </div>
                            <div class="text-brown-8">
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
