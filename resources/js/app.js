import Vue from 'vue';
import vSelect from 'vue-select';

import store from './store';

import SelectInput from "./components/SelectInput";
import TypeFieldEditor from "./components/TypeFieldEditor";
import FieldCustomOptions from "./components/FieldCustomOptions";

Vue.component('v-select', vSelect);
Vue.component('select-input', SelectInput);
Vue.component('type-field-editor', TypeFieldEditor);
Vue.component('field-custom-options', FieldCustomOptions);

new Vue({
    el: '#app',
    store,
});
