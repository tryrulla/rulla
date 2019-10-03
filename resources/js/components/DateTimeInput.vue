<template>
    <div>
        <input type="hidden" :name="id" :value="actualValue">

        <date-time-picker
            v-model="value"
            format="YYYY-MM-DDTHH:mmZZ"
            formatted="MMM Do YYYY HH:mm Z"
            :minute-interval="5"
        ></date-time-picker>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        data() {
            return {
                value: this.initialValue || null,
            };
        },
        props: {
            id: {
                type: String,
                required: true,
            },
            initialValue: {
                type: String,
                required: false,
            },
        },
        computed: {
            actualValue() {
                if (!this.value) {
                    return null;
                }

                return moment(this.value, 'YYYY-MM-DDTHH:mmZZ')
                    .utc()
                    .format('YYYY-MM-DD HH:mm');
            },
        },
    };
</script>
