<template>
    <div class="w-full">
        <input type="hidden" name="custom-fields" :value="JSON.stringify(applicableValues)">

        <div v-for="(field, key) in applicableValues" class="flex w-full">
            <div class="w-full md:w-64 flex-shrink-0">
                <v-select
                    class="bg-white shadow mt-1"
                    v-model="data[key].field_id"
                    :get-option-label="it => `[${it.identifier}] ${it.name[language] || it.name['en']}`"
                    :reduce="it => it.id"
                    :options="fields"
                ></v-select>
            </div>

            <div class="ml-2 w-full">
                <div class="form-input-group relative w-full" v-if="fieldData(field.field_id).type === 'number'">
                    <input class="form-input form-input-group-left relative w-full bg-gray-200" type="number"
                           v-model.number="data[key].value.number" required :step="(fieldData(field.field_id).extraOptions.decimals || 0) === 0 ? 1 : (1 / (10 ** fieldData(field.field_id).extraOptions.decimals))">
                    <div class="form-input-group-right inline-flex justify-center items-center bg-gray-400 px-2">
                        {{ fieldData(field.field_id).extraOptions.unit }}
                    </div>
                </div>
            </div>

            <div class="ml-2 inline-flex justify-center items-center">
                <button @click="remove(field.field_id)" type="button">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div v-if="fields.length === 0" class="text-gray-700">
            {{ msgNoneAvailable }}
        </div>

        <div class="mt-4" v-if="nextUnusedField()">
            <button type="button" @click="addField" class="bg-gray-300 hover:bg-gray-400 text-gray-700 p-2 shadow rounded">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
</template>

<script>
    import axios from '../axios';

    export default {
        props: {
            defaultFields: {
                type: Array,
                required: true,
            },
            originalValues: {
                type: Array,
                required: true,
            },
            typeIdSelector: {
                default: null,
                type: String,
            },
            msgNoneAvailable: {
                required: true,
                type: String,
            },
        },
        data() {
            return {
                fields: this.defaultFields.map(it => ({ extraOptions: it.extra_options ? JSON.parse(it.extra_options) : {}, ...it })),
                data: this.originalValues.map(it => ({ field_id: it.field_id, value: it.value })),
            };
        },
        computed: {
            language() {
                return (window.Rulla || {}).language || 'en';
            },
            fieldId() {
                return this.typeIdSelector ? this.$store.getters.values[this.typeIdSelector] : null;
            },
            applicableValues() {
                return this.data.filter(it => {
                    console.log({ data: it, field: this.fieldData(it.field_id) });
                    return this.fieldData(it.field_id).id === it.field_id;
                });
            },
        },
        watch: {
            fieldId: {
                async handler(newTypeId) {
                    if (this.typeIdSelector && newTypeId) {
                        const url = window.Rulla.baseUrl + '/app/item/types/' + newTypeId.toString() + '/fields';
                        const { data } = await axios.get(url);

                        this.fields = data.fields
                            .map(it => ({extraOptions: it.extra_options ? JSON.parse(it.extra_options) : {}, ...it}));
                    } else if (!newTypeId) {
                        this.fields = [];
                    }
                },
                deep: true,
            }
        },
        methods: {
            fieldData(fieldId) {
                return this.fields.filter(it => it.id === fieldId)[0] || {};
            },
            remove(fieldId) {
                this.data = this.data.filter(it => it.field_id !== fieldId);
            },
            addField() {
                const field = this.nextUnusedField();
                if (!field || !field.id) return;

                this.data.push({ field_id: field.id, value: {} });
            },
            nextUnusedField() {
                return this.fields.filter(it => {
                    return this.data.filter(dataField => dataField.field_id === it.id).length === 0;
                })[0];
            },
        },
    };
</script>
