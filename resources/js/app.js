import Vue from 'vue';
import vSelect from 'vue-select';

import SelectInput from "./components/SelectInput";
import TypeFieldEditor from "./components/TypeFieldEditor";

Vue.component('v-select', vSelect);
Vue.component('select-input', SelectInput);
Vue.component('type-field-editor', TypeFieldEditor);

new Vue({
    el: '#app',
});
