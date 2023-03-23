import {ref, inject} from 'vue'
import { useRouter } from 'vue-router'

/*In this file we create some common props and import sweet alert and vue router etc, for multiple components*/
export default function commonCode(){
    const
        Swal = inject('$swal'),
        updateCase = ref(false),
        headerTitle = ref(''),
        showModal = ref(false),
        isLoading = ref(false),
        option = ref(5),
        router = useRouter(),
        validationErrors = ref({}),
        Toast =  Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1300,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    /*confirm box alert show when click on delete icon*/
    const deleteAlert = ()=>{
        let swal_delete=''
        swal_delete = Swal({
            title: 'Attention',
            html:'This action will permanently delete this data.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffaa00',
            cancelButtonColor: '#008255',
            confirmButtonText: 'Yes delete it',
            cancelButtonText: 'Cancel'
        })
        return swal_delete;
    }

    return {
        router, Swal, deleteAlert, Toast, validationErrors, updateCase, headerTitle, showModal, isLoading, option
    }
}
