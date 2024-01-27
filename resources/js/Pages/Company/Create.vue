<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import FlashAlert from '../../Components/FlashAlert.vue';
import ButtonLink from '../../Components/ButtonLink.vue';
const props = defineProps({

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
    name: null,
    email: null,
    logo: null
});

function submit() {
    form.post(route('company.store'))
}

function previewImage() {
    props.url = URL.createObjectURL(form.logo);
}
</script>

<template>
    <Head title="Companies" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Created Company</h2>
        </template>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 text-right">
                <ButtonLink :href="route('company.index')" preserve-scroll>Companies</ButtonLink>
            </div>
        </div>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    
                    <FlashAlert :success="$page.props.flash.success" :message="$page.props.flash.message" />

                    <section class="max-w-xl">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">Company Information</h2>

                            <p class="mt-1 text-sm text-gray-600">
                                Create your company's profile information and email address.
                            </p>
                        </header>

                        <form @submit.prevent="submit" class="mt-6 space-y-6">
                            <div>
                                <InputLabel for="name" value="Name" />

                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    autofocus
                                    autocomplete="name"
                                />

                                <InputError class="mt-2" :message="form.errors.name" />
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
                                <InputLabel for="logo" value="Logo" />
                                <input type="file" @input="form.logo = $event.target.files[0]" v-on:change="previewImage()" accept="image/*" />
                                <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                {{ form.progress.percentage }}%
                                </progress>
                                <img
                                    v-if="props.url"
                                    :src="props.url"
                                    class="w-full mt-4 h-80"
                                />

                                <InputError class="mt-2" :message="form.errors.logo" />
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
