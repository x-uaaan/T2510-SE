<template>
    <div class="min-h-screen bg-[#18191A] text-white font-['Inter']">
      <!-- Hero Section -->
      <section class="relative flex flex-col items-center justify-center min-h-screen px-4 text-center bg-black overflow-hidden">
        <!-- Centered watermark icon -->
        <img src="/image/CampusPulseIcon.png"
             alt="Campus Pulse Watermark"
             class="absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 opacity-10 w-[300px] h-[300px] z-0" />
        <div class="relative z-10 flex flex-col items-center">
          <!-- Centered logo above wordmark -->
          <img src="/image/CampusPulse.png" alt="Campus Pulse Logo" class="mx-auto mb-0 h-[125px]" />
          <p class="text-base text-gray-300 mb-8 max-w-2xl mx-auto whitespace-nowrap">
            The all-in-one alumni system to connect, collaborate, and stay engaged with your university community.
          </p>
          <a href="/auth/microsoft" class="learnmore-btn px-6 py-2 rounded shadow hover:bg-[#2386b7] text-base font-semibold transition">
            Learn More
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 12H21M21 12L14 5M21 12L14 19" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
          </a>
        </div>
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
        <a href="/auth/microsoft" class="bg-[#2D9CDB] text-white px-12 py-5 rounded shadow hover:bg-[#2386b7] text-xl font-semibold transition">Get Started with Microsoft</a>
      </section>
    </div>
<FooterSection />
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import AppLayout from '../Layouts/AppLayout.vue'

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

<style scoped>
.learnmore-btn {
  width: auto;
  display: flex;
  align-items: center;
  gap: 5px;
  background: #23242a;
  color: #fff;
  border: 1px solid #3d3e46; border-radius: 10px; padding: 10px 15px 10px 20px;
}
.learnmore-btn:hover {
  background: #2d2e35;
  border: 1px solid #3b82f6;
  box-shadow: 0 0 0 2px #3b82f688;
}
</style>