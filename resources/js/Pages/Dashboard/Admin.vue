<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';

const page = usePage();
const user = ref(page.props.auth.user);
onMounted(() => {
    // You can perform any setup actions here, like fetching additional data
    console.log('Admin Dashboard mounted', user.value);
});
</script>

<template>
    <div class="w-full bg-gray-500 py-4 text-center text-black">
        <h1 class="text-2xl font-semibold">Admin Dashboard</h1>
    </div>
    <div class="mx-auto mt-6 max-w-4xl rounded-lg bg-white p-6 shadow-md">
        <p class="mb-6 text-gray-700">
            Welcome to the admin dashboard. Here you can manage users, view
            reports, and configure settings.
        </p>
        <div class="flex flex-row gap-10">
            <Link href="">Manage Users</Link>
            <Link  href=""
                >View Reports</Link
            >
            <Link  href=""
                >Settings</Link
            >
            <Link  href="/logout" method="post"
                >Logout</Link
            >
        </div>
    </div>
</template>

<style scoped>

a {
    @apply text-gray-500 hover:text-green-500 border-b border-gray-200 hover:border-green-500 transition-colors duration-300;
}

</style>
