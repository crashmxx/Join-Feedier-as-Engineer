<script setup>
import { useForm } from '@inertiajs/vue3';

import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const form = useForm({
    description: '',
    email: '',
});
const props = defineProps({
    user: Object,
});

const submit = () => {
    form.post(route('feedbacks.store'), {
        onSuccess: () => {
            form.description = '';
            form.email = '';
        },
        onError: (errors) => {
            if (errors.feedback_limit) {
                form.feedbackLimitError = errors.feedback_limit;
            }
        }
    });
};
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Report a feedback
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                            <form @submit.prevent="submit">
                                <div>
                                    <InputLabel for="description" value="Describe your feedback" />
                                    <TextInput
                                        id="description"
                                        v-model="form.description"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                        autofocus
                                    />
                                    <InputError class="mt-2" :message="form.errors.description" />
                                </div>
                                <div>
                                <InputLabel for="email" value="Email" />
                                <TextInput v-if="!props.user"
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    required
                                /><p v-else>{{$props.user.email}}</p>
                                <InputError class="mt-2" :message="form.errors.email" />
                                <InputError class="mt-2" :message="form.feedbackLimitError" />
                                </div>
                                <div class="flex justify-end mt-4">
                                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Confirm
                                    </PrimaryButton>
                                </div>
                                <ActionMessage v-if="form.recentlySuccessful" class="ml-3 text-green-500">
                                    Your feedback has been taken into account.
                                </ActionMessage>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
