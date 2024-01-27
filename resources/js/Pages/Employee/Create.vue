<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ButtonLink from '../../Components/ButtonLink.vue';
import FlashAlert from '../../Components/FlashAlert.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    companies: {
        type: Array,
    },
    message: {
        type: String,
    },
    success: {
        type: Boolean,
    },
    url: {
        type: String,
    },
});

const form = useForm({
    first_name: null,
    last_name: null,
    email: null,
    company_id: null,
});

function submit() {
    form.post(route('employee.store'))
}


</script>

<template>
    <Head title="Employees" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Employee</h2>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-right">
                <ButtonLink :href="route('employee.index')" preserve-scroll>Employees</ButtonLink>
            </div>
        </div>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    
                    <FlashAlert :success="$page.props.flash.success" :message="$page.props.flash.message" />

                    <section class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Employee Information</h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Create your employee's profile information and email address.
                            </p>
                        </header>

                        <form @submit.prevent="submit" class="mt-6 space-y-6">
                            <div>
                                <InputLabel for="first_name" value="First Name" />

                                <TextInput
                                    id="first_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.first_name"
                                    autofocus
                                    autocomplete="first_name"
                                />

                                <InputError class="mt-2" :message="form.errors.first_name" />
                            </div>

                            <div>
                                <InputLabel for="last_name" value="Last Name" />

                                <TextInput
                                    id="last_name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.last_name"
                                    autofocus
                                    autocomplete="last_name"
                                />

                                <InputError class="mt-2" :message="form.errors.last_name" />
                            </div>

                            <div>
                                <InputLabel for="email" value="Email" />

                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    autocomplete="username"
                                />

                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>
                            
                            <div>
                                <InputLabel for="company_id" value="Company" />

                                <select
                                    id="company_id"
                                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                                    v-model="form.company_id"
                                    ref="input"
                                >
                                    <option v-for="company in companies" :key="company.id" :value="company.id">
                                        {{ company.name }}
                                    </option>
                                </select>

                                <InputError class="mt-2" :message="form.errors.company_id" />
                            </div>
                            
                            
                            <div class="flex items-center gap-4">
                                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                                <Transition
                                    enter-active-class="transition ease-in-out"
                                    enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out"
                                    leave-to-class="opacity-0"
                                >
                                </Transition>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
