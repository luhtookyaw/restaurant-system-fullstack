<template>
    <Head title="Dishes" />

    <BreezeAuthenticatedLayout>
        <!--Flash Messages-->
        <div v-if="$page.props.flash.success && show" class="w-full text-center text-green-500 font-light px-1 py-5 bg-green-100 rounded absolute">
            {{ $page.props.flash.success }}
        </div>
        <div v-if="$page.props.flash.updated && show" class="w-full text-center text-green-500 font-light px-1 py-5 bg-green-100 rounded absolute">
            {{ $page.props.flash.updated }}
        </div>
        <div v-if="$page.props.flash.deleted && show" class="w-full text-center text-green-500 font-light px-1 py-5 bg-green-100 rounded absolute">
            {{ $page.props.flash.deleted }}
        </div>
        <div 
            v-if="(errors.name || errors.category || errors.image) && show" 
            class="w-full text-center text-red-500 font-light px-1 py-5 bg-red-100 rounded absolute"
        >
            Please completely fill in the form!
        </div>
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 bg-white pb-6 pt-6">
                <!--DataTable-->
                <DataTable :data="dishes" dishboard/>
                <button 
                    v-if="!toggleAdd"
                    @click="toggleAdd = !toggleAdd"
                    class="
                        px-6
                        py-2.5
                        mt-1.5
                        bg-blue-600
                        text-white
                        font-bold
                        text-xs
                        leading-tight
                        uppercase
                        rounded
                        shadow-md
                        hover:bg-blue-700 hover:shadow-lg
                        focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
                        active:bg-blue-800 active:shadow-lg
                        transition
                        duration-150
                        ease-in-out
                        float-right
                        "
                >
                    Add
                </button>
                <!--Create Dish Form-->
                <form :action="route('dashboard.store')" method="POST" v-if="toggleAdd" enctype="multipart/form-data">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="form-group mb-2 mt-1.5">
                        <input 
                            type="text"
                            name="name"
                            class="form-control block
                            w-full
                            px-3
                            py-1.5
                            text-base
                            font-normal
                            text-gray-700
                            bg-white bg-clip-padding
                            border border-solid border-gray-300
                            rounded
                            transition
                            ease-in-out
                            m-0
                            focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" 
                            placeholder="Dish name"
                        >
                        <div v-if="errors.name" class="text-red-700 text-sm">*{{ errors.name }}</div>
                    </div>
                    <div class="form-group mb-2 mt-1.5">
                        <select 
                            name="category"
                            class="form-select block
                            w-full
                            px-3
                            py-1.5
                            text-base
                            font-normal
                            text-gray-700
                            bg-white bg-clip-padding
                            border border-solid border-gray-300
                            rounded
                            transition
                            ease-in-out
                            m-0
                            focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        >
                            <option value="">Select category</option>
                            <option v-for="(category, key) in categories" :key="key" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                        <div v-if="errors.category" class="text-red-700 text-sm">*{{ errors.category }}</div>
                    </div>
                    <div class="form-group mb-4">
                        <input 
                            type="file"
                            name="image"
                            class="form-control block
                            w-full
                            px-3
                            py-1.5
                            text-base
                            font-normal
                            text-gray-700
                            bg-white bg-clip-padding
                            border border-solid border-gray-300
                            rounded
                            transition
                            ease-in-out
                            m-0
                            focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                        >
                        <div v-if="errors.image" class="text-red-700 text-sm">*{{ errors.image }}</div>
                    </div>
                    <button
                        type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    >
                        Add Dish
                    </button>
                    <button
                        @click="toggleAdd = !toggleAdd"
                        class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded float-right"
                    >
                        Close
                    </button>
                </form>
            </div>
        </div>
        
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import DataTable from '@/Components/Datatable.vue'
import { Head } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        DataTable,
        Link,
    },
    props: {
        dishes: Array,
        categories: Array,
        errors: Object,
        msg: Array,
    },
    watch: {
        '$page.props.flash': {
            handler() {
                this.show = true
            }
        }    
    },
    data() {
        return {
            toggleAdd: false,
            show: true,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    created() {
        setTimeout(() => this.show = false, 5000)
    },
}
</script>
