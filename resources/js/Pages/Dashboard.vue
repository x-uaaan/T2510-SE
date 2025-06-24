<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import UserEngagementChart from '@/Components/charts/UserEngagementChart.vue';
import FooterSection from '@/Components/FooterSection.vue';

const props = defineProps({
    stats: Object,
    chartData: Object
});
</script>

<template>
    <Head title="Admin Dashboard" />
    <AppLayout>
        <div class="min-h-screen flex flex-col">
            <div class="flex-1 p-4 sm:p-6 lg:p-8">
                <!-- Stat Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-slate-800 rounded-xl shadow p-6 flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-400">Events</div>
                            <div class="text-3xl font-bold">{{ stats.events }}</div>
                        </div>
                        <div class="text-blue-500">
                            <svg class="h-12 w-12" id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"><line x1="0.55" y1="22.5" x2="23.45" y2="22.5"></line><line x1="9.14" y1="1.5" x2="21.55" y2="22.5"></line><line x1="14.86" y1="1.5" x2="2.45" y2="22.5"></line><polygon points="15.82 22.5 8.18 22.5 12 14.86 15.82 22.5"></polygon></svg>
                        </div>
                    </div>

                    <div class="bg-slate-800 rounded-xl shadow p-6 flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-400">Forums</div>
                            <div class="text-3xl font-bold">{{ stats.forums }}</div>
                        </div>
                        <div class="text-blue-500">
                            <svg class="h-12 w-12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-width="1.5"><path d="M3 5V20.7929C3 21.2383 3.53857 21.4614 3.85355 21.1464L7.70711 17.2929C7.89464 17.1054 8.149 17 8.41421 17H19C20.1046 17 21 16.1046 21 15V5C21 3.89543 20.1046 3 19 3H5C3.89543 3 3 3.89543 3 5Z" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </div>
                    </div>

                    <div class="bg-slate-800 rounded-xl shadow p-6 flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-400">Posts</div>
                            <div class="text-3xl font-bold">{{ stats.posts }}</div>
                        </div>
                        <div class="text-blue-500">
                            <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 12h.01M12 12h.01M15.75 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>

                    <div class="bg-slate-800 rounded-xl shadow p-6 flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-400">Alumni & Lecturers</div>
                            <div class="text-3xl font-bold">{{ stats.users }}</div>
                        </div>
                        <div class="text-blue-500">
                            <svg class="h-12 w-12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"><circle stroke-miterlimit="10" cx="12" cy="7.25" r="5.73"></circle><path stroke-miterlimit="10" d="M1.5,23.48l.37-2.05A10.3,10.3,0,0,1,12,13h0a10.3,10.3,0,0,1,10.13,8.45l.37,2.05"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- User Engagement Chart -->
                <div class="bg-slate-800 rounded-xl shadow p-4 md:p-6">
                    <h3 class="text-lg font-semibold text-gray-300 mb-4">User Engagement</h3>
                    <div class="h-96">
                        <UserEngagementChart :chartData="chartData" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
