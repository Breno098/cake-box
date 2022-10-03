<script setup>
    defineProps([
        'value',
        'errorMessage',
        'successMessage',
        'modelValue',
        'labelText',
        'type',
        'required'
    ]);

    defineEmits(['update:modelValue']);
</script>

<template>
    <div class="form-floating">
        <input
            class="form-control"
            :class="{
                'is-invalid': errorMessage,
                'is-valid': successMessage
            }"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            :type="type"
            :required="required"
        />
        <label for="email">
            {{ labelText }}
        </label>

        <div class="form-text text-danger" v-show="errorMessage">
            {{ errorMessage }}
        </div>

        <div class="form-text text-success" v-show="successMessage">
            {{ successMessage }}
        </div>
    </div>
</template>
