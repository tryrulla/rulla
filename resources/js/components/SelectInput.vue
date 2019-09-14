<template>
    <div>
        <input type="hidden" :name="name" :value="getId(value)">
        <input type="hidden" v-if="typed" :name="name.replace('_id', '_type')" :value="getType(value)">

        <v-select
            class="bg-white mt-1"
            :get-option-label="label"
            :reduce="getKey"
            :options="allOptions"
            v-model="value"
        />
    </div>
</template>

<script>
    const isNumber = require('is-number');
    import axios from '../axios';

    const processNewType = (initialValue, initialType, typed) => {
        if (!typed) {
            return isNumber(initialValue) ? parseInt(initialValue) : initialValue;
        }

        if (initialType && isNumber(initialValue)) {
            return window.Rulla.identifiers.typeToLetter[initialType] + initialValue.toString().padStart(7, '0');
        }

        return null;
    };

    export default {
        data() {
            return {
                value: processNewType(this.initialValue, this.initialType, this.typed),
                extraValues: [],
            };
        },
        watch: {
            value(value) {
                this.$store.dispatch('setValue', { key: this.name, value });
            },
            extraValuesFieldValue: {
                async handler(newValue) {
                    if (this.processExtraValuesField && this.processExtraValuesUrl && newValue) {
                        const url = window.Rulla.baseUrl + this.processExtraValuesUrl.replace('{id}', newValue.toString());
                        const { data } = await axios.get(url);

                        this.extraValues = data;
                    } else {
                        this.extraValues = [];
                    }
                },
                deep: true,
            },
        },
        mounted() {
            this.$store.dispatch('setValue', { key: this.name, value: this.initialValue });
        },
        computed: {
            language() {
                return (window.Rulla || {}).language || 'en';
            },
            extraValuesFieldValue() {
                return this.processExtraValuesField ? this.$store.getters.values[this.processExtraValuesField] : null;
            },
            allOptions() {
                return this.options.concat(this.extraValues);
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
            },
            processExtraValuesField: {
                type: String,
                default: null,
            },
            processExtraValuesUrl: {
                type: String,
                default: null,
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

                    return `[${it.identifier}] ${it.name || it.tag}`;
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

                if (this.names && Object.keys(this.names).length > 0) {
                    return identifier;
                }

                return parseInt(identifier.substr(1));
            }
        },
    };
</script>
