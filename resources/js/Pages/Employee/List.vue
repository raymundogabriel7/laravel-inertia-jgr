<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ButtonLink from '../../Components/ButtonLink.vue';
import FlashAlert from '../../Components/FlashAlert.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '../../Components/Modal.vue';
import Pagination from '@/Components/Pagination.vue'
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'

const confirmingEmployeeDeletion = ref(false);
const deleteEmployeeId = ref(null);
defineProps({
    employees: {
        type: Array,
    },
    message: {
        type: String,
    },
    success: {
        type: Boolean,
    },
});

const deleteEmployee = (id) => {
    router.delete(route('employee.destroy',{employee: id}), {
        preserveScroll: true,
        onFinish: () => closeModal(),
    });
};

const confirmEmployeeDeletion = (id) => {
    confirmingEmployeeDeletion.value = true;
    deleteEmployeeId.value = id
};

const closeModal = () => {
    confirmingEmployeeDeletion.value = false;
    deleteEmployeeId.value = null
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
                <ButtonLink :href="route('employee.create')" preserve-scroll>Add Employee</ButtonLink>
            </div>
        </div>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <FlashAlert :success="$page.props.flash.success" :message="$page.props.flash.message" />
                    <table class="table-auto min-w-full bg-white border border-gray-300 divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 bg-gray-100 border-b text-start">ID</th>
                                <th class="py-2 px-4 bg-gray-100 border-b text-start">First Name</th>
                                <th class="py-2 px-4 bg-gray-100 border-b text-start">Last Name</th>
                                <th class="py-2 px-4 bg-gray-100 border-b text-start">Email</th>
                                <th class="py-2 px-4 bg-gray-100 border-b text-start">Company</th>
                                <th class="py-2 px-4 bg-gray-100 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-gray-50" v-for="(employee, index) in employees.data" :key="index">
                                <td class="py-2 px-4 border-b">{{employee.id}}</td>
                                <td class="py-2 px-4 border-b">{{employee.first_name}}</td>
                                <td class="py-2 px-4 border-b">{{employee.last_name}}</td>
                                <td class="py-2 px-4 border-b">{{employee.email}}</td>
                                <td class="py-2 px-4 border-b">{{employee.company.name}}</td>
                                <td class="py-2 px-4 border-b text-center">
                                    
                                    <ButtonLink class="bg-indigo-500" :href="route('employee.edit',  { employee: employee.id })" preserve-scroll>Edit</ButtonLink>&nbsp;
                                    
                                    <DangerButton @click="confirmEmployeeDeletion(employee.id)">Delete</DangerButton>
                                    <!-- <ButtonLink class="bg-red-500" :href="route('employee.edit',  { employee: employee.id })" preserve-scroll>Delete</ButtonLink> -->
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-center">
                <Pagination class="mt-3" :links="employees.links" />
            </div>
        </div>
    </AuthenticatedLayout>
    <Modal :show="confirmingEmployeeDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Are you sure you want to delete this employee?
            </h2>
            <div class="mt-6 flex justify-end">
                <SecondaryButton  @click="closeModal"> No </SecondaryButton>

                <DangerButton
                    class="ms-3"
                    @click="deleteEmployee(deleteEmployeeId)"
                >
                    Yes
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>
