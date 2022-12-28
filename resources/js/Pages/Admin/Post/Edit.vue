<script setup>
    import AuthenticatedLayout from '@/Layouts/Admin/AuthenticatedLayout.vue';
    import { Head, useForm } from '@inertiajs/inertia-vue3';
    import { useQuasar } from 'quasar'
    import { Inertia } from '@inertiajs/inertia';
    import DialogConfirm from '@/Components/DialogConfirm.vue';
    import { useDropzone } from "vue3-dropzone";

    const $q = useQuasar()

    const props = defineProps({
        post: Object,
        errors: Object,
    });

    const form = useForm({
        id: props.post.id,
        title: props.post.title,
        description: props.post.description,
        link_video: props.post.link_video,
        images: props.post.images,
    });

    const dropZoneImages = useDropzone({
        onDrop: (acceptFiles, rejectReasons) => {
            for (var x = 0; x < acceptFiles.length; x++) {
                form.images.push({
                    id: null,
                    name: acceptFiles[x].name,
                    size: acceptFiles[x].size,
                    link: URL.createObjectURL(acceptFiles[x]),
                    uploadedFile: acceptFiles[x],
                });
            }
        },
        accept: ['image/*']
    });

    const getRootPropsImages = dropZoneImages.getRootProps;
    const getInputPropsImages = dropZoneImages.getInputProps;

    const removeImage = (position) => {
        form.images = [
            ...form.images.slice(0, position),
            ...form.images.slice(position + 1)
        ];
    }

    const submit = () => {
        form
            .transform((data) => ({...data, _method: 'put' }))
            .post(route("admin.post.update", form.id), {
                preserveState: true,
                preserveScroll: true,
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Postagem atualizado com sucesso',
                        position: 'top',
                    })
                },
            })
    };

    function destroy() {
        $q.dialog({
            component: DialogConfirm,
            componentProps: {
                title: 'Excluir postagem',
                message: 'Tem certeza que deseja excluir esse postagem?',
            },
        }).onOk(() => {
            Inertia.delete(route('admin.post.destroy', form.id), {
                onSuccess: () => {
                    $q.notify({
                        type: 'positive',
                        message: 'Postagem excluído com sucesso',
                        position: 'top',
                    })
                }
            })
        });
    }

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
                Inertia.get(route('admin.post.index'))
            })
        } else {
            Inertia.get(route('admin.post.index'))
        }
    }
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Postagem | Editar" />

        <div class="row q-mb-lg">
            <div class="col-6 flex justify-start items-center">
                <q-icon name="web" size="md"/>
                <div class="text-h5 q-ml-sm"> Postagem | Editar </div>
            </div>

            <div class="col-6 flex justify-end items-center">
                <q-btn
                    color="primary"
                    label="Voltar para listagem"
                    icon="chevron_left"
                    no-caps
                    @click="goIndex"
                    class="q-mr-md"
                />

                <q-btn
                    color="red"
                    label="Excluir postagem"
                    icon="close"
                    no-caps
                    @click="destroy"
                    :disabled="form.processing"
                    outline
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
                        v-model="form.title"
                        label="Título"
                        :bottom-slots="Boolean(errors.title)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.title }} </div>
                        </template>
                    </q-input>
                </div>
                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.description"
                        label="Descrição"
                        :bottom-slots="Boolean(errors.description)"
                        type="textarea"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.description }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12 col-md-12">
                    <q-input
                        outlined
                        v-model="form.link_video"
                        label="Link de vídeo"
                        :bottom-slots="Boolean(errors.link_video)"
                    >
                        <template v-slot:hint>
                            <div class="text-red"> {{ errors.link_video }} </div>
                        </template>
                    </q-input>
                </div>

                <div class="col-12">
                    <div
                        v-bind="getRootPropsImages()"
                        class="column flex-center q-py-md text-grey-8 app-border-dashed-blue rounded-borders"
                    >
                        <input v-bind="getInputPropsImages()"/>
                        <q-icon name="collections" size="md"/>
                        <div class="q-mt-sm">Clique aqui ou arraste imagens para postagem</div>
                    </div>
                </div>

                <div class="col-12 row q-col-gutter-lg">
                    <div class="col-12 col-md-3" v-for="(image, index) in form.images" :key="`image-${index}}}`">
                        <q-img :src="image.link" style="height: 240px" class="rounded-borders">
                            <div class="absolute-bottom text-subtitle2 flex flex-center">
                                <q-icon name="collections" size="sm" class="q-mr-md"/>

                                <div class="column">
                                    <span class="text-caption">
                                        {{ image.name.length > 25 ? image.name.slice(0, 25) + '...' : image.name }}
                                    </span>

                                    <span class="text-caption"> ({{ image.size ?? 0 }} kb) </span>
                                </div>

                                <q-space/>

                                <q-btn flat icon="close" @click="removeImage(index)">
                                    <q-tooltip> Remover imagem </q-tooltip>
                                </q-btn>
                            </div>
                        </q-img>
                    </div>
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
