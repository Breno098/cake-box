<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'
    import { Inertia } from '@inertiajs/inertia';
    import DialogConfirm from '@/Components/DialogConfirm.vue';
    import { ref } from 'vue'
    import { useDropzone } from "vue3-dropzone";

    const $q = useQuasar()

    const props = defineProps({
        errors: Object,
    });

    const form = useForm({
        id: null,
        name: null,
        email: null,
        whatsapp: null,
        instagram: null,
        facebook: null,
        linkedin: null,
        phone: null,
        cellphone: null,
        info: null,
        web_site: null,
        specialty: null,
        photo: null,
    });

    const dropZonePhoto = useDropzone({
        onDrop: (acceptFiles, rejectReasons) => {
            form.photo = acceptFiles[0];
            photoSrc.value = URL.createObjectURL(acceptFiles[0]);
        },
        accept: ['image/*'],
        maxFiles: 1
    });

    const photoSrc = ref(null)

    const getRootPropsPhoto = dropZonePhoto.getRootProps;
    const getInputPropsPhoto = dropZonePhoto.getInputProps;

    const removePhoto = () => {
        form.photo = null;
        photoSrc.value = null;
    }

    const submit = () => {
        form.post(route("admin.person.store"), {
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => {
                $q.notify({
                    type: 'positive',
                    message: 'Pessoa cadastrada com sucesso',
                    position: 'top',
                })
            },
        })
    };

    const goIndex = () => {
        if (form.isDirty) {
            $q.dialog({
                component: DialogConfirm,
                componentProps: {
                    title: 'Dados não salvos',
                    html: true,
                    message: `Ao voltar dados serão descartados. <br/> Deseja descartar alterações?`,
                },
            }).onOk(() => {
                Inertia.get(route('admin.person.index'))
            })
        } else {
            Inertia.get(route('admin.person.index'))
        }
    }
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Pessoa | Cadastrar" />

        <div class="row q-mb-lg">
            <div class="col-6 flex justify-start items-center">
                <q-icon name="web" size="md"/>
                <div class="text-h5 q-ml-sm"> Pessoa | Cadastrar </div>
            </div>

            <div class="col-6 flex justify-end items-center">
                <q-btn
                    color="primary"
                    label="Voltar para listagem"
                    icon="chevron_left"
                    no-caps
                    @click="goIndex"
                />
            </div>
        </div>

        <q-card class="q-py-lg q-px-lg">
            <div class="row q-col-gutter-lg">
                <div class="row col-12 items-center">
                    <q-icon name="info" size="sm"/>
                    <div class="text-h6 q-ml-sm"> Informações </div>
                </div>

                <div class="col-12 " v-if="photoSrc">
                    <q-img
                        :src="photoSrc"
                        style="width: 250px; height: 250px"
                        class="rounded-borders"
                    >
                        <div class="absolute-bottom text-subtitle2 flex flex-center">
                            <div class="flex cursor-pointer" v-bind="getRootPropsPhoto()">
                                <input v-bind="getInputPropsPhoto()"/>
                                <q-icon name="edit" size="sm" class="q-mr-md"/>
                                Alterar imagem
                            </div>

                            <q-space/>

                            <q-btn flat icon="close" @click="removePhoto">
                                <q-tooltip> Remover capa </q-tooltip>
                            </q-btn>
                        </div>
                    </q-img>
                </div>

                <div class="col-12" v-else>
                    <div
                        v-bind="getRootPropsPhoto()"
                        class="column flex-center q-py-md text-grey-8 app-border-dashed-blue rounded-borders"
                    >
                        <input v-bind="getInputPropsPhoto()"/>
                        <q-icon name="image" size="md"/>
                        <div class="q-mt-sm">Clique aqui ou arraste a imagem</div>
                    </div>
                </div>

                <div class="col-12 col-md-8">
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

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.specialty"
                        label="Especialidade"
                        :bottom-slots="Boolean(errors.specialty)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.specialty }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.info"
                        label="Informações"
                        :bottom-slots="Boolean(errors.info)"
                        type="textarea"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.info }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.web_site"
                        label="Site"
                        :bottom-slots="Boolean(errors.web_site)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.web_site }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="row col-12 items-center">
                    <q-icon name="perm_phone_msg" size="sm"/>
                    <div class="text-h6 q-ml-sm"> Contatos </div>
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.whatsapp"
                        label="Whatsapp"
                        :bottom-slots="Boolean(errors.whatsapp)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.whatsapp }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.instagram"
                        label="Instagram"
                        :bottom-slots="Boolean(errors.instagram)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.instagram }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.facebook"
                        label="Facebook"
                        :bottom-slots="Boolean(errors.facebook)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.facebook }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.linkedin"
                        label="LinkedIn"
                        :bottom-slots="Boolean(errors.linkedin)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.linkedin }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.phone"
                        label="Telefone"
                        :bottom-slots="Boolean(errors.phone)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.phone }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-4">
                    <q-input
                        outlined
                        v-model="form.cellphone"
                        label="Celular"
                        :bottom-slots="Boolean(errors.cellphone)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.cellphone }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 flex justify-end">
                    <q-btn
                        color="green"
                        label="Salvar"
                        icon="check"
                        no-caps
                        @click="submit"
                        :disabled="form.processing"
                    />
                </div>
            </div>
        </q-card>
    </AuthenticatedLayout>
</template>
