<script setup>
import {onMounted, reactive, ref, watch} from "vue";
import ElTHeader from '../../components/tHeader.vue';
import SaveButton from "../../components/SaveButton.vue";
import commonCode from "../../composables/common";
import GlobalSearchInput from "../../components/globalSearchInput.vue"

const tb_body_td = "whitespace-nowrap lg:whitespace-normal border-r-2 border-hex-e1e1 px-6 py-2 text-center text-gray-900",
    categoryForm = { name: '' },
    { router, Toast, deleteAlert, validationErrors, updateCase, headerTitle, showModal, isLoading, option} = commonCode(),
    categoriesData = ref({}),
    categoriesRow = ref({}),
    form = reactive(categoryForm)

    /*get all categories request with some parameters for perform laravel-vue pagination */

    async function getCategoriesData(
        page = 1,
        search_global = '',
        limit = option.value,
        order_column = 'created_at',
        order_direction = 'desc',
    ){
        await axios
            .get('api/categories?page='+page +
                '&search_global=' +search_global+
                '&limit=' +limit+
                '&order_column=' +order_column+
                '&order_direction=' +order_direction
            )
            .then(response => {
                categoriesData.value = response.data
                categoriesRow.value = response.data.data
            })
    }

    /*all categories request end*/

    /*Show category in modal for update */

    async function editCategory(id){
        if (isLoading.value) {
            showModal.value = false;
            return false
        }
        if(!!id){
            await axios
                .get('/api/categories/'+id)
                .then(response => {
                    updateCase.value = true;
                    headerTitle.value = 'Update Category Form ';
                    Object.assign(form, {
                        name: response.data.data?.label,
                        id: response.data.data?.value
                    })
                    showModal.value = true;
                })
        }

    }
    /*delete category*/

    function deleteCategory(id){
        if(!!id){
            /*before delete this function show confirm box comes from composable file*/
            deleteAlert()
                .then(result => {
                    if (result.isConfirmed) {
                        axios
                            .delete('/api/categories/' + id)
                            .then(() => {
                                getCategoriesData()
                                Toast.fire({ icon: 'success', title: 'Data Deleted'})
                            })
                            .catch(error => {
                                Toast.fire({ icon: 'error', title: 'Something went wrong'})
                            })
                    }
                })
        }
    }
    /*store category function start*/

    async function storCategoryForm(post) {
        if (isLoading.value)
            return

        isLoading.value = true
        validationErrors.value = {}
        let responseValidation = validateFields(post)
        if (responseValidation === false) {
            isLoading.value = false
            return false
        }
        await axios
            .post('/api/categories', post)
            .then(() => {
                getCategoriesData()
                Toast.fire({icon: 'success', title: 'Category saved '})
                showModal.value = false
                form.value = []
            })
            .catch(error => {
                if(error.response?.data){
                    validationErrors.value = error.response.data.errors
                }
            }).finally( () => isLoading.value = false)
    }

    /*store category function end*/

    /*update category function start*/
    async function updateCategoryForm(post){
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
            .put('/api/categories/'+post.id, post)
            .then(() => {
                getCategoriesData()
                Toast.fire({icon: 'success', title: 'Registration updated '})
                showModal.value = false
                Object.assign(form, categoryForm)
            })
            .catch(error => {
                if(error.response?.data){
                    validationErrors.value = error.response.data.errors
                }
            }).finally( () => isLoading.value = false)
    }

    /*update category function end*/

    const validateFields = (form) => {
        let response = true
        if(!form.name){
            validationErrors.value.name  = ['The name field is required.'];
            response = false;
        }
        return response;
    }

    /*When components render this function call */

    onMounted(async () => {
        await getCategoriesData();
    })

    /* this function call for search functionality that is come from other components*/

    function watchFunc(obj){
        if(obj.module === 'categories' ){
            getCategoriesData(1, obj.current, option.value )
        }
    }

    /*order sorting functionality this function trigger when click down or top arrow clicked in table*/

    function sortOrder(object){
        getCategoriesData( object.page, object.search_global, option.value, object.order_column, object.order_direction )
    }

    /*this arrow function check the categories table is empty or not*/

    const countData = ( ()=> Object.keys(categoriesRow.value).length )
</script>
<template>
    <div class="bg-hex-e1e1 lg:px-0 flex-1 pt-20">
        <div>
            <div class="max-w-6xl gap-2 grid md:grid-cols-7 mx-auto justify-center px-3">
                <div class="col-span-8 w-full">
                    <!-- navigate to details component button -->
                    <div  class="md:text-[16px] sm:text-[12px] text-[10px] text-[#212529] flex justify-end pb-2">
                        <router-link to="/car-details" class="rounded-full inline-flex items-center px-8 py-2 bg-hex-aa00 disabled:opacity-75 disabled:cursor-not-allowed">
                            <span class="mx-3">Car details page</span>
                            <el-icon icon="rightArrow" :svg="true"/>
                        </router-link>
                    </div>
                    <div class="flex justify-between">
                    <!-- When record limit changes and shows respectively records -->
                        <div class="flex justify-start">
                            <select v-model="option" class="w-20" @change.prevent="getCategoriesData( 1, '', $event.target.value )">
                                <option v-for="option in [5, 10, 25, 50]" :value="option">{{ option }}</option>
                            </select>
                        </div>

                        <div class="flex justify-end">
                            <!-- show model in which category create  form show-->
                            <el-button  classes="whitespace-nowrap px-8 mx-2 bg-hex-aa00" button_texts="Add Categories" @clicked="validationErrors = []; updateCase = false; headerTitle = 'Add Categories'; form = {}; showModal = !showModal; " />
                            <!-- search input from table watchEvent trigger when any word is search-->
                            <global-search-input :classes="'rounded-full sm:w-2/5 lg:w-1/5 w-2/5'" @watchEvent="watchFunc" globalType="categories" />
                        </div>
                    </div>
                </div>
                <!-- start table -->
                <div class="col-span-8 w-full">
                    <div class="md:text-[16px] overflow-x-auto sm:text-[12px] text-[10px] h-[500px] text-[#212529] pb-8">
                        <table id="show_all_translate" class="min-w-full border">
                            <!-- Table header component for common functionality in every table, just pass the object of all columns with key must be column_name -->
                            <el-t-header module="categories" @emitCategories="sortOrder" v-bind:search_items="{id: '#', category:'Category', action : 'action' }" />
                            <tbody class="bg-white divide-y divide-gray-200 divide-solid ">
                            <tr v-if="countData() > 0"  class="!border-b-2 border-hex-e1e1"  v-for="(category, key) in categoriesData.data">
                                <td :class="tb_body_td">{{(categoriesData.meta.from)+key}}</td>
                                <td :class="tb_body_td">{{category.label}}</td>
                                <!--Action column functionality-->
                                <td class="border border-slate-300 px-4 text-gray-900">
                                    <div class="flex justify-evenly">
                                        <span class="w-[16px]"/>
                                        <a href="javascript:void(0);" @click.prevent="editCategory(category.value)" :title="'Edit'">
                                            <img class="w-[14px]" src="/icon/edit_pen.svg"/>
                                        </a>
                                        <a href="javascript:void(0);" @click.prevent="deleteCategory(category.value)" :title="'Delete'">
                                            <img class="w-[12px]" src="/icon/Bin.svg" />
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <!-- If no data exist in the table then show this block of code -->
                            <tr v-else class="border bg-gray-100 border-slate-300">
                                <td colspan="6" class="text-center p-3">No matching records found</td>
                            </tr>
                            </tbody>
                        </table>
                        <!--laravel pagination links handling in v-show-->
                        <div class="flex justify-end my-2 items-center" v-show="!!categoriesData.links?.next || !!categoriesData.links?.prev">
                            <label for="pagination" class="mx-3 ">Page</label>
                            <!--Vue pagination  plugin-->
                            <Pagination :data="categoriesData" @pagination-change-page="car => getCategoriesData(car)" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- End table -->
            <!-- start modal -->
            <div class="">
                <ModalDialog  :show="showModal" :title="headerTitle" @close="showModal = !showModal">
                    <form  class="p-8 py-5" @submit.prevent=" updateCase ? updateCategoryForm(form) : storCategoryForm(form)">
                        <div class="mt-4">
                            <label  class="block font-bold  text-black-700">Category name</label>
                            <div class="mt-1">
                                <el-input @change="delete validationErrors['name']"  :placeholder="'Category name'" v-model="form.name"  type="text" classes="mt-1 rounded-md"  />
                                <el-error v-bind:errors="validationErrors?.name" />
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
