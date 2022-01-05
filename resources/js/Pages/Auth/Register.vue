<template>
    <Head title="Register" />

    <form @submit.prevent="submit">
        <div>
            <BreezeLabel for="name" value="Name" />
            <BreezeInput 
                id="name" type="text" 
                class="mt-1 block w-full" :class="errors.email && 'border-red-400'"
                v-model="form.name" autofocus autocomplete="name" 
            />
            <div v-if="errors.name" class="text-red-700 text-sm">*{{ errors.name }}</div>
        </div>

        <div class="mt-4">
            <BreezeLabel for="email" value="Email" />
            <BreezeInput 
                id="email" type="email" 
                class="mt-1 block w-full" :class="errors.email && 'border-red-400'"
                v-model="form.email" autocomplete="username" 
            />
            <div v-if="errors.email" class="text-red-700 text-sm">*{{ errors.email }}</div>
        </div>

        <div class="mt-4">
            <BreezeLabel for="password" value="Password" />
            <BreezeInput 
                id="password" type="password" 
                class="mt-1 block w-full" :class="errors.password && 'border-red-400'"
                v-model="form.password" autocomplete="new-password" 
            />
            <div v-if="errors.password" class="text-red-700 text-sm">*{{ errors.password }}</div>
        </div>

        <div class="mt-4">
            <BreezeLabel for="password_confirmation" value="Confirm Password" />
            <BreezeInput
                id="password_confirmation" type="password" 
                class="mt-1 block w-full" :class="errors.password && 'border-red-400'"
                v-model="form.password_confirmation" autocomplete="new-password" 
            />
            <div v-if="errors.password" class="text-red-700 text-sm">*{{ errors.password }}</div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                Already registered?
            </Link>

            <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Register
            </BreezeButton>
        </div>
    </form>
</template>

<script>
import BreezeButton from '@/Components/Button.vue'
import BreezeGuestLayout from '@/Layouts/Guest.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    layout: BreezeGuestLayout,
    props: {
        errors: Object,
    },

    components: {
        BreezeButton,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors,
        Head,
        Link,
    },

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                terms: false,
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('register'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
}
</script>
