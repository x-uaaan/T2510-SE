<template>
    <div class="min-h-screen bg-black text-white font-['Inter']">
      <!-- Hero Section -->
      <section ref="heroRef" :class="['transition-section', { visible: heroVisible }]" class="relative flex flex-col items-center justify-center min-h-screen px-4 text-center bg-black overflow-hidden">
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
          
          <div class="flex flex-col sm:flex-row gap-4 items-center">
            <a href="/auth/microsoft" class="learnmore-btn">
              Get Started with Microsoft
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 12H21M21 12L14 5M21 12L14 19" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
            </a>
          </div>
        </div>
      </section>

      <!-- Features Section -->
      <section ref="featuresRef" :class="['transition-section', { visible: featuresVisible }]" id="features" class="py-24 px-4 mb-24 bg-black">
        <div class="max-w-6xl mx-auto">
          <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6">Why Choose Campus Pulse?</h2>
            <p class="text-xl text-gray-400 max-w-3xl mx-auto">Everything you need to stay connected with your university community</p>
          </div>
          
          <div class="grid md:grid-cols-3 gap-8">
            <!-- Events Card -->
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-gray-700 hover:border-blue-500/50 transition-all duration-300 hover:transform hover:scale-105">
              <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
              </div>
              <h3 class="text-2xl font-bold text-white mb-4">Alumni Events</h3>
              <p class="text-gray-400 mb-6">Stay updated with upcoming alumni events, reunions, and activities. Register and connect with fellow alumni.</p>
            </div>
            <!-- Forum Card -->
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-gray-700 hover:border-blue-500/50 transition-all duration-300 hover:transform hover:scale-105">
              <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                </svg>
              </div>
              <h3 class="text-2xl font-bold text-white mb-4">Vibrant Forums</h3>
              <p class="text-gray-400 mb-6">Join lively discussions, share experiences, and seek advice in our dedicated alumni forums.</p>
            </div>

            <!-- Network Card -->
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-2xl p-8 border border-gray-700 hover:border-blue-500/50 transition-all duration-300 hover:transform hover:scale-105">
              <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
              </div>
              <h3 class="text-2xl font-bold text-white mb-4">Professional Network</h3>
              <p class="text-gray-400 mb-6">Build meaningful connections with fellow alumni and expand your professional network.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Event Section -->
      <section ref="eventRef" :class="['transition-section', { visible: eventVisible }]" id="events" class="py-24 px-4 mb-24 bg-black">
        <div class="max-w-6xl mx-auto flex flex-col lg:flex-row-reverse items-center gap-16">
          <div class="flex-1 space-y-8">
            <div class="inline-block bg-gradient-to-r from-blue-500/20 to-blue-600/20 px-4 py-2 rounded-full border border-blue-500/30">
              <span class="text-blue-400 font-medium">Events</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-white leading-tight">
              Stay Connected Through 
              <span class="bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">Alumni Events</span>
            </h2>
            <p class="text-gray-400 leading-relaxed">
              From reunions to networking events, workshops to social gatherings - stay updated with all the exciting activities happening in your alumni community. Register for events and make the most of your university network.
            </p>
          </div>
          <div class="flex-1">
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl p-8 border border-gray-700 shadow-2xl">
              <div class="space-y-6">
                <div class="flex items-center justify-between">
                  <div class="text-white font-bold text-lg">Upcoming Events</div>
                  <div class="text-blue-400 text-sm">View All</div>
                </div>
                <div class="space-y-4">
                  <div class="bg-gray-700/50 rounded-lg p-4">
                    <div class="text-white font-medium">Alumni Reunion 2024</div>
                    <div class="text-gray-400 text-sm">Dec 15, 2024 • Virtual</div>
                  </div>
                  <div class="bg-gray-700/50 rounded-lg p-4">
                    <div class="text-white font-medium">Career Networking</div>
                    <div class="text-gray-400 text-sm">Dec 20, 2024 • On-site</div>
                  </div>
                  <div class="bg-gray-700/50 rounded-lg p-4">
                    <div class="text-white font-medium">Workshop Series</div>
                    <div class="text-gray-400 text-sm">Jan 5, 2025 • Hybrid</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      
      <!-- Forum Section -->
      <section ref="forumRef" :class="['transition-section', { visible: forumVisible }]" id="forum" class="py-24 px-4 mb-24 bg-black">
        <div class="max-w-6xl mx-auto flex flex-col lg:flex-row items-center gap-16">
          <div class="flex-1 space-y-8">
            <div class="inline-block bg-gradient-to-r from-blue-500/20 to-blue-600/20 px-4 py-2 rounded-full border border-blue-500/30">
              <span class="text-blue-400 font-medium">Community</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold text-white leading-tight">
              Join the Conversation in Our 
              <span class="bg-gradient-to-r from-blue-400 to-blue-600 bg-clip-text text-transparent">Vibrant Forums</span>
            </h2>
            <p class="text-gray-400 leading-relaxed">
              Whether you want to reconnect with old friends, network with professionals, or start a new topic, Campus Pulse forums are the place to be. Share experiences, seek advice, and build lasting connections.
            </p>
          </div>
          <div class="flex-1">
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl p-8 border border-gray-700 shadow-2xl">
              <div class="space-y-4">
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 bg-blue-500 rounded-full"></div>
                  <div>
                    <div class="text-white font-medium">Alumni Network</div>
                    <div class="text-gray-400 text-sm">Professional discussions</div>
                  </div>
                </div>
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 bg-blue-500 rounded-full"></div>
                  <div>
                    <div class="text-white font-medium">Student Life</div>
                    <div class="text-gray-400 text-sm">Campus memories & stories</div>
                  </div>
                </div>
                <div class="flex items-center gap-3">
                  <div class="w-10 h-10 bg-blue-500 rounded-full"></div>
                  <div>
                    <div class="text-white font-medium">Career Advice</div>
                    <div class="text-gray-400 text-sm">Professional guidance</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Call to Action -->
      <section class="py-20 px-4 flex flex-col items-center justify-center bg-black">
        <div class="w-full max-w-xl bg-black border-gray-800 rounded-2xl shadow-lg flex flex-col items-center gap-2 py-12 px-6">
          <h2 class="text-2xl font-bold text-white mb-2">Ready to get started?</h2>
          <p class="text-gray-400 mb-6 text-center">Join the Campus Pulse community or learn more about our platform.</p>
          <div class="flex flex-col sm:flex-row gap-6 w-full justify-center">
            <a href="/auth/microsoft" class="learnmore-btn short-btn flex-1 text-center justify-center">Get Started</a>
            <a href="/about" class="learnmore-btn short-btn flex-1 text-center justify-center">Learn More</a>
          </div>
        </div>
      </section>
    </div>
    <FooterSection />
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import FooterSection from '@/Components/FooterSection.vue'
import ForumListItem from '@/Components/forums/ForumListItem.vue'
import EventListItem from '@/Components/events/EventListItem.vue'

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

const sampleForum = {
  forumID: 1,
  forumTitle: 'Technology & Innovation',
  Categories: 'General, Projects',
  forumDesc: 'Share ideas about technology, discuss innovations, and collaborate on tech projects.',
  posts_count: 2
}

const sampleEvent = {
  id: 1,
  eventName: 'Tech Talk: Future of Robotics',
  organiser: 'Campus Pulse',
  capacity: 150,
  eventVenue: 'Engineering Block Seminar Hall',
  image: '',
  startDate: '2025-07-01',
  startTime: '10:00'
}

// Intersection Observer for transitions
const heroRef = ref(null)
const featuresRef = ref(null)
const forumRef = ref(null)
const eventRef = ref(null)
const bottomBtnRef = ref(null)
const heroVisible = ref(false)
const featuresVisible = ref(false)
const forumVisible = ref(false)
const eventVisible = ref(false)
const bottomBtnVisible = ref(false)

function observeSection(refEl, visibleRef) {
  const observer = new window.IntersectionObserver(
    ([entry]) => {
      if (entry.isIntersecting) visibleRef.value = true
    },
    { threshold: 0.15 }
  )
  if (refEl.value) observer.observe(refEl.value)
  return observer
}

let observers = []
onMounted(() => {
  observers.push(observeSection(heroRef, heroVisible))
  observers.push(observeSection(featuresRef, featuresVisible))
  observers.push(observeSection(forumRef, forumVisible))
  observers.push(observeSection(eventRef, eventVisible))
  observers.push(observeSection(bottomBtnRef, bottomBtnVisible))
})
onUnmounted(() => {
  observers.forEach(o => o.disconnect())
})
</script>

<style scoped>
/* Custom scrollbar */
::-webkit-scrollbar {
  width: 8px;
}

::-webkit-scrollbar-track {
  background: #1f2937;
}

::-webkit-scrollbar-thumb {
  background: #4b5563;
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: #6b7280;
}

.learnmore-btn {
  width: auto;
  display: flex;
  align-items: center;
  gap: 5px;
  background: #2d2e35;
  color: #fff;
  border: 1px solid #3b82f6;
  border-radius: 10px;
  padding: 10px 15px 10px 20px;
  font-weight: 600;
  box-shadow: 0 0 0 2px #3b82f688;
  transition: background 0.2s, border 0.2s, box-shadow 0.2s;
  cursor: pointer;
  justify-content: center;
  text-decoration: none;
  animation: pulse-glow 1.5s infinite alternate;
}
@keyframes pulse-glow {
  0% {
    box-shadow: 0 0 0 2px #3b82f688, 0 0 8px 2px #3b82f688;
    border-color: #3b82f6;
  }
  100% {
    box-shadow: 0 0 0 4px #3b82f644, 0 0 12px 6px #3b82f6cc;
    border-color: #fff;
  }
}
.short-btn {
  padding: 8px 18px 8px 18px;
  font-size: 1rem;
  min-width: 120px;
  max-width: 180px;
}

.transition-section {
  opacity: 0;
  transform: translateY(40px);
  transition: opacity 0.7s cubic-bezier(0.4,0,0.2,1), transform 0.7s cubic-bezier(0.4,0,0.2,1);
}
.transition-section.visible {
  opacity: 1;
  transform: translateY(0);
}
</style>