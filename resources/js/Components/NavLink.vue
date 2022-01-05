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
                ? 'inline-flex items-center px-1 pt-1 border-b-2 border-fuchsia-500 text-base text-white hover:text-fuchsia-700 font-medium leading-5 text-gray-900 focus:outline-none focus:border-fuchsia-700 transition  duration-150 ease-in-out'
                : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-base text-white hover:text-fuchsia-700 font-medium leading-5 text-gray-500 hover:border-white focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
        }
    }
}
</script>
