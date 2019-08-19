<template>
    <div class="w-full">
        <input type="hidden" name="custom-fields" :value="JSON.stringify(data)">

        <div v-for="(field, key) in data" class="flex w-full">
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
                    <input class="form-input form-input-group-left relative w-full bg-gray-200" type="number" v-model.number="data[key].value.number" required>
                    <div class="form-input-group-right inline-flex justify-center items-center bg-gray-400 px-2">
                        {{ fieldData(field.field_id).extraOptions.unit }}
                    </div>
                </div>
            </div>

            <div class="hidden">
                {{ JSON.stringify(fieldData(field.field_id)) }}
            </div>

            <div class="ml-2 inline-flex justify-center items-center">
                <button @click="remove(field.field_id)" type="button">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="mt-4">
            <button type="button" v-if="nextUnusedField()" @click="addField" class="bg-gray-300 hover:bg-gray-400 text-gray-700 p-2 shadow rounded">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            fields: {
                type: Array,
                required: true,
            },
            values: {
                type: Array,
                required: true,
            },
        },
        data() {
            return {
                data: this.values.map(it => ({ field_id: it.field_id, value: it.value })),
            };
        },
        computed: {
            language() {
                return (window.Rulla || {}).language || 'en';
            },
        },
        methods: {
            fieldData(fieldId) {
                return this.fields.filter(it => it.id === fieldId)
                    .map(it => ({ extraOptions: it.extra_options ? JSON.parse(it.extra_options) : {}, ...it }))[0] || {};
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
