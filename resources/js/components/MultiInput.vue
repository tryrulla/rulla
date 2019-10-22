<template>
    <div>
        <input type="hidden" :name="name" :value="JSON.stringify(selected)">

        <v-select
            class="bg-white mt-1"
            multiple
            @search="search"
            v-model="selected"
            :options="options"
            :reduce="reduce"
            :get-option-label="label"
            :filterable="false"
        />
    </div>
</template>

<script>
import debounce from 'lodash/debounce';
import axios from '../axios';

export default {
    data() {
        return {
            options: [],
            selected: this.oldValue || [],
        };
    },
    props: {
        name: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            required: true,
        },
        filter: {
            type: Object,
            default: () => {},
        },
        oldValue: {
            type: Array,
            default: () => [],
        },
    },
    computed: {
        realFilter() {
            return { type: [this.type], ...this.filter };
        }
    },
    methods: {
        search(search, loading) {
            this.lastSearch = search;
            loading(true);
            this.loadOptions(loading, search, this);
        },
        loadOptions: debounce((loading, search, vm) => {
            if (search.length === 0) {
                loading(false);
                vm.options = [];
                return;
            }

            axios.post(Rulla.baseUrl + '/app/search', {filters: {query: search, ...vm.realFilter}})
                .then(({data}) => {
                    console.log(data);
                    vm.options = data.results;

                    if (search === vm.initialValue && vm.options.length === 1) {
                        vm.selected = [vm.options[0].id];
                    }

                    loading(false);
                });
        }, 500),
        label(it) {
            if (typeof it === 'string') {
                return it;
            }

            if (typeof it === 'number') {
                return `${Rulla.identifiers.typeToLetter[this.type]}${it}`;
            }

            if (it.identifier) {
                if (typeof it.name === 'object') {
                    return `[${it.identifier}] ${it.name[this.language] || it.name['en']}`;
                }

                return `[${it.identifier}] ${it.name || it.tag}`;
            }

            console.warn('Could not get name for ' + JSON.stringify(it));
            return 'foo';
        },
        reduce(it) {
            if (typeof it === 'number') {
                return it;
            }

            return it.id;
        },
    },
}
</script>
