
import { createApp } from 'vue/dist/vue.esm-bundler';
import './plugins/index' //import our custom plugins
import LaravelVuePagination from 'laravel-vue-pagination'; //for data table functionality shows
import VueSweetalert2 from "vue-sweetalert2"; //show toaster for alert
import { createPinia } from 'pinia'; // pinia for global state between components
import router from './routes/index'; // vue-router file import
import Multiselect from '@vueform/multiselect'; // select to plugin use
/*import global components start*/
import ModalDialog from './components/ModalDialog.vue';
import ElInput from './components/input.vue';
import ElButton from './components/Button.vue';
import  ElLabel from './components/label.vue';
import  ElError from './components/inputError.vue';
import  SaveButton from './components/SaveButton.vue';
import  svgIcon from './components/svgIcon.vue';
/*import global components end*/

const app = createApp({});
const pinia = createPinia()
app
    .component('ModalDialog', ModalDialog)
    .component('ElInput', ElInput)
    .component('ElButton', ElButton)
    .component('ElLabel', ElLabel)
    .component('ElError', ElError)
    .component('Pagination', LaravelVuePagination)
    .component('Multiselect',Multiselect)
    .component('SaveButton', SaveButton)
    .component('ElIcon', svgIcon)

app.use(pinia)
app.use(router)
app.use(VueSweetalert2);
app.mount('#app')




