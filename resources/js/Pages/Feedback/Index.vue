<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm, usePage } from '@inertiajs/vue3';

const page = usePage();

const headers = ["id", "description", "email", "type", "created_at", "deleted_at"];

const props = defineProps({
    feedbacks: {
        type: Array,
        default: () => [],
    }
});


const form = useForm({});
function deleteFeedback(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route('feedbacks.destroy', id));
    }
}
function restoreFeedback(id) {
    if (confirm("Are you sure you want to restore this feedback?")) {
        form.patch(route('feedbacks.restore', id));
    }
}
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Feedback List
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div class="p-6 lg:p-8 bg-white border-b border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th v-for="header in headers" :key="header" scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ header }}
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="feedback in feedbacks" :key="feedback.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ feedback.id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ feedback.description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ feedback.email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ feedback.type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ feedback.created_at_fr }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ feedback.deleted_at_fr }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <template v-if="!feedback.deleted_at && page.props.can['feedbacks.destroy']">
                                            <button @click="deleteFeedback(feedback.id)" class="text-red-600 hover:text-red-900">Delete</button>
                                        </template>
                                        <template v-if="feedback.deleted_at && page.props.can['feedbacks.restore']">
                                            <button @click="restoreFeedback(feedback.id)" class="text-blue-600 hover:text-blue-900">Restore</button>
                                        </template>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
