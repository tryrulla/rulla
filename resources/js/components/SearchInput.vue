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
        ></v-select>
    </div>
</template>

<script>
import debounce from 'lodash/debounce';
import axios from '../axios';

export default {
    data() {
        return {
            options: [],
            value: null,
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
    },
    methods: {
        onSearch(search, loading) {
            loading(true);
            this.search(loading, search, this);
        },
        search: debounce((loading, search, vm) => {
            axios.post(Rulla.baseUrl + '/app/search', {filters: {query: search, ...vm.filter}})
                .then(({data}) => {
                    vm.options = data.results;

                    if (search === vm.initialValue && vm.options.length === 1) {
                        vm.value = vm.options[0].identifier;
                    }

                    loading(false);
                });
            }, 500),
        label(it) {
            if (typeof it.name === 'object') {
                return `[${it.identifier}] ${it.name[this.language] || it.name['en']}`;
            }

            return `[${it.identifier}] ${it.name || it.tag}`;
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
    },
    mounted() {
        if (this.initialValue) {
            this.search(() => {}, this.initialValue, this);
        }
    }
}
</script>
