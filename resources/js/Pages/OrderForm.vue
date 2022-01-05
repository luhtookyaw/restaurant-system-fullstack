<template>
    <Head title="Order Form" />
    <div class="min-h-screen bg-gray-100">
    <nav class="bg-neutral-700 border-b border-gray-100">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center mr-9">
                    <Link :href="route('dashboard')">
                        <img src="https://svgsilh.com/svg/2400338.svg" alt="" class="bg-white rounded-full block h-9 w-auto" />
                    </Link>
                    <div class="text-xl text-white ml-2">
                        Waiter<sub class="text-xs">Panel</sub>
                    </div>
                </div>
                <div class="flex items-center flex-end">
                    <Link :href="route('login')" class="text-sm bg-white hover:bg-gray-100 px-3 py-1 rounded-md text-gray-500 hover:text-gray-700">
                        Kitchen
                    </Link>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div 
        v-if="$page.props.flash.orders && show" 
        class="w-full text-center text-green-500 font-light px-1 py-3 bg-green-100 rounded absolute"
    >
        {{ $page.props.flash.orders }}
    </div>
    <div 
        v-if="$page.props.flash.served && show" 
        class="w-full text-center text-green-500 font-light px-1 py-3 bg-green-100 rounded absolute"
    >
        {{ $page.props.flash.served }}
    </div>

    <div class="flex flex-wrap mt-10">
        <div class="w-full mx-5">
            <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row">
                <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                    <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal" v-on:click="toggleTabs(1)" v-bind:class="{'text-gray-600 bg-white': openTab !== 1, 'text-white bg-gray-600': openTab === 1}">
                        New Order
                    </a>
                </li>
                <li class="-mb-px mr-2 last:mr-0 flex-auto text-center">
                    <a class="text-xs font-bold uppercase px-5 py-3 shadow-lg rounded block leading-normal" v-on:click="toggleTabs(2)" v-bind:class="{'text-gray-600 bg-white': openTab !== 2, 'text-white bg-gray-600': openTab === 2}">
                        Order Lists
                    </a>
                </li>
            </ul>
            <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                <div class="px-4 py-5 flex-auto">
                    <div class="tab-content tab-space">
                        <div v-bind:class="{'hidden': openTab !== 1, 'block': openTab === 1}">
                            <input v-model="searchWord" type=text placeholder="Search dish" class="w-full rounded-lg mb-3"/>
                            <div class="w-full border border-solid border-x-0 border-gray-400 mb-4"></div>
                            <form 
                                :action="route('order.submit')" method="POST" 
                            >
                                <input type="hidden" name="_token" :value="csrf">
                                <div :class="!searchWord && 'grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8'">
                                    <div v-for="(dish, key) in dishes" :key="key" class="my-2 mx-auto">
                                        <div v-show="dish.name.toLowerCase().includes(searchWord.toLowerCase())">
                                            <img 
                                                class="w-56 h-36 object-cover mb-2 rounded-lg border border-solid border-gray-300" 
                                                :src="'/images/'+dish.image" :alt="dish.name"
                                            />
                                            <label :for="dish.id" class="text-lg">{{dish.name}}</label><br/>
                                            <input
                                                class= "w-56 rounded-lg border border-solid border-gray-400"
                                                type="number"
                                                placeholder="0"
                                                min="0"
                                                max="20" 
                                                :name="dish.id"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <select name="table" id="" class="rounded mt-4">
                                    <option value="">Select a table</option>
                                    <option 
                                        v-for="(table, key) in tables" 
                                        :key="key"
                                        :value="table.id"
                                    >
                                        table-{{ table.number }}
                                    </option>
                                </select>
                                <span v-if="errors.table" class="text-red-700 text-md ml-5">*{{ errors.table }}</span>
                                <button 
                                    type="submit"
                                    class="float-right bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 mt-4 rounded"
                                >
                                    Submit
                                </button>
                            </form>
                        </div>
                        <div v-bind:class="{'hidden': openTab !== 2, 'block': openTab === 2}">
                            <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
                                <div 
                                    v-for="(order, key) in orders" :key="key" 
                                    class="w-56 h-52 bg-white rounded-lg px-5 py-4 border border-solid border-gray-300 bg-gray-100 mx-auto"
                                >
                                    <div class="text-gray-700 text-lg">Order id: {{ order.id }}</div>
                                    <hr/>
                                    <div class="text-gray-500 py-3 leading-loose">
                                        <div v-for="(dish, key) in dishes" :key="key">
                                            <div v-if="dish.id==order.dish_id">
                                                Dish: <span class="font-bold">{{ dish.name }}</span>
                                            </div>
                                        </div>
                                        <div>Table: <span class="font-bold">{{ order.table_id }}</span></div>
                                        <div>Status: 
                                            <span 
                                                class="text-sm text-green-500 bg-green-200 py-1 px-2 rounded-lg" :class="order.status===3 && 'text-red-500 bg-red-200'"
                                            >
                                                {{order.status===3 ? 'Cancel' : 'Ready'}}
                                            </span>
                                        </div>
                                    </div>
                                    <Link 
                                        :href="route('order.serve', order.id)"
                                        class="w-full bg-gray-500 hover:bg-gray-700 text-white text-md py-2 px-4 rounded-lg"
                                    >
                                        Served
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3';

export default {
    name: "pink-tabs",
    props: {
        dishes: Array,
        tables: Array,
        orders: Array,
        errors: Object,
    },
    components: {
        Head,
        Link,
    },
    methods: {
        toggleTabs: function(tabNumber){
            this.openTab = tabNumber
        },
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
            openTab: 1,
            show: true,
            searchWord: "",
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    created() {
        if(this.$page.props.flash.served) {
            this.openTab = 2
        }
        setTimeout(() => this.show = false, 5000)
    },
}
</script>