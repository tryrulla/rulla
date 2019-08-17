<template>
    <div class="w-full">
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
                data: this.values,
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
                    .map(it => ({ extraOptions: it.extra_options ? JSON.parse(it.extra_options) : {}, ...it }))[0];
            },
        },
    };
</script>
