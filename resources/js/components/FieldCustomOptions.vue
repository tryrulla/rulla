<template>
    <div>
        <input name="extra_options" type="hidden" :value="JSON.stringify(this.options)">

        <div v-if="selectedType === 'number'" class="card mt-4">
            <label class="block">
                <span class="text-gray-700">{{ translations.unit }}</span>
                <input class="form-input mt-1 block w-full" type="text" v-model="options.unit">
            </label>

            <label class="block mt-4">
                <span class="text-gray-700">{{ translations.decimals }}</span>
                <input class="form-input mt-1 block w-full" type="number" v-model="options.decimals">
            </label>
        </div>
    </div>
</template>

<script>
    export default {
        computed: {
            selectedType() {
                return this.typeSelector ? this.$store.getters.values[this.typeSelector] : null;
            },
        },
        data() {
            return {
                options: (this.oldValues && this.oldValues !== '[]') ? JSON.parse(this.oldValues) : {},
            };
        },
        props: {
            typeSelector: {
                default: null,
                type: String,
            },
            oldValues: {
                type: String,
                default: '{}',
            },
            translations: {
                type: Object,
                required: true,
            }
        },
        mounted() {
            this.options.decimals = this.options.decimals || 0;
        },
    };
</script>
