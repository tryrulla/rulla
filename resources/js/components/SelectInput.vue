<template>
    <div>
        <input type="hidden" :name="name" :value="getId(value)">
        <input type="hidden" v-if="typed" :name="name.replace('_id', '_type')" :value="getType(value)">

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
    const isNumber = require('is-number');
    const processNewType = (initialValue, initialType, typed) => {
        if (!typed) {
            return isNumber(initialValue) ? parseInt(initialValue) : null;
        }

        console.log({ initialType, initialValue });
        if (initialType && isNumber(initialValue)) {
            return window.Rulla.identifiers.typeToLetter[initialType] + initialValue.toString().padStart(7, '0');
        }

        return null;
    };

    export default {
        data() {
            return {
                value: processNewType(this.initialValue, this.initialType, this.typed),
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
            initialType: {
                default: null,
            },
            names: {
                type: Object,
                default: () => ({}),
            },
            typed: {
                type: Boolean,
                default: false,
            }
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

                if (this.typed) {
                    return it.identifier;
                }

                if (it.id) {
                    return it.id;
                }

                console.warn('Could not get key for ' + JSON.encode(it));
                return 'foo';
            },
            getType(identifier) {
                if (!identifier) {
                    return null;
                }

                return window.Rulla.identifiers.letterToType[identifier.substr(0, 1)];
            },
            getId(identifier) {
                if (typeof identifier === 'number') {
                    return identifier;
                }

                if (!identifier) {
                    return null;
                }

                return parseInt(identifier.substr(1));
            }
        },
    };
</script>
