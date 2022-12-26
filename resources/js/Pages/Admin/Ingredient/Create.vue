<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'
    import { Inertia } from '@inertiajs/inertia';
    import DialogConfirm from '@/Components/DialogConfirm.vue';

    const $q = useQuasar()

    const props = defineProps({
        errors: Object,
    });

    const form = useForm({
        id: null,
        name: null,
        unit_measure: null,
        kcal: null,
        fat: null,
        saturates: null,
        carbs: null,
        sugars: null,
        fibre: null,
        protein: null,
        salt: null,
        image: null,
    });

    const submit = () => {
        form.post(route("admin.ingredient.store"), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Ingrediente cadastrado com sucesso',
                        position: 'top',
                    })
                },
            })
    };
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Ingrediente | Novo" />

         <div class="row q-mb-lg">
            <div class="col-6 flex justify-start items-center">
                <q-icon name="egg" size="md"/>
                <div class="text-h5 q-ml-sm"> Ingrediente | Novo </div>
            </div>

            <div class="col-6 flex justify-end items-center">
                <q-btn
                    color="green"
                    label="Cadastrar"
                    icon="check"
                    no-caps
                    @click="submit"
                    :disabled="form.processing"
                />
            </div>
        </div>

        <q-card class="q-py-lg q-px-lg">
            <div class="row q-col-gutter-lg">
                <div class="row col-12 items-center">
                    <q-icon name="info" size="sm"/>
                    <div class="text-h6 q-ml-sm"> Informações </div>
                </div>

                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.name"
                        label="Nome"
                        :bottom-slots="Boolean(errors.name)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.name }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="row col-12 items-center">
                    <q-icon name="table_view" size="sm"/>
                    <div class="text-h6 q-ml-sm"> Nutricional </div>
                </div>

                <div class="col-12 col-md-3">
                    <q-input
                        outlined
                        v-model="form.kcal"
                        label="Calorias"
                        :bottom-slots="Boolean(errors.kcal)"
                        type="number"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.kcal }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-3">
                    <q-input
                        outlined
                        v-model="form.fat"
                        label="Gordura"
                        :bottom-slots="Boolean(errors.fat)"
                        type="number"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.fat }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-3">
                    <q-input
                        outlined
                        v-model="form.saturates"
                        label="Saturação"
                        :bottom-slots="Boolean(errors.saturates)"
                        type="number"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.saturates }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-3">
                    <q-input
                        outlined
                        v-model="form.carbs"
                        label="Carboidratos"
                        :bottom-slots="Boolean(errors.carbs)"
                        type="number"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.carbs }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-3">
                    <q-input
                        outlined
                        v-model="form.sugars"
                        label="Açucar"
                        :bottom-slots="Boolean(errors.sugars)"
                        type="number"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.sugars }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-3">
                    <q-input
                        outlined
                        v-model="form.fibre"
                        label="Fibras"
                        :bottom-slots="Boolean(errors.fibre)"
                        type="number"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.fibre }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-3">
                    <q-input
                        outlined
                        v-model="form.protein"
                        label="Proteínas"
                        :bottom-slots="Boolean(errors.protein)"
                        type="number"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.protein }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-3">
                    <q-input
                        outlined
                        v-model="form.salt"
                        label="Sal"
                        :bottom-slots="Boolean(errors.salt)"
                        type="number"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.salt }} </div>
                        </template>
                    </q-input>
                </div>
            </div>
        </q-card>
    </AuthenticatedLayout>
</template>
