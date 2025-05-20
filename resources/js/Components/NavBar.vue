<template>
  <nav class="flex justify-between items-center py-6 px-8 bg-white shadow">
    <a href="/">
      <img src="/image/CampusPulse.png" class="h-10" alt="Campus Pulse Logo" />
    </a>
    <div>
      <a href="/login" class="text-gray-700 mr-4 hover:underline">Login</a>
      <a href="/register" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 shadow">Sign Up</a>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'NavBar',
}
</script> 