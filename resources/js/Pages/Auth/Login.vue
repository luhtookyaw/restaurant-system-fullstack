<template>
    <Head title="Log in" />

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>

    <form @submit.prevent="submit">
        <div>
            <BreezeLabel for="email" value="Email" />
            <BreezeInput 
                id="email" type="email" 
                class="mt-1 block w-full" :class="errors.email && 'border-red-400'" 
                v-model="form.email" autofocus autocomplete="username" 
            />
        </div>
        <div v-if="errors.email" class="text-red-700 text-sm">*{{ errors.email }}</div>

        <div class="mt-4">
            <BreezeLabel for="password" value="Password" />
            <BreezeInput 
                id="password" type="password" 
                class="mt-1 block w-full" :class="errors.password && 'border-red-400'"
                v-model="form.password" autocomplete="current-password" 
            />
        </div>
        <div v-if="errors.password" class="text-red-700 text-sm">*{{ errors.password }}</div>

        <div class="block mt-4">
            <label class="flex items-center">
                <BreezeCheckbox name="remember" v-model:checked="form.remember" />
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>
        </div>


        <button 
            type="submit"
            class="w-full px-3 py-2 my-4 text-center text-white bg-gray-800 hover:bg-gray-700 rounded-lg" 
            :disabled="form.processing"
        >
            LOG IN
        </button>
        <Link :href="route('register')" class="text-base text-gray-700 underline">
            Register
        </Link>
        <span class="text-sm mx-2">or</span>
        <Link 
            v-if="canResetPassword" :href="route('password.request')" 
            class="underline text-base text-gray-600 hover:text-gray-900"
        >
            Forgot your password?
        </Link>
        <Link 
            :href="route('order.form')" 
            class="text-sm px-3 py-2 bg-transparent hover:bg-gray-300 border border-solid border-gray-300 rounded-lg float-right block"
        >
            Back
        </Link>
    </form>
</template>

<script>
import BreezeButton from '@/Components/Button.vue'
import BreezeCheckbox from '@/Components/Checkbox.vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    layout: BreezeGuestLayout,

    components: {
        BreezeButton,
        BreezeCheckbox,
        BreezeInput,
        BreezeLabel,
        Head,
        Link,
    },
    props: {
        canResetPassword: Boolean,
        status: String,
        errors: Object,
    },

    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: '',
                remember: false
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('login'), {
                onFinish: () => this.form.reset('password'),
            })
        }
    }
}
</script>
