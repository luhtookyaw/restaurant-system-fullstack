<template>
    <Head title="Orders" />

    <BreezeAuthenticatedLayout>
            <!--flash messages-->
        <div v-if="$page.props.flash.approved && show" class="w-full text-center text-green-500 font-light px-1 py-5 bg-green-100 rounded absolute">
            {{ $page.props.flash.approved }}
        </div>
        <div v-if="$page.props.flash.cancel && show" class="w-full text-center text-red-500 font-light px-1 py-5 bg-red-100 rounded absolute">
            {{ $page.props.flash.cancel }}
        </div>
        <div v-if="$page.props.flash.ready && show" class="w-full text-center text-green-500 font-light px-1 py-5 bg-green-100 rounded absolute">
            {{ $page.props.flash.ready }}
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 bg-white pb-6 pt-6">
                <DataTable :data="orders"/>
            </div>
        </div>

    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import DataTable from '@/Components/Datatable.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    props:{
        orders: Array,
    },
    components: {
        BreezeAuthenticatedLayout,
        Head,
        DataTable,
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
            show: true,
        }
    },
    created() {
        setTimeout(() => this.show = false, 5000)
    },
}
</script>
