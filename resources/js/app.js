import Vue from 'vue';
import vSelect from 'vue-select';
import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';

import store from './store';

import MultiInput from "./components/MultiInput";
import SelectInput from "./components/SelectInput";
import SearchInput from "./components/SearchInput";
import TypeFieldEditor from "./components/FieldEditor";
import DateTimeInput from "./components/DateTimeInput";
import FieldCustomOptions from "./components/FieldCustomOptions";

Vue.component('v-select', vSelect);
Vue.component('date-time-picker', VueCtkDateTimePicker);

Vue.component('multi-input', MultiInput);
Vue.component('select-input', SelectInput);
Vue.component('search-input', SearchInput);
Vue.component('field-editor', TypeFieldEditor);
Vue.component('date-time-input', DateTimeInput);
Vue.component('field-custom-options', FieldCustomOptions);

new Vue({
    el: '#app',
    store,
});
