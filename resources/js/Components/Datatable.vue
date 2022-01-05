<template>
    <div class="container mx-auto">
        <div class="flex flex-col">
            <div class="w-full">
                <div class="p-4 border-b border-gray-200 shadow overflow-x-auto">
                    <!-- <table> -->
                    <table class="shadow-lg bg-white stripe" id="datatable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th v-for="(item, key) in data[0]" :key="key" class="p-8 text-xs text-gray-500">
                                    {{ key }}
                                </th>
                                <th class="p-8 text-xs text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr v-for="(value, key) in data" :key="key" class="whitespace-nowrap">
                                <td v-for="(item, key) in value" :key="key" class="px-6 py-4 text-center">                                  
                                    {{ item }}
                                </td>
                                <td v-if="dishboard" class="px-6 py-4 text-center">
                                    <Link :href="route('dashboard.edit', value.id)" class="bg-yellow-500 hover:bg-yellow-700 text-white text-sm py-1 px-4 rounded-l-2xl">
                                        Edit
                                    </Link>
                                    <Link @click="deleteItem(value.id)" class="bg-red-500 hover:bg-red-700 text-white text-sm py-1 px-2 rounded-r-2xl">
                                        Delete
                                    </Link>
                                </td>
                                <td v-else class="px-6 py-4 text-center">
                                    <Link :href="route('dashboard.order.approve', value.id)" class="bg-yellow-500 hover:bg-yellow-700 text-white text-sm py-1 px-2 rounded-l-2xl">
                                        Approve
                                    </Link>
                                    <Link :href="route('dashboard.order.cancel', value.id)" class="bg-red-500 hover:bg-red-700 text-white text-sm py-1 px-3">
                                        Cancel
                                    </Link>
                                    <Link :href="route('dashboard.order.ready', value.id)" class="bg-green-500 hover:bg-green-700 text-white text-sm py-1 px-4 rounded-r-2xl">
                                        Ready
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import 'jquery/dist/jquery.min.js';
import 'datatables.net-dt/js/dataTables.dataTables';
import 'datatables.net-dt/css/jquery.dataTables.css';
import $ from 'jquery';
import { Link } from '@inertiajs/inertia-vue3';

export default {
    name: 'DataTable',
    props: {
        data: Array,
        dishboard: Boolean,
    },
    components: {
        Link,
    },
    methods: {
        deleteItem: function(user){
            if(confirm('Are you sure you want to delete this item?')){
                this.$inertia.delete(this.route('dashboard.delete', user));
            }
    }},
    mounted() {
        $('#datatable').DataTable({
            dom: 'frtip',
            pageLength: 10,
        });
    },
}
</script>