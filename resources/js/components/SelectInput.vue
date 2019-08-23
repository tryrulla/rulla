<template>
    <div>
        <input type="hidden" :name="name" :value="value">

        <v-select
            class="bg-white shadow mt-1"
            :get-option-label="it => `[${it.identifier}] ${it.name}`"
            :reduce="it => it.id"
            :options="options"
            v-model="value"
        />
    </div>
</template>

<script>
    export default {
        data() {
            return {
                value: parseInt(this.initialValue, 10),
            };
        },
        watch: {
            value(value) {
                this.$store.dispatch('setValue', { key: this.name, value });
            }
        },
        mounted() {
            this.$store.dispatch('setValue', { key: this.name, value: this.initialValue });
        },
        props: {
            name: {
                type: String,
                required: true,
            },
            options: {
                type: Array,
                required: true,
            },
            initialValue: {
                default: null,
            },
        },
    };
</script>
