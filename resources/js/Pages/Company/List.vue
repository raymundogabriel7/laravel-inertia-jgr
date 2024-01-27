<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ButtonLink from '../../Components/ButtonLink.vue';
import FlashAlert from '../../Components/FlashAlert.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '../../Components/Modal.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'

const confirmingCompanyDeletion = ref(false);
const deleteCompanyId = ref(null);
defineProps({
    companies: {
        type: Array,
    },
    company_logo_url: {
        type: String
    },
    message: {
        type: String,
    },
    success: {
        type: Boolean,
    },
});

const deleteCompany = (id) => {
    router.delete(route('company.destroy',{company: id}), {
        preserveScroll: true,
        onFinish: () => closeModal(),
    });
};

const confirmCompanyDeletion = (id) => {
    confirmingCompanyDeletion.value = true;
    deleteCompanyId.value = id
};

const closeModal = () => {
    confirmingCompanyDeletion.value = false;
    deleteCompanyId.value = null
};
</script>

<template>
    <Head title="Companies" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Companies</h2>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-right">
                <ButtonLink :href="route('company.create')" preserve-scroll>Add Company</ButtonLink>
            </div>
        </div>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <FlashAlert :success="$page.props.flash.success" :message="$page.props.flash.message" />
                    <table class="table-auto min-w-full bg-white border border-gray-300 divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 bg-gray-100 border-b text-start">Logo</th>
                                <th class="py-2 px-4 bg-gray-100 border-b text-start">ID</th>
                                <th class="py-2 px-4 bg-gray-100 border-b text-start">Name</th>
                                <th class="py-2 px-4 bg-gray-100 border-b text-start">Email</th>
                                <th class="py-2 px-4 bg-gray-100 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-gray-50" v-for="(company, index) in companies.data" :key="index">
                                <td class="py-2 px-4 border-b">
                                    <img v-show="company.logo" :src="company_logo_url+'/'+company.logo" alt="Logo" class="w-8 h-8 rounded-full">
                                    <img v-show="!company.logo" :src="'https://eu.ui-avatars.com/api/?name='+company.name+'&size=250'" alt="Logo" class="w-8 h-8 rounded-full">
                                </td>
                                <td class="py-2 px-4 border-b">{{company.id}}</td>
                                <td class="py-2 px-4 border-b">{{company.name}}</td>
                                <td class="py-2 px-4 border-b">{{company.email}}</td>
                                <td class="py-2 px-4 border-b text-center">
                                    
                                    <ButtonLink class="bg-indigo-500" :href="route('company.edit',  { company: company.id })" preserve-scroll>Edit</ButtonLink>&nbsp;
                                    
                                    <DangerButton @click="confirmCompanyDeletion(company.id)">Delete</DangerButton>
                                    <!-- <ButtonLink class="bg-red-500" :href="route('company.edit',  { company: company.id })" preserve-scroll>Delete</ButtonLink> -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </div>
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-center">
                <Pagination class="mt-3" :links="companies.links" />
            </div>
        </div>
    </AuthenticatedLayout>
    <Modal :show="confirmingCompanyDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Are you sure you want to delete this company?
            </h2>
            <div class="mt-6 flex justify-end">
                <SecondaryButton  @click="closeModal"> No </SecondaryButton>

                <DangerButton
                    class="ms-3"
                    @click="deleteCompany(deleteCompanyId)"
                >
                    Yes
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
