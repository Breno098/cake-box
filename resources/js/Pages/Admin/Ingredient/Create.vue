<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm, Link } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'

    const $q = useQuasar()

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
                        message: 'Ingrediente salvo com sucesso',
                        position: 'top',
                    })
                },
            })
    };
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Ingrediente | Adicionar" />

        <div class="row">
            <div class="flex col-6 q-mb-md items-center q-px-sm">
                <q-icon name="egg" size="sm"/>
                <div class="text-h6 q-ml-sm"> Ingrediente | Adicionar </div>
            </div>

            <div class="col-6 q-mb-md q-px-sm row justify-end">
                <q-btn
                    color="green"
                    label="Salvar"
                    icon="save"
                    :disabled="form.processing"
                    :class="{ 'opacity-25': form.processing }"
                    @click="submit"
                    rounded
                />
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-12 q-mb-md q-px-sm">
                <q-input
                    filled
                    v-model="form.name"
                    label="Nome"
                    :bottom-slots="Boolean(form.errors.name)"
                >
                    <template v-slot:hint>
                        <div class="text-red"> {{ form.errors.name }} </div>
                    </template>
                </q-input>
            </div>

            <div class="row col-12 q-mb-md items-center q-px-sm">
                <q-icon name="table_view" size="sm"/>
                <div class="text-h6 q-ml-sm"> Nutricional </div>
            </div>

            <div class="col-12 col-md-3 q-mb-md q-px-sm">
                <q-input
                    filled
                    v-model="form.kcal"
                    label="Calorias"
                    :bottom-slots="Boolean(form.errors.kcal)"
                    type="number"
                >
                    <template v-slot:hint>
                        <div class="text-red"> {{ form.errors.kcal }} </div>
                    </template>
                </q-input>
            </div>

            <div class="col-12 col-md-3 q-mb-md q-px-sm">
                <q-input
                    filled
                    v-model="form.fat"
                    label="Gordura"
                    :bottom-slots="Boolean(form.errors.fat)"
                    type="number"
                >
                    <template v-slot:hint>
                        <div class="text-red"> {{ form.errors.fat }} </div>
                    </template>
                </q-input>
            </div>

            <div class="col-12 col-md-3 q-mb-md q-px-sm">
                <q-input
                    filled
                    v-model="form.saturates"
                    label="Saturação"
                    :bottom-slots="Boolean(form.errors.saturates)"
                    type="number"
                >
                    <template v-slot:hint>
                        <div class="text-red"> {{ form.errors.saturates }} </div>
                    </template>
                </q-input>
            </div>

            <div class="col-12 col-md-3 q-mb-md q-px-sm">
                <q-input
                    filled
                    v-model="form.carbs"
                    label="Carboidratos"
                    :bottom-slots="Boolean(form.errors.carbs)"
                    type="number"
                >
                    <template v-slot:hint>
                        <div class="text-red"> {{ form.errors.carbs }} </div>
                    </template>
                </q-input>
            </div>

            <div class="col-12 col-md-3 q-mb-md q-px-sm">
                <q-input
                    filled
                    v-model="form.sugars"
                    label="Açucar"
                    :bottom-slots="Boolean(form.errors.sugars)"
                    type="number"
                >
                    <template v-slot:hint>
                        <div class="text-red"> {{ form.errors.sugars }} </div>
                    </template>
                </q-input>
            </div>

            <div class="col-12 col-md-3 q-mb-md q-px-sm">
                <q-input
                    filled
                    v-model="form.fibre"
                    label="Fibras"
                    :bottom-slots="Boolean(form.errors.fibre)"
                    type="number"
                >
                    <template v-slot:hint>
                        <div class="text-red"> {{ form.errors.fibre }} </div>
                    </template>
                </q-input>
            </div>

            <div class="col-12 col-md-3 q-mb-md q-px-sm">
                <q-input
                    filled
                    v-model="form.protein"
                    label="Proteínas"
                    :bottom-slots="Boolean(form.errors.protein)"
                    type="number"
                >
                    <template v-slot:hint>
                        <div class="text-red"> {{ form.errors.protein }} </div>
                    </template>
                </q-input>
            </div>

            <div class="col-12 col-md-3 q-mb-md q-px-sm">
                <q-input
                    filled
                    v-model="form.salt"
                    label="Sal"
                    :bottom-slots="Boolean(form.errors.salt)"
                    type="number"
                >
                    <template v-slot:hint>
                        <div class="text-red"> {{ form.errors.salt }} </div>
                    </template>
                </q-input>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
