<template>
    <div>
        <input type="hidden" :name="name" :value="value">

        <v-select
            class="bg-white mt-1"
            :get-option-label="label"
            :reduce="getKey"
            :options="options"
            v-model="value"
        />
    </div>
</template>

<script>
    export default {
        data() {
            return {
                value: parseInt(this.initialValue, 10) || this.initialValue,
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
        computed: {
            language() {
                return (window.Rulla || {}).language || 'en';
            },
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
            names: {
                type: Object,
                default: () => {},
            },
        },
        methods: {
            label(it) {
                if (typeof it === 'string') {
                    if (it in this.names) {
                        return this.names[it];
                    }

                    return it;
                }

                if (it.identifier) {
                    if (typeof it.name === 'object') {
                        return `[${it.identifier}] ${it.name[this.language] || it.name['en']}`;
                    }

                    return `[${it.identifier}] ${it.name}`;
                }

                console.warn('Could not get name for ' + JSON.encode(it));
                return 'foo';
            },
            getKey(it) {
                if (typeof it === 'string') {
                    return it;
                }

                if (it.id) {
                    return it.id;
                }

                console.warn('Could not get key for ' + JSON.encode(it));
                return 'foo';
            },
        },
    };
</script>
