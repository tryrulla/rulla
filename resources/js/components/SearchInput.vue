<template>
    <div>
        <input type="hidden" :name="id + '_id'" :value="getId(value)">
        <input type="hidden" :name="id + '_type'" :value="getType(value)">

        <v-select
            :filterable="false"
            :options="options"
            :get-option-label="label"
            :reduce="getKey"
            v-model="value"
            @search="onSearch"
            v-if="loaded"
        ></v-select>

        <div v-if="showSetSelfButton">
            <button class="hover:underline text-blue-700 text-sm" @click="setSelf" type="button">
                Self
            </button>
        </div>
    </div>
</template>

<script>
import isNumber from 'is-number';
import debounce from 'lodash/debounce';
import axios from '../axios';

export default {
    data() {
        return {
            options: [],
            value: null,
            loaded: false,
            lastSearch: '',
            actualFilter: this.filter,
        };
    },
    props: {
        filter: {
            type: Object,
            required: true,
        },
        id: {
            type: String,
            required: true,
        },
        initialValue: {
            type: String,
            default: null,
        },
        showSetSelfButton: {
            type: Boolean,
            default: false,
        },
        filterStoredAtFieldName: {
            type: String,
            required: false,
        },
        filterStoredAtExtra: {
            type: Object,
            required: false,
        }
    },
    watch: {
        filterStoredAtValue: {
            async handler(newValue) {
                if (this.filterStoredAtValue && this.filterStoredAtExtra && newValue) {
                    this.actualFilter['storage-location'] = { ...this.filterStoredAtExtra };
                    this.actualFilter['storage-location']['id'] = newValue;
                } else {
                    this.actualFilter['storage-location'] = null;
                }
                this.search(value => this.loaded = !value, this.lastSearch, this);
            },
            deep: true,
        },
        value(value) {
            this.$store.dispatch('setValue', { key: this.id + '_id', value: this.getId(value) });
            this.$store.dispatch('setValue', { key: this.id + '_type', value: this.getType(value) });
        },
    },
    computed: {
        filterStoredAtValue() {
            return this.filterStoredAtFieldName ? this.$store.getters.values[this.filterStoredAtFieldName] : null;
        },
    },
    methods: {
        onSearch(search, loading) {
            this.lastSearch = search;
            loading(true);
            this.search(loading, search, this);
        },
        search: debounce((loading, search, vm) => {
            if (search.length === 0) {
                loading(false);
                vm.options = [];
                return;
            }

            axios.post(Rulla.baseUrl + '/app/search', {filters: {query: search, ...vm.actualFilter}})
                .then(({data}) => {
                    vm.options = data.results;

                    if (search === vm.initialValue && vm.options.length === 1) {
                        vm.value = vm.options[0].identifier;
                    }

                    loading(false);
                });
            }, 500),
        label(it) {
            console.log({ it });
            if (typeof it.name === 'object') {
                return `[${it.identifier}] ${it.name[this.language] || it.name['en']}`;
            }

            return `[${it.identifier}] ${it.name || it.tag || ''}`;
        },
        getKey(thing) {
            if (thing == null) {
                return null;
            }

            return thing.identifier;
        },
        getType(identifier) {
            if (typeof identifier === 'object') {
                identifier = this.getKey(identifier);
            }

            if (!identifier) {
                return null;
            }

            return window.Rulla.identifiers.letterToType[identifier.substr(0, 1)];
        },
        getId(identifier) {
            if (typeof identifier === 'object') {
                identifier = this.getKey(identifier);
            }

            if (!identifier) {
                return null;
            }

            return parseInt(identifier.substr(1));
        },
        setSelf() {
            this.loaded = false;
            axios.post(Rulla.baseUrl + '/app/search', {filters: {query: Rulla.currentUser, ...this.actualFilter}})
                .then(({data}) => {
                    this.options = data.results;

                    if (this.options.length === 1) {
                        this.value = this.options[0].identifier;
                    }

                    this.loaded = true;
                });
        },
    },
    mounted() {
        if (this.initialValue) {
            let typeToFetch = this.initialValue;
            if (isNumber(typeToFetch) && typeof this.actualFilter.type === 'string') {
                const type = this.filter.type;
                typeToFetch = window.Rulla.identifiers.typeToLetter[type] + typeToFetch;
            }

            axios.post(Rulla.baseUrl + '/app/search', {filters: {query: typeToFetch, ...this.actualFilter}})
                .then(({data}) => {
                    this.options = data.results;

                    if (this.options.length === 1) {
                        this.value = this.options[0].identifier;
                    }

                    this.loaded = true;
                });
        } else {
            this.loaded = true;
        }
    }
}
</script>
