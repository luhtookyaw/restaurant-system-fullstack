<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Link,
    },

    props: ['href', 'active'],

    computed: {
        classes() {
            return this.active
                ? 'block pl-3 pr-4 py-2 border-l-4 border-indigo-400 text-base font-medium text-indigo-700 bg-indigo-50 focus:outline-none focus:text-indigo-800 focus:bg-indigo-100 focus:border-indigo-700 transition duration-150 ease-in-out'
                : 'block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-white hover:text-gray-100 focus:text-gray-100 transition duration-150 ease-in-out'
        }
    }
}
</script>
