<template>
    <Head title="Edit Dish" />
    <BreezeAuthenticatedLayout>
        <nav class="flex items-center justify-between flex-wrap bg-white p-3">
            <div class="flex items-center flex-shrink-0 text-black text-xl mr-6 ml-20">
                Kitchen Panel - Dishes
            </div>
        </nav>
        <div class="py-12">
            <div class="mx-auto block p-6 rounded-lg shadow-lg bg-white max-w-lg">
                <form :action="route('dashboard.update', dish.id)" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="_token" :value="csrf">
                    <div class="form-group mb-4">
                        <label for="" class="form-label inline-block mb-2 text-gray-700">Dish</label>
                        <input 
                            name="name"
                            type="text"
                            class="form-control
                            block
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
                            placeholder="Enter Dish name"
                            :value="dish.name"
                            >
                            <div v-if="errors.name" class="text-red-700 text-sm">*{{ errors.name }}</div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="category" class="form-label inline-block mb-2 text-gray-700">Category</label>
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
                            <option 
                                v-for="(category, key) in categories" :key="key" :value="category.id" 
                                :selected="dish.category_id==category.id"
                            >
                                {{ category.name }}
                            </option>
                        </select>
                        <div v-if="errors.category" class="text-red-700 text-sm">*{{ errors.category }}</div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="image" class="form-label inline-block mb-2 text-gray-700">Image</label>
                        <img 
                            class="w-56 mx-auto mb-2 rounded-lg border border-solid border-gray-300 hover:scale-125 transition-all ease-in-out" 
                            :src="'/images/'+dish.image" :alt="dish.name"
                        />
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
                        <!-- <div v-if="errors.image" class="text-red-700 text-sm">*{{ errors.image }}</div> -->
                    </div>
                    <button
                        type="submit" 
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    >
                        Update
                    </button>
                    <Link
                        :href="route('dashboard')"
                        class="bg-red-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded float-right"
                    >
                        Back
                    </Link>
                </form>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
    
</template>
<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3';

export default {
    name:"DishEdit",
    props: {
        dish: Array,
        categories: Array,
        errors: Object,
    },
    components: {
        Head,
        Link,
        BreezeAuthenticatedLayout,
    },
    data() {
        return {
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    }
}
</script>