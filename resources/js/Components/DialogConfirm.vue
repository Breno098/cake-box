<script setup>
  import { useDialogPluginComponent } from 'quasar'

  const props = defineProps({
    title: String,
    message: String,
    html: {
        type: Boolean,
        default: false
    }
  })

  defineEmits([
    ...useDialogPluginComponent.emits
  ])

  const { dialogRef, onDialogHide, onDialogOK, onDialogCancel } = useDialogPluginComponent()
</script>

<template>
    <q-dialog ref="dialogRef" @hide="onDialogHide">
        <q-card
            class="q-dialog-plugin q-pa-md"
            style="width: 550px; border-radius: 10px;"
        >
            <q-card-section class="text-h5 text-center">
                {{ title }}
            </q-card-section>

            <q-card-section>
                <div
                    class="text-center"
                    v-if="html"
                    v-html="message"
                ></div>

                <div class="text-center" v-else>
                    {{ message }}
                </div>
            </q-card-section>

            <q-card-actions align="center">
                <q-btn
                    color="red"
                    no-caps
                    @click="onDialogCancel"
                    label="Cancelar"
                    icon="close"
                >
                </q-btn>

                <q-btn
                    color="green"
                    no-caps
                    @click="onDialogOK"
                    label="Confirmar"
                    icon="check"
                >
                </q-btn>
            </q-card-actions>
        </q-card>
    </q-dialog>
  </template>


