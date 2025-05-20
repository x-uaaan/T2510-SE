<template>
  <div class="min-h-screen bg-[#18191A] text-white font-['Inter']">
    <!-- Top Bar with Login and Sign Up -->
    <div
      class="w-full flex justify-end items-center px-8 py-6 bg-[#18191A] fixed top-0 left-0 z-50 shadow transition-transform duration-300"
      :style="{ transform: showBar ? 'translateY(0)' : 'translateY(-100%)' }"
    >
      <a href="/login" class="text-white text-lg font-medium px-4 py-2 rounded hover:bg-[#2D9CDB] mr-2">Login</a>
      <a href="/register" class="bg-[#2D9CDB] text-white text-lg font-medium px-4 py-2 rounded hover:bg-[#2386b7]">Sign Up</a>
    </div>
    <div class="pt-28"> <!-- Add padding top to offset fixed bar -->
      <!-- Hero Section -->
      <section class="flex flex-col items-center justify-center py-32 px-4 text-center">
        <img src="/image/CampusPulseIcon.png" alt="Campus Pulse Logo" class="h-32 w-32 mb-8 mx-auto" />
        <h1 class="text-6xl font-extrabold text-white mb-6">Welcome to Campus Pulse</h1>
        <p class="text-2xl text-gray-300 max-w-2xl mx-auto mb-10">
          The all-in-one alumni system to connect, collaborate, and stay engaged with your university community.
        </p>
        <a href="#forum" class="bg-[#2D9CDB] text-white px-10 py-4 rounded shadow hover:bg-[#2386b7] text-xl font-semibold transition">Learn More</a>
      </section>

      <!-- Forum Section -->
      <section id="forum" class="py-32 px-4 bg-[#232323]">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center gap-16">
          <div class="flex-1">
            <h2 class="text-4xl font-bold text-white mb-6">Vibrant Alumni Forums</h2>
            <p class="text-xl text-gray-300 mb-8">
              Join lively discussions, share experiences, and seek advice in our dedicated alumni forums. Whether you want to reconnect with old friends, network with professionals, or start a new topic, Campus Pulse forums are the place to be.
            </p>
            <a href="/forums" class="bg-[#2D9CDB] text-white px-8 py-3 rounded hover:bg-[#2386b7] font-medium text-lg">Explore Forums</a>
          </div>
          <img src="/image/forum-illustration.png" class="flex-1 max-w-sm rounded-lg shadow" alt="Forum Illustration" />
        </div>
      </section>

      <!-- Event Section -->
      <section id="events" class="py-32 px-4 bg-[#18191A]">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row-reverse items-center gap-16">
          <div class="flex-1">
            <h2 class="text-4xl font-bold text-white mb-6">Alumni Events & Activities</h2>
            <p class="text-xl text-gray-300 mb-8">
              Stay updated with upcoming alumni events, reunions, and activities. Register for events, connect with fellow alumni, and make the most of your university network.
            </p>
            <a href="/events" class="bg-[#2D9CDB] text-white px-8 py-3 rounded hover:bg-[#2386b7] font-medium text-lg">View Events</a>
          </div>
          <img src="/image/events-illustration.png" class="flex-1 max-w-sm rounded-lg shadow" alt="Events Illustration" />
        </div>
      </section>

      <!-- Call to Action -->
      <section class="py-32 px-4 text-center bg-[#232323]">
        <h2 class="text-4xl font-bold text-white mb-6">Ready to Connect?</h2>
        <p class="text-xl text-gray-300 mb-10">Sign up now and become part of the vibrant Campus Pulse alumni community.</p>
        <a href="/register" class="bg-[#2D9CDB] text-white px-12 py-5 rounded shadow hover:bg-[#2386b7] text-xl font-semibold transition">Get Started</a>
      </section>

      <!-- Footer -->
      <footer class="bg-[#101112] text-gray-400 py-10 text-center">
        <p>© 2024 Campus Pulse. All rights reserved.</p>
      </footer>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const showBar = ref(true)
let lastScrollY = window.scrollY

const handleScroll = () => {
  if (window.scrollY < 10) {
    showBar.value = true
  } else if (window.scrollY > lastScrollY) {
    showBar.value = false // scrolling down
  } else {
    showBar.value = true // scrolling up
  }
  lastScrollY = window.scrollY
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})
onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>
