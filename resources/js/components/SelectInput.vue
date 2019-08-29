<template>
    <div>
        <input type="hidden" :name="name" :value="value">

        <v-select
            class="bg-white mt-1"
            :get-option-label="label"
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
        methods: {
            label(it) {
                if (typeof it === 'string') {
                    return it;
                }

                if (it.identifier) {
                    return `[${it.identifier}] ${it.name}`;
                }

                return 'foo';
            }
        },
    };
</script>
