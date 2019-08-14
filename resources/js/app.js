import Vue from 'vue';
import vSelect from 'vue-select';

import SelectInput from "./components/SelectInput";

Vue.component('v-select', vSelect);
Vue.component('select-input', SelectInput);

new Vue({
    el: '#app',
});
