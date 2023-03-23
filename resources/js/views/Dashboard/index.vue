<script setup>
import {onMounted, reactive, ref} from "vue";
import ElTHeader from '../../components/tHeader.vue';
import SaveButton from "../../components/SaveButton.vue";
import commonCode from "../../composables/common";
import GlobalSearchInput from "../../components/globalSearchInput.vue";

const tb_body_td = "whitespace-nowrap lg:whitespace-normal border-r-2 border-hex-e1e1 px-6 py-2 text-center text-gray-900",
    vehicleForm = { register_no: '', model:'', color:'', making_year:'', category:''},
    { router, Toast, deleteAlert, validationErrors, updateCase, headerTitle, showModal, isLoading} = commonCode(),
    carsDetail = ref({}),
    carsDataDetail = ref({}),
    form = reactive(vehicleForm),
    items = ref({})

/*get all details with laravel vue pagination*/
async function getCarDetailsData(
    page = 1,
    search_global = '',
    order_column = 'created_at',
    order_direction = 'desc',
){
    await axios
        .get('api/cars-detail?page='+page +
            '&search_global=' +search_global+
            '&order_column=' +order_column+
            '&order_direction=' +order_direction
        )
        .then(response => {
            carsDetail.value = response.data
            carsDataDetail.value = response.data.data
        })
}
/*show value in form from table*/
async function editCarDetails(id){
    if (isLoading.value) {
        showModal.value = false;
        return false
    }
    await axios
        .get('/api/cars-detail/'+id)
        .then(response => {
            updateCase.value = true;
            headerTitle.value = 'Update Registration Form ';
            Object.assign(form, {
                register_no: response.data.data?.register_no,
                model: response.data.data?.model,
                color: response.data.data?.color,
                making_year: response.data.data?.production_year,
                category: response.data.data?.category_id,
                id: response.data.data?.id
            })
            showModal.value = true;
        })
}
/*delete function start*/
function deleteCarDetails(id){
    if(!!id){
        deleteAlert('Attention', 'Yes delete it')
            .then(result => {
                if (result.isConfirmed) {
                    axios
                        .delete('/api/cars-detail/' + id)
                        .then(() => {
                            getCarDetailsData()
                            Toast.fire({ icon: 'success', title: 'Data Deleted'})
                        })
                        .catch(error => {
                            Toast.fire({ icon: 'error', title: 'Something went wrong'})
                        })
                }
            })
    }
}
/*store function start*/
async function storeFormData(post) {
    if (isLoading.value)
        return

    isLoading.value = true
    validationErrors.value = {}
    let responseValidation = validateFields(post)
    if (responseValidation === false) {
        isLoading.value = false
        return false
    }
    let serializedData = new FormData()
    for (let item in post) {
        if (post.hasOwnProperty(item)) {
            serializedData.append(item, post[item])
        }
    }
    await axios
        .post('/api/cars-detail', post)
        .then(() => {
            getCarDetailsData()
            Toast.fire({icon: 'success', title: 'Registration saved '})
            showModal.value = false
            form.value = []
        })
        .catch(error => {
            if(error.response?.data){
                validationErrors.value = error.response.data.errors
            }
        }).finally( () => isLoading.value = false)
}
/*update function start*/
async function updateFormData(post){
    if(isLoading.value)
        return false
    isLoading.value = true;
    validationErrors.value = {};
    let responseValidation = validateFields(post);
    if(responseValidation === false) {
        isLoading.value = false;
        return false
    }
    await axios
        .put('/api/cars-detail/'+post.id, post)
        .then(() => {
            getCarDetailsData()
            Toast.fire({icon: 'success', title: 'Registration updated '})
            showModal.value = false
            Object.assign(form, vehicleForm)
        })
        .catch(error => {
            if(error.response?.data){
                validationErrors.value = error.response.data.errors
            }
        }).finally( () => isLoading.value = false)


}
/*get all categories for show in select input options*/
async function getAllCategories(){
    await axios
        .get('/api/all-categories')
        .then((response) => {
            items.value = response.data.data;
        })
}
const  validateFields = (form) => {
    let response = true

    if(!form.register_no){
        validationErrors.value.register_no  = ['The register no field is required.'];
        response = false;
    }
    if(!form.model){
        validationErrors.value.model = ['The car model field is required.'];
        response = false;
    }
    if(!form.color){
        validationErrors.value.color = ['The color field is required.'];
        response = false;
    }
    if(!form.category)
    {
        validationErrors.value.category = ['The category field is required.'];
        response = false;
    }
    if(!form.making_year)
    {
        validationErrors.value.making_year = ['The making year field is required.'];
        response = false;
    }
    return response;
}
/*When components render this function call */
onMounted(async () => {
    await getCarDetailsData();
    await getAllCategories();
})

/*this arrow function check the categories table is empty or not*/
const countData = ( ()=> Object.keys(carsDataDetail.value).length )

/* this function call for search functionality that is come from other components*/
function watchFunc(obj){
    if(obj.module === 'carDetails' ){
        getCarDetailsData(1, obj.current )
    }
}
/*order sorting functionality this function trigger when click down or top arrow clicked in table*/
function sortOrder(object){
    getCarDetailsData( object.page, object.search_global, object.order_column, object.order_direction )
}
</script>
<template>
    <div class="bg-hex-e1e1 lg:px-0 flex-1 pt-20">
        <div>
            <div class="max-w-6xl gap-2 grid md:grid-cols-7 mx-auto justify-center px-3">
                <div class="col-span-8 w-full">
                    <div  class="md:text-[16px] sm:text-[12px] text-[10px] text-[#212529] flex justify-end pb-2">
                        <router-link to="/categories" class="rounded-full inline-flex items-center px-8 py-2 bg-hex-aa00 disabled:opacity-75 disabled:cursor-not-allowed">
                            <span class="mx-3">Categories Page</span>
                            <el-icon icon="rightArrow" :svg="true"/>
                        </router-link>
                    </div>
                    <div class="flex justify-end">
                        <el-button classes="whitespace-nowrap px-8 mx-2 bg-hex-aa00" button_texts="Register vehicle" @clicked="validationErrors = []; updateCase = false; headerTitle = 'Register new Vehicle'; form = {}; showModal = !showModal; " />
                        <global-search-input :classes="'rounded-full sm:w-2/5 lg:w-1/5 w-2/5'" @watchEvent="watchFunc" globalType="carDetails" />
                    </div>
                </div>
                <div class="col-span-8 w-full">
                    <div class="md:text-[16px] overflow-x-auto sm:text-[12px] text-[10px] h-[500px] text-[#212529] pb-8">
                        <table id="show_all_translate" class="min-w-full border">
                            <el-t-header module="carDetails"  @emitCarDetails="sortOrder" v-bind:search_items="{id: '#',register_no:'Registration-no',model: 'Car Model', category_id: 'Category', color:'Color',making_year: 'Year' , action : 'action' }" />
                            <tbody class="bg-white divide-y divide-gray-200 divide-solid ">
                            <tr v-if="countData()"  class="!border-b-2 border-hex-e1e1"  v-for="(car, key) in carsDetail.data">
                                <td :class="tb_body_td">{{(carsDetail.meta.from)+key}}</td>
                                <td :class="tb_body_td">{{car.register_no}}</td>
                                <td :class="'flex justify-center '+tb_body_td">{{car.model}}</td>
                                <td :class="tb_body_td">{{car.category_type}}</td>
                                <td :class="tb_body_td">{{car.color}}</td>
                                <td :class="tb_body_td">{{car.production_year}}</td>
                                <td class="border border-slate-300 px-4 text-gray-900">
                                    <div class="flex justify-evenly">
                                        <span class="w-[16px]"/>
                                        <a href="javascript:void(0);" @click.prevent="editCarDetails(car.id)" :title="'Edit'">
                                            <img class="w-[14px]" src="/icon/edit_pen.svg"/>
                                        </a>
                                        <a href="javascript:void(0);" @click.prevent="deleteCarDetails(car.id)" :title="'Delete'">
                                            <img class="w-[12px]" src="/icon/Bin.svg" />
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr v-else class="border bg-gray-100 border-slate-300">
                                <td colspan="7" class="text-center p-3">No matching records found</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="flex justify-end my-2 items-center" v-show="!!carsDetail.links?.next || !!carsDetail.links?.prev">
                            <label for="pagination" class="mx-3 ">Page</label>
                            <Pagination :data="carsDetail" @pagination-change-page="car => getCarDetailsData(car)" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- start modal -->
            <div class="">
                <ModalDialog  :show="showModal" :title="headerTitle" @close="showModal = !showModal">
                    <form  class="p-8 py-5" @submit.prevent=" updateCase ? updateFormData(form) : storeFormData(form)">
                        <div class="mt-4">
                            <label  class="block font-bold  text-black-700">Register No</label>
                            <div class="mt-1">
                                <el-input @change="delete validationErrors['register_no']"  :placeholder="'Register no'" v-model="form.register_no"  type="text" classes="mt-1 rounded-md"  />
                                <el-error v-bind:errors="validationErrors?.register_no" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <label  class="block font-bold  text-black-700">Car Model</label>
                            <div class="mt-1">
                                <el-input @change="delete validationErrors['model']"  :placeholder="'Car Model'" v-model="form.model"  type="text" classes="mt-1 rounded-md"  />
                                <el-error v-bind:errors="validationErrors?.model" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <label  class="block font-bold  text-black-700">Car Color</label>
                            <div class="mt-1">
                                <el-input @change="delete validationErrors['color']" :placeholder="'Car Color'"  v-model="form.color" type="text"     :classes="'mt-1 rounded-md' " />
                                <el-error v-bind:errors="validationErrors?.color" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <label  class="block font-bold  text-black-700">Making Year</label>
                            <div class="mt-1">
                                <el-input @change="delete validationErrors['making_year']" :placeholder="'Making Year'" v-model="form.making_year" type="text" :classes=" 'mt-1 rounded-md' " />
                                <el-error v-bind:errors="validationErrors?.making_year" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <label  class="block font-bold  text-black-700">Please select category below</label>
                            <div class="mt-1">
                                <multiselect  @change="delete validationErrors['category']" v-model="form.category" :options="items" :placeholder="'Select category'" :multiple="false" />
                                <el-error v-bind:errors="validationErrors?.category" />
                            </div>
                        </div>

                        <!-- Buttons -->
                        <save-button :buttonName=" updateCase ? 'Update' : 'Submit' " :isLoading="isLoading"/>
                    </form>
                </ModalDialog>
            </div>
        </div>
    </div>
</template>
<style src="@vueform/multiselect/themes/default.css"/>
